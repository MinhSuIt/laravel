<?php

namespace App\Http\Controllers;

use App\Models\Category\Category;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Error;
use Illuminate\Support\Collection;
use InfyOm\Generator\Utils\ResponseUtil;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Response;

abstract class AppBaseController extends Controller
{

    protected $permissionMiddlewareName;
    public function __construct()
    {
        // $this->permissionMiddlewareName = 'permission:' . request()->route()->getName();

        // $this->middleware($this->permissionMiddlewareName);
        $this->middleware('permission:' . request()->route()->getName());
    }

    //sử dụng obiefy/api-response thay vì viết 3 function bên dưới
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }
    // public abstract function setExport();
    // public abstract function setImport();
    // public function setExport()
    // {
    //     return false;
    // }
    // public function setImport()
    // {
    //     return false;
    // }
    // public function export()
    // {
    //     if ($export = $this->setExport()) {
    //         $name = now();
    //         return Excel::download(app()->make($export), "$name.xlsx");
    //     }
    //     return;
    // }
    // public function import()
    // {
    //     if ($import = $this->setImport()) {
    //         //  $headings = (new HeadingRowImport())->toArray(request()->file('fileexcel')); //mảng header của file
    //         //  if(!collect($headings)->flatten()->toArray()  == Category::IMPORT_HEADINGS ){
    //         //      return;
    //         //  }
    //         Excel::import(app()->make($import), request()->file('fileexcel'));
    //         // return back();
    //     }
    //     return;
    // }
    protected function setSeo(array $data)
    {
        SEOMeta::setTitle($data['title']);
        SEOMeta::setDescription($data['description']);
        SEOMeta::setKeywords($data['keywords']);
        SEOMeta::setCanonical($data['canonical']);

        // 'og:locale'=>app()->getLocale(), chưa hỗ trợ
        OpenGraph::setDescription($data['og:description']);
        OpenGraph::setTitle($data['og:title']);
        OpenGraph::setUrl($data['og:url']);
        OpenGraph::setSiteName($data['og:site_name']);
        OpenGraph::addProperty('type', $data['og:type']);
        // OpenGraph::addImage();

        TwitterCard::setTitle($data['wt:title']);
        TwitterCard::setDescription($data['wt:description']);
        TwitterCard::setType($data['wt:type']);
        TwitterCard::setSite($data['wt:site']);
        TwitterCard::setUrl($data['wt:url']);
        // TwitterCard::addImage();
    }
    public function prepareDataForSelectTag(Collection $collection, $isSelected = false, Collection $modelHasCollection)
    {
        $products = collect([]);
        foreach ($collection as $value) {
            $group = collect([]);

            $group->put(
                'id',
                $value->id

            );
            $group->put(
                'text',
                $value->name

            );
            if ($isSelected) {
                if ($modelHasCollection->contains('id', $value->id)) {
                    $group->put(
                        'selected',
                        true
                    );
                }
            }
            $products->push($group);
        }
        $products = $products->toArray();
        return $products;
    }
}
