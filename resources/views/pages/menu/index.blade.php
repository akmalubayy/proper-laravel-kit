<x-master-layout>
    @section('title')
    Menu
    @endsection

    <x-data-table id="menuTable" title="Menu Management" moduleName="Menu" :columns="$columns"
        statusChangeRoute="{{ route('menus.status-change') }}" singleDeleteRoute="{{ route('menus.destroy', ':id') }}"
        multipleDeleteRoute="{{ route('menus.deletes') }}">
        <tr>
            <th class="center">
                <label class="pos-rel">
                    <input type="checkbox" name="main_checkbox" class="ace" />
                    <span class="lbl"></span>
                </label>
            </th>
            <th>#</th>
            <th>Title</th>
            <th>Url</th>
            <th>Icon</th>
            <th>Order</th>
            <th>OFF/ON</th>
            <th>Action</th>
        </tr>
    </x-data-table>
</x-master-layout>