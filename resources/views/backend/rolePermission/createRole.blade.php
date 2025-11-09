@extends('backend.layout')

@section('backend_content')
<div class="card p-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Created role list</h4>
        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Create new
            Role</button>
    </div>
    <!-- Create Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="role_permission" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="role_permission">Create new Role</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="roleForm" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="role_name" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="role_name" name="role_name"
                                placeholder="Enter role name">
                            <small class="text-danger" id="role_name_error"></small>
                        </div>
                        <div class="modal-footer d-flex justify-content-end p-0 m-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit role modal-->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="edit_role_permission" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="edit_role_permission">Edit role name</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editRoleForm" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_role_id" name="role_id">
                        <div class="mb-3">
                            <label for="edit_role_name" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="edit_role_name" name="role_name"
                                placeholder="Enter role name">
                            <small class="text-danger" id="edit_role_name_error"></small>
                        </div>
                        <div class="modal-footer d-flex justify-content-end p-0 m-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
            <tr class="text-center">
                <th>#</th>
                <th>Role Name</th>
                <th>Action</th>
            </tr>
            @forelse ($roles as $key => $role)
            <tr class="text-center" data-role-id="{{ $role->id }}">
                <td>{{ ++$key }}</td>
                <td class="role-name">{{ $role->name }}</td>
                <td>
                    <div>
                        <a data-edit-id="{{ $role->id }}" href="#" class="editRole btn btn-outline-primary d-inline-flex align-items-center justify-content-center p-2">
                            <iconify-icon icon="lucide:edit" width="24" height="24"></iconify-icon>
                        </a>
                        &nbsp;
                        <a href="#" class="btn btn-outline-danger d-inline-flex justify-content-center p-2 delete_role"
                            data-id="{{ $role->id }}">
                            <iconify-icon icon="icon-park-outline:delete" width="24" height="24"></iconify-icon>
                        </a>
                        &nbsp;
                        <a href="#"
                            class="btn btn-outline-info d-inline-flex align-items-center justify-content-center p-2">
                            <iconify-icon icon="hugeicons:authorized" width="24" height="24"></iconify-icon>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No Role Found</td>
            </tr>
            @endforelse
        </table>

        <div class="mt-4">
            {{ $roles->links() }}
        </div>
    </div>
</div>
@endsection

@push('backend_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {

        //* CREATE ROLE
        $('#roleForm').submit(function(e) {
            e.preventDefault();
            $('#role_name_error').text('');

            let formData = $('#roleForm').serialize();

            $.ajax({
                url: "{{ route('dashboard.role.permission.store.role') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#exampleModal').modal('hide');
                    $('#roleForm')[0].reset();

                    Swal.fire({
                        icon: 'success',
                        title: 'Role created successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    $('#role_name_error').text(xhr.responseJSON.errors.role_name ? xhr
                        .responseJSON.errors.role_name[0] : '');
                }
            });
        });

        //* EDIT ROLE - Get role data and populate modal
        $(document).on('click', '.editRole', function(e) {
            e.preventDefault();
            $('#edit_role_name_error').text('');
            
            let roleEditId = $(this).data('edit-id');

            $.ajax({
                url: `/dashboard/role-permission/edit-role/${roleEditId}`,
                type: 'GET',
                data: {
                    _token: $('input[name="_token"]').val()
                },
                success: function(response) {
                    if(response.success) {
                        $('#edit_role_id').val(response.role.id);
                        $('#edit_role_name').val(response.role.name);
                        $('#editRoleModal').modal('show');
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load role data!'
                    });
                }
            });
        });

        //* UPDATE ROLE
        $('#editRoleForm').submit(function(e) {
            e.preventDefault();
            $('#edit_role_name_error').text('');

            let roleId = $('#edit_role_id').val();
            let formData = {
                role_name: $('#edit_role_name').val(),
                _token: $('input[name="_token"]').val()
            };

            $.ajax({
                url: `/dashboard/role-permission/update-role/${roleId}`,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editRoleModal').modal('hide');
                    
                    // Update the table row dynamically
                    let row = $(`tr[data-role-id="${roleId}"]`);
                    row.find('.role-name').text($('#edit_role_name').val());

                    Swal.fire({
                        icon: 'success',
                        title: 'Role updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr) {
                    $('#edit_role_name_error').text(xhr.responseJSON.errors.role_name ? xhr
                        .responseJSON.errors.role_name[0] : '');
                }
            });
        });

        //* DELETE ROLE
        $(document).on('click', '.delete_role', function(e) {
            e.preventDefault();

            let roleId = $(this).data('id');
            let row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/dashboard/role-permission/delete-role/${roleId}`,
                        type: 'DELETE',
                        data: {
                            _token: $('input[name="_token"]').val()
                        },
                        success: function(response) {
                            row.remove();
                            Swal.fire('Deleted!', response.message, 'success');
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush