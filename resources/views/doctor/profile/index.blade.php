@section('doctor_title')
    <title>پنل دکتر درمانگاه شبانه روزی امام حسین (ع) | پروفایل</title>
@endsection

@include('doctor.layout.header')

@include('doctor.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('doctor_profile')}}">ویرایش
                                پروفایل ({{$user->fullName}})</a></li>
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
                            <h3 class="card-title">ویرایش پروفایل ({{$user->fullName}})</h3>
                        </div>

                        <form id="update_profile_form" action="{{route('doctor_update_profile')}}"
                              method="post" enctype="multipart/form-data">

                            @csrf
                            @method('patch')

                            <div class="card-body">

                                <div class="col-md-12 form-row">

                                    <div class="form-group col-md-6">
                                        <label for="f_name">نام</label>
                                        <input readonly
                                               class="form-control"
                                               value="{{ $user->f_name }}" id="f_name">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="l_name">نام خانوادگی</label>
                                        <input readonly
                                               class="form-control"
                                               value="{{ $user->l_name }}" id="l_name">
                                    </div>

                                </div>

                                <div class="col-md-12 form-row">

                                    <div class="form-group col-md-6">
                                        <label for="mobile">تلفن همراه</label>
                                        <input readonly
                                               class="form-control"
                                               value="{{ $user->mobile }}" id="mobile">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="national_code">کد ملی</label>
                                        <input readonly
                                               class="form-control"
                                               value="{{ $user->national_code }}" id="national_code">
                                    </div>

                                </div>

                                <div class="col-md-12 form-row">

                                    <div class="form-group col-md-6">
                                        <label for="sex">جنسیت</label>
                                        <input readonly
                                               class="form-control"
                                               value="@lang($user->sex)" id="sex">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="birthday">تاریخ تولد</label>
                                        <input readonly
                                               class="form-control"
                                               value="@if($user->birthday!==null){{\Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($user['birthday']))}}@endif"
                                               id="birthday">
                                    </div>

                                </div>

                                <div class="col-md-12 form-row">

                                    <div class="form-group col-md-6">
                                        <label for="sex">منشی</label>
                                        <input readonly
                                               class="form-control"
                                               value="@lang($user->doctor->clerk->fullName)" id="sex">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="image">تصویر پروفایل</label>
                                        <img width="50" src="{{$user->profile}}"
                                             alt="{{$user->profile}}">
                                        <input accept=".jpg,.jpeg,.png" type="file"
                                               class="form-control @error('image') is-invalid @enderror"
                                               autofocus id="image" name="image">

                                        @error('image')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-md-12 form-row">

                                    <div class="form-group col-md-6">
                                        <label for="password">رمز عبور</label>
                                        <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                               class="form-control @error('password') is-invalid @enderror"
                                               value="{{ old('password') }}" id="password" name="password"
                                               placeholder="رمز عبور را وارد کنید"
                                               autocomplete="password" autofocus>

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="password_confirmation">تایید رمز عبور</label>
                                        <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                               class="form-control"
                                               id="password_confirmation" name="password_confirmation"
                                               placeholder="تایید رمز عبور را وارد کنید" autofocus>
                                    </div>

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

@include('doctor.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        $('#update_profile_form').validate({

            rules: {
                password: {
                    minlength: 8
                },

                password_confirmation: {
                    equalTo: "#password"
                }
            },

            messages: {
                password: {
                    minlength: "لطفا رمز عبور را حداقل 8 کاراکتر وارد کنید"
                },

                password_confirmation: {
                    equalTo: "لطفا تایید رمز عبور را صحیح وارد کنید"
                }
            }

        });

    });

</script>
