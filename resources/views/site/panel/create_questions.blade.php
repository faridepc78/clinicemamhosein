@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | پنل بیمار</title>
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

            @include('site.panel.menu')

            <div class="tab-content">

                <div class="tab-pane active in form">

                    <form id="user_create_questions" class="form-horizontal" role="form" method="post"
                          action="{{route('user_create_questions_do')}}" enctype="multipart/form-data">

                        @csrf

                        <div class="form-body">

                            <div class="form-group">
                                <label for="doctor_id" class="col-md-3 control-label"><strong>دکتر *</strong></label>

                                <div class="col-md-6">
                                    <select class="form-control  @error('doctor_id') is-invalid @enderror"
                                            id="doctor_id"
                                            name="doctor_id">
                                        <option selected disabled value="">لطفا دکتر را انتخاب کنید</option>

                                        @if (count($doctors))

                                            @foreach($doctors as $value)

                                                <option @if ($value->id==old('doctor_id'))
                                                        selected="selected"
                                                        @endif
                                                        value="{{$value->id}}">{{$value->fullName}}</option>

                                            @endforeach

                                        @endif

                                    </select>
                                </div>

                                @error('doctor_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="media" class="col-md-3 control-label"><strong>فایل پیوست</strong></label>
                                <div class="col-md-6">
                                    <input id="media" name="media" accept=".jpg,.jpeg,.png" type="file"
                                           class="form-control @error('media') is-invalid @enderror input-lg i-input-controller"
                                           autofocus>

                                    @error('media')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="subject" class="col-md-3 control-label"><strong>موضوع سوال
                                        *</strong></label>
                                <div class="col-md-6">
                                    <input onkeyup="this.value=removeSpaces(this.value)" id="subject" name="subject"
                                           class="form-control @error('subject') is-invalid @enderror input-lg i-input-controller"
                                           value="{{old('subject')}}"
                                           maxlength="50"
                                           placeholder="لطفا موضوع سوال را کنید" type="text" autocomplete="subject"
                                           autofocus>

                                    @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message" class="col-md-3 control-label"><strong>متن سوال *</strong></label>
                                <div class="col-md-6">
                                                                    <textarea
                                                                        class="form-control ckeditor @error('message') is-invalid @enderror"
                                                                        id="message"
                                                                        name="message" autocomplete="message"
                                                                        autofocus>{{ old('message') }}</textarea>
                                </div>

                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-actons">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn blue">
                                        ثبت
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
    <script type="text/javascript" src="{{asset('assets/common/plugins/ckeditor/ckeditor.js')}}"></script>
@endsection

@include('site.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        var text_field = 'message';
        var text_error = 'لطفا متن سوال را وارد کنید';

        $('#user_create_questions').validate({

            rules: {
                doctor_id: {
                    required: true
                },

                subject: {
                    required: true
                }
            },

            messages: {
                doctor_id: {
                    required: "لطفا دکتر را انتخاب کنید"
                },

                subject: {
                    required: "لطفا موضوع سوال را وارد کنید"
                },
            },
            submitHandler: function (form) {
                if (validateCkeditor(text_field, text_error) === true) {
                    form.submit();
                }
            }

        });

    });

</script>
