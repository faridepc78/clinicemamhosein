@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | فعالسازی حساب کاربری</title>
@endsection

@include('site.layout.header')

<div class="main">

    <div class="container">
        <div class="row center-block margin-top-20 login-page">
            <div class="col-md-12" style="height: 600px;">

                <div class="row">

                    <div class="col-md-6 col-xs-12">

                        @if ($errors->has('resend_active_code_message'))
                        <div id="failed_alert" class="alert alert-danger text-center">
                            <i onclick="$('#failed_alert').hide();" style="cursor: pointer" class="fa fa-times-circle"></i>
                            <span>{{$errors->first('resend_active_code_message')}}</span>
                        </div>
                        @endif

                        <form id="verify_form" class="login-box animated fade-in-up center-block"
                              method="post" action="{{route('verify')}}">

                            @csrf

                            <br/>

                            <div class="form-group">
                                <input maxlength="6" onkeyup="this.value=removeSpaces(this.value);"
                                       class="input-lg i-input-controller @error('active_code') is-invalid @enderror"
                                       name="active_code" type="text" id="active_code"
                                       placeholder="کد فعالسازی حساب کاربری" autocomplete="active_code" autofocus>

                                @error('active_code')
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

                            <button style="margin-top: -80px" type="submit">تایید</button>

                            <br>
                            <br>

                            <input id="resend_status" class="input-lg i-input-controller text-center" type="hidden"
                                   readonly>

                        </form>

                        <div id="resend_form" style="display: none">
                            <form style="margin-top: -20px !important;"
                                  class="login-box animated fade-in-up center-block"
                                  method="post" action="{{route('resend')}}">

                                @csrf

                                <button id="btn_submit" style="background-color: #0c91e5" type="submit">درخواست
                                    ارسال مجدد
                                </button>

                            </form>
                        </div>

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
    <script type="text/javascript" src='{{asset('assets/frontend/plugins/moment-js/js/moment.js')}}'></script>
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?explicit&hl=fa" async defer></script>
@endsection

@include('site.layout.footer')

<script type="text/javascript">

    $(function () {
        setInterval(function () {
            var resend_active_code = {{$resend_active_code}};
            var resend_status = $('#resend_status');

            utxtimes = moment.utc().format('YYYY-MM-DD HH:mm:ss');
            var localTime = moment.utc(utxtimes).toDate();
            localTime = moment(localTime).format('YYYY-MM-DD HH:mm:ss');
            tms = moment(localTime).format("X");
            $('#timestamp').text(tms);

            var seconds = resend_active_code - tms;

            if (seconds > 0) {
                resend_status.prop('type', 'text');
                resend_status.val('درخواست ارسال مجدد (' + seconds + ' ثانیه)');
            } else {
                resend_status.remove();
                showResendActiveCodeForm();
            }

        }, 1000);

        function showResendActiveCodeForm() {
            $('#resend_form').css('display', 'block');
        }
    });
</script>

<script type="text/javascript">

    $(document).ready(function () {

        $('#verify_form').validate({

            rules: {
                active_code: {
                    required: true,
                    number:true,
                    maxlength: 6
                }
            },

            messages: {
                active_code: {
                    required: "لطفا کد فعالسازی را وارد کنید",
                    number:"کد فعالسازی عدد است",
                    maxlength: "کد فعالسازی 6 رقمی است"
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
