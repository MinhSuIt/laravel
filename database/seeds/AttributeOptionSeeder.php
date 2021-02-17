<?php

use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeGroup;
use App\Models\Attribute\AttributeGroupTranslation;
use App\Models\Attribute\AttributeOption;
use App\Models\Attribute\AttributeOptionTranslation;
use App\Models\Attribute\AttributeTranslation;
use Illuminate\Database\Seeder;

class AttributeOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < config('seeder.'.AttributeGroup::class) * config('seeder.' . Attribute::class); $i++) {
            $num =rand(1,config('seeder.' . AttributeOption::class));
            factory(AttributeOption::class, $num)->create([
                'attribute_id' => $i+1,
            ])->each(function ($attributeOption) {
                $attributeOption->translations()->save(factory(AttributeOptionTranslation::class)->make([
                    'attribute_option_id' => $attributeOption->id,
                    'locale' => 'vi'
                ]));
                $attributeOption->translations()->save(factory(AttributeOptionTranslation::class)->make([
                    'attribute_option_id' => $attributeOption->id,
                    'locale' => 'en'
                ]));
            });
        }
    }
}
