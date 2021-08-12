@section('admin_title')
    <title>پنل مدیریت درمانگاه شبانه روزی امام حسین (ع) | کاربران</title>
@endsection

@section('admin_css')
    <link rel="stylesheet"
          href="{{asset('assets/common/plugins/persianDatepicker/css/persianDatepicker-default.css')}}">
@endsection

@include('admin.layout.header')

@include('admin.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}">مدیریت کاربران</a></li>
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('users.edit',$user->id)}}">ویرایش
                                کاربر ({{$user->fullName}})</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-success">

                        <div class="card-header">
                            <h3 class="card-title">ویرایش کاربر ({{$user->fullName}})</h3>
                        </div>

                        <form id="update_user_form" action="{{route('users.update',$user->id)}}"
                              method="post" enctype="multipart/form-data">

                            @csrf
                            @method('patch')

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="f_name">نام کاربر *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('f_name') is-invalid @enderror"
                                           value="{{ old('f_name',$user->f_name) }}" id="f_name" name="f_name"
                                           placeholder="لطفا نام کاربر را وارد کنید"
                                           autocomplete="f_name" autofocus>

                                    @error('f_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="l_name">نام خانوادگی کاربر *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('l_name') is-invalid @enderror"
                                           value="{{ old('l_name',$user->l_name) }}" id="l_name" name="l_name"
                                           placeholder="لطفا نام خانوادگی کاربر را وارد کنید"
                                           autocomplete="l_name" autofocus>

                                    @error('l_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mobile">تلفن همراه کاربر *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('mobile') is-invalid @enderror"
                                           value="{{ old('mobile',$user->mobile) }}" id="mobile" name="mobile"
                                           placeholder="لطفا تلفن همراه کاربر را وارد کنید" autocomplete="mobile"
                                           autofocus>

                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="national_code">کد ملی کاربر *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('national_code') is-invalid @enderror"
                                           value="{{ old('national_code',$user->national_code) }}" id="national_code" name="national_code"
                                           placeholder="لطفا کد ملی کاربر را وارد کنید" autocomplete="national_code"
                                           autofocus>

                                    @error('national_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="birthday">تاریخ تولد</label>
                                    <input readonly type="text"
                                           class="form-control @error('birthday') is-invalid @enderror"
                                           @if ($user->birthday!=null)
                                           value="{{ old('birthday',\Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($user['birthday']))) }}"
                                           @else
                                           value="{{ old('birthday') }}"
                                           @endif
                                           id="birthday" name="birthday"
                                           placeholder="تاریخ تولد را انتخاب کنید"
                                           autocomplete="birthday" autofocus>

                                    @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="sex">جنسیت کاربر *</label>
                                    <select class="form-control  @error('sex') is-invalid @enderror"
                                            id="sex"
                                            name="sex">
                                        <option selected disabled value="">لطفا جنسیت کاربر را انتخاب کنید</option>

                                        <option @if (old('sex',$user->sex)==\App\Models\User::MALE)
                                                selected="selected"
                                                @endif value="{{\App\Models\User::MALE}}">@lang(\App\Models\User::MALE)</option>

                                        <option @if (old('sex',$user->sex)==\App\Models\User::FEMALE)
                                                selected="selected"
                                                @endif value="{{\App\Models\User::FEMALE}}">@lang(\App\Models\User::FEMALE)</option>

                                    </select>

                                    @error('sex')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image">پروفایل کاربر</label>
                                    <img width="50" src="{{$user->profile}}"
                                         alt="{{$user->profile}}">
                                    <input accept=".jpg,.jpeg,.png" type="file" class="form-control @error('image') is-invalid @enderror"
                                           autofocus id="image" name="image">

                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">رمز عبور کاربر</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('password') is-invalid @enderror"
                                           value="{{ old('password') }}" id="password" name="password"
                                           placeholder="رمز عبور کاربر را وارد کنید"
                                           autocomplete="password" autofocus>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="role">نقش کاربر *</label>
                                    <select class="form-control  @error('role') is-invalid @enderror"
                                            id="role"
                                            name="role">
                                        <option selected disabled value="">لطفا نقش کاربر را انتخاب کنید</option>

                                        @foreach(\App\Models\User::$roles as $role)
                                            <option
                                                @if ($role==old('role',$user->role))
                                                selected="selected"
                                                @endif
                                                value="{{$role}}">@lang($role)</option>
                                        @endforeach

                                    </select>

                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">بروزرسانی</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

@section('admin_js')
    <script type="text/javascript"
            src="{{asset('assets/common/plugins/persianDatepicker/js/persianDatepicker.min.js')}}"></script>
@endsection

@include('admin.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        $("#birthday").persianDatepicker({formatDate: "YYYY/0M/0D"});

        $('#update_user_form').validate({

            rules: {
                f_name: {
                    required: true
                },

                l_name: {
                    required: true
                },

                mobile:{
                    required: true,
                    checkMobile:true
                },

                national_code: {
                    required: true,
                    checkNationalCode: true
                },

                sex:{
                    required: true
                },

                password: {
                    minlength: 8
                },

                role: {
                    required: true
                }
            },

            messages: {
                f_name: {
                    required: "لطفا نام کاربر را وارد کنید"
                },

                l_name: {
                    required: "لطفا نام خانوادگی کاربر را وارد کنید"
                },

                mobile:{
                    required: "لطفا تلفن همراه کاربر را وارد کنید",
                    checkMobile: "لطفا تلفن همراه کاربر را صحیح وارد کنید"
                },

                national_code: {
                    required: "لطفا کد ملی کاربر را وارد کنید",
                    checkNationalCode: "لطفا کد ملی کاربر را صحیح وارد کنید"
                },

                sex:{
                    required:"لطفا جنسیت کاربر را وارد کنید"
                },

                password: {
                    minlength: "لطفا رمز عبور کاربر را حداقل 8 کاراکتر وارد کنید"
                },

                role: {
                    required: "لطفا نقش کاربر را انتخاب کنید"
                }
            }

        });

    });

</script>
