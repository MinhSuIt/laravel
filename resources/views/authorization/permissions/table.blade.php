<div class="table-responsive">
    <table class="table" id="permissions-table">
        <thead>
            <tr>
                <th>Name</th>
        {{-- <th>Guard Name</th> --}}
        <th>Roles</th>
                
            </tr>
        </thead>
        <tbody>
        @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->name }}</td>
            {{-- <td>{{ $permission->guard_name }}</td> --}}
            <td>
                @php $roles = $permission->roles; @endphp
                @foreach ($roles as $item)
                    {{$item->name}} @if(!$loop->last) {{','}}@endif
                @endforeach
            
            </td>
                
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $permissions->withQueryString()->links() }}

</div>
