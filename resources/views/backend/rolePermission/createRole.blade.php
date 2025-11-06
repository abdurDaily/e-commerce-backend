@extends('backend.layout')

@section('backend_content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Created role list</h4>
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Create new
                Role</button>
        </div>
        <!-- Modal -->
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

        <div class="card-body">
            <table class="table table-bordered table-hover table-striped">
                <tr class="text-center">
                    <th>#</th>
                    <th>Role Name</th>
                    <th>Action</th>
                </tr>
                @forelse ($roles as $key => $role)
                    <tr class="text-center">
                        <td>{{ ++$key }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <div>
                                <a href="#"
                                    class="btn btn-outline-primary d-inline-flex align-items-center justify-content-center p-2 ">
                                    <iconify-icon icon="lucide:edit" width="24" height="24"></iconify-icon> </a>
                                &nbsp;
                                <a href="#"
                                    class="btn btn-outline-danger d-inline-flex align-items-center justify-content-center p-2 ">
                                    <iconify-icon icon="icon-park-outline:delete" width="24"
                                        height="24"></iconify-icon>
                                </a>
                                &nbsp;
                                <a href="#"
                                    class="btn btn-outline-info d-inline-flex align-items-center justify-content-center p-2 ">
                                    <iconify-icon icon="hugeicons:authorized" width="24" height="24"></iconify-icon>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No Role Found</td>
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
            $('#roleForm').submit(function(e) {
                e.preventDefault();


                let formData = $('#roleForm').serialize(); // includes _token automatically

                $.ajax({
                    url: "{{ route('dashboard.role.permission.store.role') }}",
                    type: 'POST',
                    data: formData, // automatically sends role_name + _token
                    success: function(response) {
                        $('#exampleModal').modal('hide');
                        $('#roleForm')[0].reset();

                        Swal.fire({
                            icon: 'success',
                            title: 'Role created successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // You can also append the row dynamically instead of reload
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        $('#role_name_error').text(xhr.responseJSON.errors.role_name ? xhr
                            .responseJSON.errors.role_name[0] : '');
                    }
                });

            });
        });
    </script>
@endpush
