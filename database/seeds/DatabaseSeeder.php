<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(OrderSeeder::class);
        //tạo file cấu hình số lượng model dc tạo từ factory
        $this->call(CoreSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(AttributeGroupSeeder::class);
        $this->call(AttributeSeeder::class);
        $this->call(AttributeOptionSeeder::class);
        
        $this->call(CategorySeeder::class);

        $this->call(CategoryAttributeGroupSeeder::class);

        $this->call(ProductSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductAttributeSeeder::class);
        $this->call(ProductAttributeOptionSeeder::class);

        $this->call(CuoponsTableSeeder::class);

        $this->call(CustomerSeeder::class);

    }
}
