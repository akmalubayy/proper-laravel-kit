<x-master-layout>
    @section('title')
    User
    @endsection

    <!-- Start Content -->
    <x-data-table id="userTable" title="User Management" moduleName="User" :columns="$columns"
        singleDeleteRoute="{{ route('users.destroy', ':id') }}" multipleDeleteRoute="{{ route('users.deletes') }}">
        <tr>
            <th class="center">
                <label class="pos-rel">
                    <input type="checkbox" name="main_checkbox" class="ace" />
                    <span class="lbl"></span>
                </label>
            </th>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created Date</th>
            <th>Action</th>
        </tr>
        <tbody>
            <!-- Konten tbody akan diisi oleh JavaScript atau server-side processing -->
        </tbody>
    </x-data-table>
    <!-- End Content -->
</x-master-layout>