{{-- route('product.products.index',['include'=>"translations"]) thêm query cho route--}} 
{{-- {{ Request::is('dashboard*') ? 'active' : '' }} --}}


@can('home')
<li class="{{ active_class( if_uri_pattern('dashboard') ) }}">
    <a href="{{ route('dashboard') }}"><i class="fa fa-edit"></i><span>Dashboard</span></a>
</li>
@endcan
@can('category.categories.index')
<li class="{{ active_class( if_uri_pattern('category/categories*') ) }}">
    <a href="{{ route('category.categories.index') }}"><i class="fa fa-edit"></i><span>Categories</span></a>
</li>
@endcan
@can('product.products.index')
<li class="{{ active_class( if_uri_pattern('product/products*') ) }}">
    <a href="{{ route('product.products.index') }}"><i class="fa fa-edit"></i><span>Products</span></a>
</li>
@endcan
@can('core.locales.index')
<li class="{{ active_class( if_uri_pattern('core/locales*') ) }}">
    <a href="{{ route('locales.index') }}"><i class="fa fa-edit"></i><span>Locales</span></a>
</li>
@endcan
@can('attribute.attributeGroups.index')
<li class="{{ active_class( if_uri_pattern('attribute/attributeGroups*') ) }}">
    <a href="{{ route('attributeGroups.index') }}"><i class="fa fa-edit"></i><span>Attribute Groups</span></a>
</li>
@endcan
@can('attribute.attributes.index')
<li class="{{ active_class( if_uri_pattern('attribute/attributes*') ) }}">
    <a href="{{ route('attributes.index') }}"><i class="fa fa-edit"></i><span>Attributes</span></a>
</li>
@endcan
@can('core.currencies.index')
<li class="{{ active_class( if_uri_pattern('core/currencies*') ) }}">
    <a href="{{ route('currencies.index') }}"><i class="fa fa-edit"></i><span>Currencies</span></a>
</li>
@endcan
@can('core.configs.index')
<li class="{{ active_class( if_uri_pattern('core/configs*') ) }}">
    <a href="{{ route('configs.index') }}"><i class="fa fa-edit"></i><span>Configs</span></a>
</li>
@endcan
@can('users.index')
<li class="{{ active_class( if_uri_pattern('users*') ) }}">
    <a href="{{ route('users.index') }}"><i class="fa fa-user"></i><span>Users</span></a>
</li>
@endcan
@can('authorization.permissions.index')
<li class="{{ active_class( if_uri_pattern('authorization/permissions*') ) }}">
    <a href="{{ route('authorization.permissions.index') }}"><i class="fa fa-edit"></i><span>Permissions</span></a>
</li>
@endcan
@can('authorization.roles.index')
<li class="{{ active_class( if_uri_pattern('authorization/roles*') ) }}">
    <a href="{{ route('roles.index') }}"><i class="fa fa-edit"></i><span>Roles</span></a>
</li>
@endcan


@can('customer.customers.index')
<li class="{{ active_class( if_uri_pattern('customer/customers*') ) }}">
    <a href="{{ route('customers.index') }}"><i class="fa fa-edit"></i><span>Customers</span></a>
</li>
@endcan
@can('customer.customerGroups.index')
<li class="{{ active_class( if_uri_pattern('customer/customerGroups*') ) }}">
    <a href="{{ route('customerGroups.index') }}"><i class="fa fa-edit"></i><span>Customer Groups</span></a>
</li>

@endcan
<li class="{{ active_class( if_uri_pattern('order*') ) }}">
    <a href="{{ route('order.orders.index') }}"><i class="fa fa-edit"></i><span>orders</span></a>
</li>
<li class="{{ active_class( if_uri_pattern('coupon/cuopons*') ) }}">
    <a href="{{ route('coupon.cuopons.index') }}"><i class="fa fa-edit"></i><span>Cuopons</span></a>
</li>

