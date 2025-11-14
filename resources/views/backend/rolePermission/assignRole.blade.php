@extends('backend.layout')
@section('backend_content')
    <div class="card">
        <div class="card-header">
            <h4>Assign role to user</h4>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <div class="card-body">
            <form action="{{ route('dashboard.role.permission.assign.role.user.store') }}" method="post">
                @csrf

                <input type="hidden" name="user_id" value="{{ $user->id }}">


                <table class="table table-strip table-bordered ">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>

                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                <label for="role_{{ $role->id }}">{{ $role->name }}</label>

                            </td>
                            <td>

                                <input type="checkbox" name="role[]" value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'checked' : '' }}>

                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="3">
                            <button class="btn btn-primary p-2 w-100">Submit</button>
                        </td>
                    </tr>





                </table>

            </form>
        </div>
    </div>
@endsection
