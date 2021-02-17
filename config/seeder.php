<?php

use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeGroup;
use App\Models\Attribute\AttributeOption;
use App\Models\Category\Category;
use App\Models\Category\CategoryAttributeGroup;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerGroup;
use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductAttributeOption;
use App\Models\Product\ProductCategory;

${AttributeGroup::class} = 5;
${Attribute::class} = 5;
${CustomerGroup::class} = 2;
${Customer::class} = 20;
${Category::class} = 5;
${CategoryAttributeGroup::class} = 5;
${Product::class} = 100;
${ProductCategory::class} = 3;
${ProductAttribute::class} = 3;
${ProductAttributeOption::class} = 3;
${AttributeOption::class} = 3;

return [
    AttributeGroup::class => ${AttributeGroup::class},
    CustomerGroup::class => ${AttributeGroup::class},
    Customer::class => ${AttributeGroup::class},
    Category::class => ${Category::class},
    CategoryAttributeGroup::class => ${CategoryAttributeGroup::class},
    Product::class => ${Product::class},
    ProductCategory::class => ${ProductCategory::class},
    ProductAttribute::class => ${ProductAttribute::class},
    ProductAttributeOption::class => ${ProductAttributeOption::class},
    AttributeOption::class => ${AttributeOption::class},
    Attribute::class => ${Attribute::class},
];