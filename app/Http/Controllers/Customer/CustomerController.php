<?php

namespace App\Http\Controllers\Customer;

use App\Events\RegisterCustomerEvent;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Repositories\Customer\CustomerRepository;
use App\Http\Controllers\AppBaseController;
use App\Jobs\CustomerRegisterSendMailJob;
use App\Mail\CustomerRegisterMail;
use App\Models\Category\Category;
use App\Models\Customer\Customer;
use App\Notifications\RegisterCustomerNotification;
use App\Repositories\Customer\CustomerGroupRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Response;

class CustomerController extends AppBaseController
{
    /** @var  CustomerRepository */
    private $customerRepository;
    private $customerGroupRepository;

    public function __construct(CustomerRepository $customerRepo, CustomerGroupRepository $customerGroupRepository)
    {
        parent::__construct();
        $this->customerRepository = $customerRepo;
        $this->customerGroupRepository = $customerGroupRepository;

        $this->middleware($this->customerRepository->model()::COLLECTION_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->customerRepository->model()::COLLECTION_TAG, ['only' => ['index']]);
        $this->middleware($this->customerRepository->model()::CREATE_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->customerRepository->model()::CREATE_TAG, ['only' => ['create']]);
        $this->middleware($this->customerRepository->model()::SHOW_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->customerRepository->model()::SHOW_TAG, ['only' => ['show']]);
        $this->middleware($this->customerRepository->model()::EDIT_TAG_TIME. "," .config('app.cacheResponseMiddleware') . "," . $this->customerRepository->model()::EDIT_TAG, ['only' => ['edit']]);
    }

    /**
     * Display a listing of the Customer.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $request->merge(['include' => 'customerGroup']);
        $customers = $this->customerRepository->paginate();
        $groups = $this->customerGroupRepository->getAll();

        $this->setSeo([
            'title' => 'customers index',
            'description' => 'customers description',
            'keywords' => 'customers keywords',
            'canonical' => url()->current(), //ko bao gồm # (nội link) và ko có các query string

            'og:type' => 'og type',
            'og:title' => 'og title',
            'og:description' => 'og decs',
            'og:url' => url()->current(),
            'og:site_name' => config('app.name'),

            'wt:type' => 'wt:type',
            'wt:title' => 'wt:title',
            'wt:description' => 'wt:description',
            'wt:url' => url()->current(),
            'wt:site' => config('app.name'),
        ]);
        return view('customer.customers.index', compact('groups'))
            ->with('customers', $customers);
    }

    /**
     * Show the form for creating a new Customer.
     *
     * @return Response
     */
    public function create()
    {
        $group = $this->customerGroupRepository->all();

        $group = $group->mapWithKeys(function ($item) {
            $name = $item->translate(app()->getLocale(), true)->name;
            return [$item->id => $name];
        })->all();

        $this->setSeo([
            'title' => 'customers create',
            'description' => 'customers description',
            'keywords' => 'customers keywords',
            'canonical' => url()->current(), //ko bao gồm # (nội link) và ko có các query string

            'og:type' => 'og type',
            'og:title' => 'og title',
            'og:description' => 'og decs',
            'og:url' => url()->current(),
            'og:site_name' => config('app.name'),

            'wt:type' => 'wt:type',
            'wt:title' => 'wt:title',
            'wt:description' => 'wt:description',
            'wt:url' => url()->current(),
            'wt:site' => config('app.name'),
        ]);

        return view('customer.customers.create', compact('group'));
    }



