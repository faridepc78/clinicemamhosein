@section('doctor_title')
    <title>پنل دکتر درمانگاه شبانه روزی امام حسین (ع) | مدیریت پرسش ها</title>
@endsection

@include('doctor.layout.header')

@include('doctor.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('questions.index')}}">مدیریت
                                پرسش ها</a></li>
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('questions.details',[$question['id']])}}">جزئیات
                                پرسش ({{$question->subject}})</a></li>
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
                            <h3 class="card-title">جزئیات پرسش ({{$question->subject}})</h3>
                        </div>

                        <form id="answer_question_form"
                              action="{{route('questions.answer',$question->id)}}"
                              method="post">

                            @csrf

                            <div class="card-body">

                                <div class="col-md-12 form-row">

                                    <div class="form-group col-md-6">
                                        <label for="patient">بیمار</label>
                                        <input readonly type="text"
                                               class="form-control"
                                               value="{{$question->patient->fullName}}" id="patient">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="subject">موضوع پرسش</label>
                                        <input readonly type="text"
                                               class="form-control"
                                               value="{{$question->subject}}" id="subject">
                                    </div>

                                </div>

                                <div class="col-md-12 form-row">

                                    <div class="form-group col-md-6">
                                        <label>فایل پیوست</label>
                                        @if ($question->media_id==null)
                                            <img alt="null" src="{{asset('assets/common/images/null.png')}}">
                                        @else
                                            <img width="150" height="150" src="{{$question->media->original}}"
                                                 alt="{{$question->media->original}}">
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="status">وضعیت پرسش</label>
                                        <input readonly type="text"
                                               class="form-control"
                                               value="@lang($question->status)" id="status">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="message">متن سوال</label>
                                    <textarea readonly
                                           class="form-control ckeditor" id="message">{{$question->message}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="answer">جواب سوال *</label>
                                    <textarea class="form-control ckeditor @error('answer') is-invalid @enderror"
                                              id="answer"
                                              name="answer" autocomplete="answer"
                                              autofocus>{{ old('answer',$question->answer) }}</textarea>

                                    @error('answer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">ثبت</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

@section('doctor_js')
    <script type="text/javascript"
            src="{{asset('assets/common/plugins/ckeditor/ckeditor.js')}}"></script>
@endsection

@include('doctor.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        var text_field = 'answer';
        var text_error = 'لطفا جواب سوال را وارد کنید';

        $('#answer_question_form').validate({

            submitHandler: function (form) {
                if (validateCkeditor(text_field, text_error) === true) {
                    form.submit();
                }
            }

        });

    });

</script>
