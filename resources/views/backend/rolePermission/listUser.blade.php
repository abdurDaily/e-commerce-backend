@extends('backend.layout')
@section('backend_content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">User List</h5>
            <a href="{{ route('dashboard.role.permission.create.user') }}" class="btn btn-secondary  ">Return Back</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover table-striped">
                <tbody>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>

                    @forelse ($users as $key=>$user)
                        <tr class="text-center" data-role-id="1">
                            <td>{{ ++$key }}</td>
                            <td class="role-name">{{ $user->name }}</td>
                            <td class="role-name">{{ $user->email }}</td>
                            <td>
                                <div>
                                    <a data-edit-id="1" href="{{ route('dashboard.role.permission.edit.user', $user->id) }}"
                                        class="editRole btn btn-outline-primary d-inline-flex align-items-center justify-content-center p-1">
                                        <iconify-icon icon="lucide:edit" width="16" height="16"></iconify-icon>
                                    </a>
                                    &nbsp;
                                    <a href="#"
                                        class="btn btn-outline-danger d-inline-flex justify-content-center p-1 delete_role"
                                        data-id="1">
                                        <iconify-icon icon="icon-park-outline:delete" width="16"
                                            height="16"></iconify-icon>
                                    </a>
                                    &nbsp;
                                    <a href="{{ route('dashboard.role.permission.assign.role.user', $user->id) }}"
                                        class="btn btn-outline-info d-inline-flex align-items-center justify-content-center p-1">
                                        <iconify-icon icon="hugeicons:authorized" width="16"
                                            height="16"></iconify-icon>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>No data found..</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">

            </div>
        </div>
    </div>
@endsection
