@extends('backend.layout')
@section('backend_content')
    <div class="card p-4">
        <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Assign Permission to Role</h4>
            <a href="{{ route('dashboard.role.permission.create.role') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Roles
            </a>
        </div>

        <div class="card-body">
            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($selectedRole)
                <form action="{{ route('dashboard.role.permission.store.permission') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role_id" value="{{ $selectedRole->id }}">

                    <div class="mb-4">
                        <h5 class="text-primary">Assigning permissions to: <strong
                                class="text-dark">{{ ucfirst($selectedRole->name) }}</strong></h5>
                    </div>

                    {{-- Permissions Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th width="10%">#</th>
                                    <th width="70%">Permission Name</th>
                                    <th width="20%">
                                        <div class="form-check d-flex justify-content-center align-items-center">
                                            <input class="form-check-input" type="checkbox" id="select_all">
                                            <label class="form-check-label ms-2" for="select_all">
                                                Select All
                                            </label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permissions as $key => $permission)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>
                                            <label for="permission_{{ $permission->id }}"
                                                class="form-label mb-0 cursor-pointer">
                                                {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <input name="permissions[]" type="checkbox"
                                                class="form-check-input permission-checkbox" value="{{ $permission->id }}"
                                                id="permission_{{ $permission->id }}"
                                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No permissions available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle"></i> Assign Permissions
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle"></i> No role selected. Please go back and select a role from the
                    roles list.
                </div>
            @endif
        </div>
    </div>
@endsection

@push('backend_js')
    <script>
        // Select All functionality
        document.getElementById('select_all')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Update "Select All" if individual checkboxes change
        document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allCheckboxes = document.querySelectorAll('.permission-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.permission-checkbox:checked');
                const selectAllCheckbox = document.getElementById('select_all');

                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
                }
            });
        });
    </script>
@endpush
