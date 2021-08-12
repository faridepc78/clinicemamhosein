@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | ثبت نام</title>
@endsection

@section('site_css')
    <link rel="stylesheet"
          href="{{asset('assets/common/plugins/persianDatepicker/css/persianDatepicker-default.css')}}">
@endsection

@include('site.layout.header')

<div class="main">

    <div id="Register" class="container">
        <div class="row center-block margin-top-20 register-page">

            <div class="col-md-12">

                <div class="logo-container hidden-sm hidden-xs">
                    <img src="{{asset('assets/frontend/images/register_2018.svg')}}" id="logo-pic-signup">
                </div>

                <form class="row margin-top-40" id="register_form" method="post" action="{{route('register')}}">

                    @csrf

                    <div id="right-input-container" class="col-md-6 col-xs-12 form-body">

                        <div class="form-group">
                            <div class="col-md-10">
                                <input onkeyup="this.value=removeSpaces(this.value)" id="f_name" name="f_name"
                                       class="form-control @error('f_name') is-invalid @enderror input-lg i-input-controller"
                                       maxlength="25"
                                       value="{{old('f_name')}}"
                                       placeholder="نام" type="text" autocomplete="f_name" autofocus>

                                @error('f_name')
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10">
                                <input onkeyup="this.value=removeSpaces(this.value)" id="l_name" name="l_name"
                                       class="form-control @error('l_name') is-invalid @enderror input-lg i-input-controller"
                                       maxlength="25"
                                       value="{{old('l_name')}}"
                                       placeholder="نام خانوادگی" type="text" autocomplete="l_name" autofocus>

                                @error('l_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-md-10">
                                <input onkeyup="this.value=removeSpaces(this.value)" id="ff_name" name="ff_name"
                                       class="form-control @error('ff_name') is-invalid @enderror input-lg i-input-controller"
                                       maxlength="25"
                                       value="{{old('ff_name')}}"
                                       placeholder="نام پدر" type="text" autocomplete="ff_name" autofocus>

                                @error('ff_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group ">

                            <div class="col-md-10">
                                <input onkeyup="this.value=removeSpaces(this.value)" id="national_code"
                                       name="national_code"
                                       class="form-control @error('national_code') is-invalid @enderror input-lg i-input-controller"
                                       value="{{old('national_code')}}"
                                       maxlength="10"
                                       placeholder="کد ملی" type="text" autocomplete="national_code" autofocus>

                                @error('national_code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <span class="help-block font-red-haze margin-bottom-30 font-size-13">
                                    <i class="fa fa-warning"></i> در صورت عدم مطابقت کد ملی با کد ملی بیمار، پذیرش صورت نخواهد گرفت.
                                </span>
                            </div>
                        </div>

                        <div class="form-group margin-top-20">
                            <div class="col-md-10">
                                <input onkeyup="this.value=removeSpaces(this.value)" id="mobile" name="mobile"
                                       class="form-control @error('mobile') is-invalid @enderror input-lg i-input-controller"
                                       value="{{old('mobile')}}"
                                       placeholder="شماره موبایل" type="text" autocomplete="mobile" autofocus>

                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <span class="help-block font-red-haze margin-bottom-30 font-size-13">
                                    <i class="fa  fa-warning"></i> جهت دریافت کد فعالسازی لطفا شماره موبایل خود را بصورت صحیح وارد کنید.
                                </span>
                            </div>
                        </div>

                        <div class="form-group margin-top-20">
                            <input readonly type="text"
                                   class="form-control input-lg i-input-controller @error('birthday') is-invalid @enderror"
                                   value="{{ old('birthday') }}"
                                   id="birthday" name="birthday"
                                   placeholder="تاریخ تولد کاربر"
                                   autocomplete="birthday" autofocus>

                            @error('birthday')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                            @enderror
                        </div>

                    </div>

                    <div id="left-input-container" class="col-md-6 col-xs-12 form-body">

                        <div class="form-group margin-top-20">
                            <label class="col-md-3 " style="color: #000; font-size: 16px;">جنسیت</label>
                            <div class="input-group col-md-9">
                                <div class="icheck-inline">
                                    <label>
                                        <input @if (old('sex')==\App\Models\User::MALE)
                                               checked
                                               @endif type="radio" value="{{\App\Models\User::MALE}}" name="sex"
                                               checked>
                                        مرد
                                    </label>&emsp;
                                    <label>
                                        <input @if (old('sex')==\App\Models\User::FEMALE)
                                               checked
                                               @endif type="radio" value="{{\App\Models\User::FEMALE}}" name="sex">
                                        زن
                                    </label>

                                    <br>
                                </div>
                            </div>

                            @error('sex')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group margin-top-20">
                            {!! app('captcha')->display(); !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block" role="alert">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                 </span>
                            @endif
                        </div>

                        <div class="form-group ">
                            <div class="col-md-10 font-size-13">
                                <input checked disabled type="checkbox" value="1" data-checkbox="icheckbox_minimal-blue"
                                       class="icheck ">
                                ثبت نام در این سایت به منزله پذیرش <a href="{{route('terms-and-conditions')}}"
                                                                      target="_blank">قوانین</a> سایت است.
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 font-size-13 spurple margin-top-20">
                                <i class="icon-info"></i>&nbsp;در صورت بروز خطا در <span class="font-size-15">ثبت&zwnj;نام</span>
                                با شماره تلفن پشتیبانی تماس حاصل فرمایید (زمان پاسخگویی از ساعت ۱۰ صبح تا ۶ بعد از ظهر).
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="reg-submit margin-bottom-40">
                                <button type="submit">ثبت نام <i class="fa fa-exclamation"></i></button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

@section('site_js')
    <script type="text/javascript"
            src="{{asset('assets/common/plugins/persianDatepicker/js/persianDatepicker.min.js')}}"></script>
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?explicit&hl=fa" async defer></script>
@endsection

@include('site.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        $("#birthday").persianDatepicker({formatDate: "YYYY/0M/0D"});

        $('#register_form').validate({

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

                mobile: {
                    required: true,
                    checkMobile: true
                },

                national_code: {
                    required: true,
                    checkNationalCode: true
                },

                birthday: {
                    required: true
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

                mobile: {
                    required: "لطفا تلفن همراه را وارد کنید",
                    checkMobile: "لطفا تلفن همراه را صحیح وارد کنید"
                },

                national_code: {
                    required: "لطفا کد ملی را وارد کنید",
                    checkNationalCode: "لطفا کد ملی را صحیح وارد کنید"
                },

                birthday: {
                    required: "لطفا تاریخ تولد را وارد کنید"
                }
            },
            submitHandler: function (form) {
                if (grecaptcha.getResponse()) {
                    form.submit();
                } else {
                    toastr['info']('لطفا ریکپچا را کامل کنید', 'پیام');
                }
            }

        });

    });

</script>
