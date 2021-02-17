<?php

use App\Models\Core\Config;
use App\Repositories\Authorization\PermissionRepository;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $super_admin = new Role();
        $super_admin->name ='Super Admin';
        $super_admin->guard_name ='web';
        $super_admin->save();

        $manager = new Role();
        $manager->name ='Manager';
        $manager->guard_name ='web';
        $manager->save();

        //sync route to roles
        $arr = collect();
        $arr_manager = collect();
        $routes = Route::getRoutes()->getIterator();
        foreach ($routes as $route) {
            $name = $route->getName();
            if (!is_null($name) && strpos($name, 'api') !== 0){
                $permission = app()->make(PermissionRepository::class)->create(['name' => $route->getName()]);
                $arr->push($permission->id);
                if(Str::of($name)->startsWith('product') || Str::of($name)->startsWith('category')){
                    $arr_manager->push($permission->id);
                }
            }
        }
        $super_admin->permissions()->sync($arr);
        $manager->permissions()->sync($arr_manager);


        $user = new User();
        $user->name = 'Đỗ Minh Sử';
        $user->email = 'su@gmail.com';
        $user->password = Hash::make('su@gmail.com');
        $user->save();
        $user->syncRoles([$super_admin->name]);


        DB::table('configs')->insert(Config::CONFIGS);
    }
}
