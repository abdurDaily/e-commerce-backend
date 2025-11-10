@extends('backend.layout')
@section('backend_content')
    <div class="card p-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Create an user</h5>
            <a href="#" class="btn btn-primary  ">see all users</a>
        </div>

        <div class="card-body">
            <form action="{{ route('dashboard.role.permission.store.user') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row justify-content-between">
                    <div class="col-lg-4 text-center">
                        <label for="imgInp">
                            <img class="previewImg"
                                style="border: 1px solid #0000001a; cursor: pointer; padding:10px; width:100%; max-wdth:250px; height:250px; object-fit:cover;"
                                id="blah" class="img-fluid" src="{{ asset('assets/img/upload.jpg') }}" alt="">
                        </label>
                        <input name="profile_image" hidden accept="image/*" type='file' id="imgInp" />

                        <button style="display: none;" type="button" class="removeBtn">remove</button>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="mb-1" for="name">user name:</label>
                                <input name="user_name" type="text" class="form-control p-3" placeholder="name">
                            </div>
                            <div class="col-lg-6">
                                <label class="mb-1" for="email">user email:</label>
                                <input name="user_email" type="email" class="form-control p-3" placeholder="email">
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label class="mb-1" for="password">user name:</label>
                                <input name="user_password" type="password" class="form-control p-3" placeholder="password">
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label class="mb-1" for="password">user name:</label>
                                <input type="password" class="form-control p-3" placeholder="password"
                                    name="confirm_password">

                                @if(session('pass_err'))
                                  <p class="text-danger">{{ session('pass_err') }}</p>
                                @endif
                            </div>
                            <div class="col mt-3">
                                <button class="btn btn-primary p-3 w-100 ">Register user</button>
                            </div>

                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
@endsection


@push('backend_js')
    <script>
        let defaultImg = `{{ asset('assets/img/upload.jpg') }}`
        let removeBtn = $('.removeBtn');
        let previewImg = $('.previewImg');



        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
                removeBtn.show();
            }
        }

        removeBtn.on('click', () => {
            previewImg.attr('src', defaultImg)
            removeBtn.value = '';
            removeBtn.hide();
        })
    </script>
@endpush
