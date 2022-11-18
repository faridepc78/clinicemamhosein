@section('admin_title')
    <title>پنل مدیریت درمانگاه شبانه روزی امام حسین (ع) | تنظیمات</title>
@endsection

@include('admin.layout.header')

@include('admin.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('settings.index')}}">مدیریت تنظیمات</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="card @if ($setting['status']=='store')
                        card-primary
                    @else card-success @endif">

                        <div class="card-header">
                            <h3 class="card-title">مدیریت تنظیمات</h3>
                        </div>

                        <form id="createOrUpdate_settings_form"
                              @if ($setting['status']=='store')
                              action="{{route('settings.store')}}"
                              @else
                              action="{{route('settings.update')}}"
                              @endif
                              method="post">

                            @csrf

                            @if($setting['status']!='store')
                                @method('patch')
                            @endif

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="terms">صفحه قوانین *</label>
                                    <textarea class="form-control ckeditor @error('terms') is-invalid @enderror"
                                              id="terms"
                                              name="terms" autocomplete="terms"
                                              autofocus>{{ old('terms',$setting['terms']) }}</textarea>

                                    @error('terms')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="about">صفحه درباره ما *</label>
                                    <textarea class="form-control ckeditor @error('about') is-invalid @enderror"
                                              id="about"
                                              name="about" autocomplete="about"
                                              autofocus>{{ old('about',$setting['about']) }}</textarea>

                                    @error('about')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="support">صفحه پشتیبانی *</label>
                                    <textarea class="form-control ckeditor @error('support') is-invalid @enderror"
                                              id="support"
                                              name="support" autocomplete="support"
                                              autofocus>{{ old('support',$setting['support']) }}</textarea>

                                    @error('support')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="telegram">تلگرام</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control text-left @error('telegram') is-invalid @enderror"
                                           value="{{ old('telegram',$setting['telegram']) }}" id="telegram"
                                           name="telegram"
                                           autocomplete="telegram" autofocus>

                                    @error('telegram')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="instagram">اینستاگرام</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control text-left @error('instagram') is-invalid @enderror"
                                           value="{{ old('instagram',$setting['instagram']) }}" id="instagram"
                                           name="instagram"
                                           autocomplete="instagram" autofocus>

                                    @error('instagram')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="linkedin">لینکدین</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control text-left @error('linkedin') is-invalid @enderror"
                                           value="{{ old('linkedin',$setting['linkedin']) }}" id="linkedin"
                                           name="linkedin"
                                           autocomplete="linkedin" autofocus>

                                    @error('linkedin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                @if ($setting['status']=='store')
                                    <button type="submit" class="btn btn-primary">ثبت</button>
                                @else
                                    <button type="submit" class="btn btn-success">بروزرسانی</button>
                                @endif
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

@section('admin_js')
    <script type="text/javascript" src="{{asset('assets/common/plugins/ckeditor/ckeditor.js')}}"></script>
@endsection

@include('admin.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        var terms_field = 'terms';
        var terms_error = 'لطفا توضیحات صفحه قوانین را وارد کنید';

        var about_field = 'about';
        var about_error = 'لطفا توضیحات صفحه درباره ما را وارد کنید';

        var support_field = 'support';
        var support_error = 'لطفا توضیحات صفحه پشتیبانی را وارد کنید';

        $('#createOrUpdate_settings_form').validate({

            rules: {
                telegram: {
                    checkUrl: true
                },

                instagram: {
                    checkUrl: true
                },

                linkedin: {
                    checkUrl: true
                }
            },

            messages: {
                telegram: {
                    checkUrl: "لطفا لینک تلگرام را صحیح وارد کنید"
                },

                instagram: {
                    checkUrl: "لطفا لینک اینستاگرام را صحیح وارد کنید"
                },

                linkedin: {
                    checkUrl: "لطفا لینک لینکدین را صحیح وارد کنید"
                }
            },
            submitHandler: function (form) {
                if (validateCkeditor(terms_field, terms_error) === true
                    && validateCkeditor(about_field, about_error) === true
                    && validateCkeditor(support_field, support_error) === true) {
                    form.submit();
                }
            }

        });

    });

</script>