    /**
     * Store a newly created Customer in storage.
     *
     * @param CreateCustomerRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->customerRepository->model()::getAddRules());

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $customer = $this->customerRepository->create($input);

        Flash::success('Customer saved successfully.');

        //sử dụng event queue
        event(new RegisterCustomerEvent($customer));

        //sử dụng notification queue
        //setup data
        $category = factory(Category::class)->make();

        // //send one 
        $customer->notify(new RegisterCustomerNotification($category));
        // //send multi,ví dụ có sản phẩm mới
        Notification::send($this->customerRepository->getAll(), new RegisterCustomerNotification($category));
        // //sử dụng mail queue
        Mail::to('asdasd@gmail.com')->queue(new CustomerRegisterMail($customer));

        // //sử dụng queue job
        dispatch(new CustomerRegisterSendMailJob($customer))->onQueue('emails')->delay(now()->addMinutes(1));


        //cài đặt QUEUE_CONNECTION trong config.queue là database,thay vì sử dụng queue trong mail sử dụng luôn queue job đỡ học nhiều
        //onQueue là tên queue, nếu ko có sẽ lấy queue default trong config.queue.database.queue
        //php artisan queue:work --queue=high,default : xác định queue nào đc chạy
        //php artisan queue:listen tự động lắng nghe
        //--tries=3 số lần tối đa thực hiện của 1 job , 
        // --timeout=30 thời gian tối đa 1 job thực hiện , 
        // khi hết hạn mà vẫn còn số lần try sẽ lặp lại công việc sau retry_after trong config (timeout bắt buộc dài hơn retry_after)   

        // Job Batching: gần giống promise all,tương tác giữa các job
        //php artisan queue:work redis : gọi queue connection cụ thể
        //php artisan queue:work --once chỉ 1 job đc chạy trong queue tại 1 thời điểm
        //php artisan queue:work --max-jobs=1000 hướng dẫn công nhân xử lý số lượng công việc đã cho và sau đó thoát. 
        // hữu ích khi được kết hợp với Supervisor để công nhân của bạn tự động khởi động lại sau khi xử lý một số công việc nhất định:

        //--stop-when-empty hướng dẫn nhân viên xử lý tất cả các công việc và sau đó thoát một cách duyên dáng. 
        // hữu ích khi làm việc hàng đợi Laravel trong vùng chứa Docker nếu bạn muốn tắt vùng chứa sau khi hàng đợi trống


        // --max-time chướng dẫn nhân viên xử lý công việc trong một số giây nhất định và sau đó thoát. 
        // hữu ích khi được kết hợp với Supervisor để công nhân của bạn tự động khởi động lại sau khi xử lý công việc trong một khoảng thời gian nhất định

        // queue:restart:Vì queue job là tồn tại lâu dài(có thể chưa xử lý hết tất cả các job), 
        // họ sẽ không nhận các thay đổi đối với mã của bạn mà không được khởi động lại. 
        // Vì vậy, cách đơn giản nhất để triển khai một ứng dụng sử dụng công nhân hàng đợi là khởi động lại công nhân trong quá trình triển khai của bạn. 
        // Bạn có thể khởi động lại tất cả các worker một cách duyên dáng


        // Khi các công việc có sẵn trên hàng đợi, công nhân sẽ tiếp tục xử lý các công việc mà không có sự chậm trễ giữa chúng. 
        // Tuy nhiên, --sleep=3 xác định thời gian (tính bằng giây) công nhân sẽ "ngủ" nếu không có công việc mới. 
        // Trong khi ngủ, công nhân sẽ không xử lý bất kỳ công việc mới nào - các công việc sẽ được xử lý sau khi công nhân thức dậy trở lại.

        //xử lý fail, php artisan queue:failed-table ,php artisan migrate
        // --backoff =3 đợi bao nhiêu giây trước khi thử lại một công việc bị lỗi, mặc định, một công việc được thử lại ngay lập tức
        //khai báo trong job class :public $backoff = 3 hoặc public function backoff() {return 3;}||return [1, 5, 10];
        // public function failed(Throwable $exception) trong class job :thực hiện công việc cụ thể khi xảy ra lỗi. 
        // Đây là vị trí hoàn hảo để gửi cảnh báo cho người dùng của bạn
        //Failed Job Events,job event
        //Retrying Failed Jobs: php artisan queue:failed
        //php artisan queue:retry 5 6 7 8 9 10: cụ thể id ,php artisan queue:retry --range=5-10 :từ id...đến id,php artisan queue:retry all
        //php artisan queue:forget 5: xóa 1 job fail với id ,php artisan queue:flush: xóa tất cả job fail 
        //xóa job nếu model ko tồn tại: public $deleteWhenMissingModels = true;
        //tìm hiểu Supervisor(linux)

        return redirect(route('customers.index'));
    }

    /**
     * Display the specified Customer.
     *
     * @param int $id
     *
     * @return Response
     */
    // public function show($id)
    // {
    //     $customer = $this->customerRepository->find($id);

    //     if (empty($customer)) {
    //         Flash::error('Customer not found');

    //         return redirect(route('customer.customers.index'));
    //     }

    //     return view('customer.customers.show')->with('customer', $customer);
    // }

    /**
     * Show the form for editing the specified Customer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }
        $this->setSeo([
            'title' => 'customers edit ' . $customer->name,
            'description' => 'customers description',
            'keywords' => 'customers keywords',
            'canonical' => url()->current(), //ko bao gồm # (nội link) và ko có các query string

            'og:type' => 'og type',
            'og:title' => 'og title',
            'og:description' => 'og decs',
            'og:url' => url()->current(),
            'og:site_name' => config('app.name'),

            'wt:type' => 'wt:type',
            'wt:title' => 'wt:title',
            'wt:description' => 'wt:description',
            'wt:url' => url()->current(),
            'wt:site' => config('app.name'),
        ]);
        return view('customer.customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param int $id
     * @param UpdateCustomerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerRequest $request)
    {
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }
        $validatedData = $request->validate(array_merge($this->customerRepository->model()::getEditRules($customer->id)));

        $customer = $this->customerRepository->update($request->all(), $id);

        Flash::success('Customer updated successfully.');

        return redirect(route('customers.index'));
    }

    /**
     * Remove the specified Customer from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customer = $this->customerRepository->find($id);

        if (empty($customer)) {
            Flash::error('Customer not found');

            return redirect(route('customers.index'));
        }

        $this->customerRepository->delete($id);

        Flash::success('Customer deleted successfully.');

        return redirect(route('customers.index'));
    }
}
