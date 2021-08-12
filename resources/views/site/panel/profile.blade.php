@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | پنل بیمار</title>
@endsection

@section('site_css')
    <link rel="stylesheet"
          href="{{asset('assets/common/plugins/persianDatepicker/css/persianDatepicker-default.css')}}">
@endsection

@include('site.layout.header')

<div class="main">

    <div id="Profile" class="row profile-page">
        <div class="col-md-12">

            <div class="row margin-top-20">
                <div class="col-md-12">
                    <img class="client-avatar center-block" width="100"
                         src="{{auth()->user()->profile}}"/>
                </div>
            </div>

            <div class="row">
                <h2 class="col-md-12 margin-top-10 ">{{auth()->user()->fullName}}</h2>
            </div>

            <form action="{{route('user_update_avatar')}}"
                  method="post" enctype="multipart/form-data">

                @csrf
                @method('patch')

                <div class="col-md-4 form-group center">
                    <input autofocus id="image" name="image" accept=".jpg,.jpeg,.png" type="file"
                           class="form-control col-md-offset-12 @error('image') is-invalid @enderror" required>

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="col-md-offset-3 col-md-4">
                    <button type="submit" class="btn green">
                        ارسال
                    </button>
                </div>

            </form>

            @include('site.panel.menu')

            <div class="tab-content">

                <div class="tab-pane active in form">

                    <form id="update_user_profile" class="form-horizontal" role="form" method="post"
                          action="{{route('user_update_profile')}}">

                        @csrf
                        @method('patch')

                        <div class="form-body">

                            <div class="form-group">
                                <label for="f_name" class="col-md-3 control-label"><strong>نام</strong></label>
                                <div class="col-md-3">
                                    <input onkeyup="this.value=removeSpaces(this.value)" id="f_name" name="f_name"
                                           class="form-control @error('f_name') is-invalid @enderror input-lg i-input-controller"
                                           maxlength="25"
                                           value="{{old('f_name',auth()->user()->f_name)}}"
                                           placeholder="نام" type="text" autocomplete="f_name" autofocus>

                                    @error('f_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="l_name" class="col-md-3 control-label"><strong>نام خانوادگی</strong></label>
                                <div class="col-md-3">
                                    <input onkeyup="this.value=removeSpaces(this.value)" id="l_name" name="l_name"
                                           class="form-control @error('l_name') is-invalid @enderror input-lg i-input-controller"
                                           maxlength="25"
                                           value="{{old('l_name',auth()->user()->l_name)}}"
                                           placeholder="نام" type="text" autocomplete="l_name" autofocus>

                                    @error('l_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ff_name" class="col-md-3 control-label"><strong>نام پدر</strong></label>
                                <div class="col-md-3">
                                    <input onkeyup="this.value=removeSpaces(this.value)" id="ff_name" name="ff_name"
                                           class="form-control @error('ff_name') is-invalid @enderror input-lg i-input-controller"
                                           maxlength="25"
                                           value="{{old('ff_name',auth()->user()->ff_name)}}"
                                           placeholder="نام پدر" type="text" autocomplete="ff_name" autofocus>

                                    @error('ff_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="national_code" class="col-md-3 control-label"><strong>کد
                                        ملی</strong></label>
                                <div class="col-md-3">
                                    <input id="national_code" class="form-control input-lg i-input-controller" disabled
                                           value="{{auth()->user()->national_code}}"
                                           type="text">
                                </div>
                            </div>

                            <div class="form-group margin-top-20">
                                <label for="mobile" class="col-md-3 control-label ">
                                    <strong>تلفن همراه</strong>
                                </label>
                                <div class="col-md-3">
                                    <input id="mobile" disabled class="form-control input-lg i-input-controller"
                                           value="{{auth()->user()->mobile}}"
                                           placeholder="تلفن همراه" type="text">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="birthday" class="col-md-3 control-label"><strong>تاریخ تولد</strong></label>
                                <div class="col-md-3">
                                    <input readonly id="birthday" name="birthday"
                                           class="form-control @error('birthday') is-invalid @enderror input-lg i-input-controller"
                                           value="{{old('birthday',\Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime(auth()->user()['birthday'])))}}"
                                           placeholder="تاریخ تولد" type="text" autocomplete="birthday" autofocus>

                                    @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"><strong>جنسیت</strong></label>
                                <div class="col-md-3">
                                    <div class="icheck-inline">
                                        <label>
                                            <input type="radio" value="{{\App\Models\User::MALE}}"
                                                   name="sex" @if (old('sex',auth()->user()['sex']==\App\Models\User::MALE))
                                                   checked
                                                @endif>
                                            مرد
                                        </label>&emsp;
                                        <label>
                                            <input type="radio" value="{{\App\Models\User::FEMALE}}" name="sex"
                                                   @if (old('sex',auth()->user()['sex']==\App\Models\User::FEMALE))
                                                   checked
                                                @endif>
                                            زن
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="password" class="col-md-3 control-label"><strong>رمز عبور</strong></label>
                                <div class="col-md-3">
                                    <input id="password"
                                           name="password"
                                           class="form-control input-lg i-input-controller @error('password') is-invalid @enderror"
                                           placeholder="رمز عبور" type="text" autocomplete="new-password">
                                </div>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label for="password_confirmation" class="col-md-3 control-label"><strong>تایید رمز
                                        عبور</strong></label>
                                <div class="col-md-3">
                                    <input
                                        id="password_confirmation" name="password_confirmation"
                                        class="form-control input-lg i-input-controller"
                                        placeholder="تایید رمز عبور" type="text">
                                </div>
                            </div>

                        </div>

                        <div class="form-actons">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green">
                                        بروزرسانی
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>

                    <div class="clearfix"></div>

                </div>

            </div>

        </div>
    </div>

</div>

@section('site_js')
    <script type="text/javascript"
            src="{{asset('assets/common/plugins/persianDatepicker/js/persianDatepicker.min.js')}}"></script>
@endsection

@include('site.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        $("#birthday").persianDatepicker({formatDate: "YYYY/0M/0D"});

        $('#update_user_profile').validate({

            rules: {
                f_name: {
                    required: true
                },

                l_name: {
                    required: true
                },

                ff_name: {
                    required: true
                },

                sex: {
                    required: true
                },

                password: {
                    minlength: 8
                },

                password_confirmation: {
                    equalTo: "#password"
                }
            },

            messages: {
                f_name: {
                    required: "لطفا نام را وارد کنید"
                },

                l_name: {
                    required: "لطفا نام خانوادگی را وارد کنید"
                },

                ff_name: {
                    required: "لطفا نام پدر را وارد کنید"
                },

                sex: {
                    required: "لطفا جنسیت را انتخاب کنید"
                },

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
