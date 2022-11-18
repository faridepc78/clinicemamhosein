@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | ورود</title>
@endsection

@include('site.layout.header')

<div class="main">

    <div class="container">
        <div class="row center-block margin-top-20 login-page">
            <div class="col-md-12" style="height: 600px;">

                <div class="row">

                    <div class="col-md-6 col-xs-12">

                        @if ($errors->has('failed'))
                            <div id="failed_alert" class="alert alert-danger text-center">
                                <i onclick="$('#failed_alert').hide();" style="cursor: pointer"
                                   class="fa fa-times-circle"></i>
                                <span>{{$errors->first('failed')}}</span>
                            </div>
                        @endif

                        <form id="login_form" class="login-box animated fade-in-up center-block"
                              method="post" action="{{route('login')}}">

                            @csrf

                            <br/>
                            <br/>

                            <div class="form-group">
                                <input value="{{old('national_code')}}" onkeyup="this.value=removeSpaces(this.value)"
                                       class="input-lg i-input-controller @error('national_code') is-invalid @enderror"
                                       name="national_code" type="text" id="national_code"
                                       placeholder="نام کاربری (کد ملی)" autocomplete="national_code" autofocus>

                                @error('national_code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input onkeyup="this.value=removeSpaces(this.value)"
                                       class="input-lg i-input-controller @error('password') is-invalid @enderror"
                                       name="password"
                                       type="password" id="password"
                                       placeholder="رمز عبور" autocomplete="password" autofocus>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                {!! app('captcha')->display(); !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block" role="alert">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                 </span>
                                @endif
                            </div>

                            <p class="des margin-top-20">
                                <span class="font-yellow-lemon  attention">توجه:</span>
                                درصورتی که قبلا ثبت نام کرده‌اید رمز عبور به طور پیش‌‌فرض تلفن همراه شما ثبت شده است.
                            </p>

                            <button name="submit" type="submit">ورود</button>

                            <br/>
                            <br/>

                            <a class="margin-top-5">
                                <a href="{{route('forgot')}}"><p class="small">رمز عبور خود را فراموش کرده‌اید؟</p></a>
                            </a>

                        </form>

                    </div>

                    <div class="col-md-6 hidden-sm hidden-xs">
                        <div>
                            <img class="login-img center-block"
                                 src="{{asset('assets/frontend/images/registerPage_2018.svg')}}"/>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

@section('site_js')
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?explicit&hl=fa" async defer></script>
@endsection

@include('site.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        $('#login_form').validate({

            rules: {
                national_code: {
                    required: true,
                    checkNationalCode: true
                },

                password: {
                    required: true
                }
            },

            messages: {
                national_code: {
                    required: "لطفا کد ملی را وارد کنید",
                    checkNationalCode: "لطفا کد ملی را صحیح وارد کنید"
                },

                password: {
                    required: "لطفا رمز عبور را وارد کنید"
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
