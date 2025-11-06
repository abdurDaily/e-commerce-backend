@extends('backend.layout')
@section('backend_content')

<div class="card">
    <div class="card-header">
        <div class="d-flex gap-3">
            <img class="img-fluid rounded-3" style="height: 100px;" src="{{ asset('assets/img/avatars/1.png') }}"
                alt="">

            <div>
                <h4 class="mb-0">User Name</h4>
                <small>Full stack web Developer</small>

                <button class="btn btn-primary d-flex align-items-center gap-2 mt-2">Profile image  <iconify-icon icon="mingcute:upload-3-line" width="24" height="24"></iconify-icon> </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit vitae dolores numquam. Modi aspernatur nihil,
            deserunt, reiciendis earum blanditiis eius dolore illo saepe officia quibusdam sunt nostrum facere eum ipsam
            itaque doloribus rerum sint ex ducimus quisquam cumque impedit? Eligendi soluta amet, exercitationem qui
            debitis eaque repudiandae libero possimus in.</p>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h4>User Info</h4>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- USER INFORMATION --}}
            <div class="col-lg-6">
                <form action="" method="">
                    @csrf


                    <label for="name">Name: </label>
                    <input class="form-control p-3 mb-2" type="text" name="name" placeholder="name" value="John Doe">


                    <label for="name">Designation: </label>
                    <input class="form-control p-3 mb-2" type="text" name="designation" placeholder="designation"
                        value="Developer">



                    <label for="name">Email: </label>
                    <input class="form-control p-3 mb-2" type="email" name="email" placeholder="email"
                        value="John@gmail.com">


                  <button class="btn btn-primary w-100 p-2">Info. Update</button>


                </form>
            </div>

            {{-- USER PASSWORD --}}
            <div class="col-lg-6">
                <form action="" method="">
                    @csrf


                    <label for="name">Current Password: </label>
                    <input class="form-control p-3 mb-2" type="password" name="password" placeholder="current password" >

                    

                    <label for="name">New Password: </label>
                    <input class="form-control p-3 mb-2" type="password" name="new_password" placeholder="current password" >


                    <label for="name">Confirm Password: </label>
                    <input class="form-control p-3 mb-2" type="password" name="confirm_password" placeholder="current password" >



                  <button class="btn btn-primary w-100 p-2">Password Update</button>


                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('backend_js')
    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>

    
@endpush