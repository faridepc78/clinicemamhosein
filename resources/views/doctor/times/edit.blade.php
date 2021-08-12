@section('doctor_title')
    <title>پنل دکتر درمانگاه شبانه روزی امام حسین (ع) | مدیریت زمان ها</title>
@endsection

@section('doctor_css')
    <link type="text/css" rel="stylesheet"
          href="{{asset('assets/common/plugins/persianDatepicker/css/persianDatepicker-default.css')}}">
@endsection

@include('doctor.layout.header')

@include('doctor.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('times.index')}}">مدیریت
                                زمان ها</a></li>
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('times.edit',[$time['id']])}}">ویرایش
                                زمان</a></li>
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
                            <h3 class="card-title">ویرایش زمان</h3>
                        </div>

                        <form id="update_doctor_time_form"
                              action="{{route('times.update',[$time['id']])}}"
                              method="post">

                            @csrf
                            @method('patch')

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="date">تاریخ ویزیت *</label>
                                    <input readonly onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('date') is-invalid @enderror"
                                           value="{{ old('date',\Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($time['date']))) }}"
                                           id="date"
                                           name="date"
                                           placeholder="لطفا تاریخ ویزیت را وارد کنید"
                                           autocomplete="date" autofocus>

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="start_time">ساعت شروع ویزیت *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('start_time') is-invalid @enderror"
                                           value="{{ old('start_time',$time['start_time']) }}" id="start_time"
                                           name="start_time"
                                           placeholder="لطفا ساعت شروع ویزیت را وارد کنید"
                                           autocomplete="start_time" autofocus>

                                    @error('start_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="end_time">ساعت پایان ویزیت *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('end_time') is-invalid @enderror"
                                           value="{{ old('end_time',$time['end_time']) }}" id="end_time"
                                           name="end_time"
                                           placeholder="لطفا ساعت پایان ویزیت را وارد کنید"
                                           autocomplete="end_time" autofocus>

                                    @error('end_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="capacity">ظرفیت ویزیت *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('capacity') is-invalid @enderror"
                                           value="{{ old('capacity',$time['capacity']) }}" id="capacity"
                                           name="capacity"
                                           placeholder="لطفا ظرفیت ویزیت را وارد کنید"
                                           autocomplete="capacity" autofocus>

                                    @error('capacity')
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

@section('doctor_js')
    <script type="text/javascript"
            src="{{asset('assets/common/plugins/persianDatepicker/js/persianDatepicker.min.js')}}"></script>
@endsection

@include('doctor.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        $("#date").persianDatepicker({formatDate: "YYYY/0M/0D"});

        $('#update_doctor_time_form').validate({

            rules: {
                date: {
                    required: true
                },

                start_time: {
                    required: true,
                    number: true
                },

                end_time: {
                    required: true,
                    number: true
                },

                capacity: {
                    required: true,
                    number: true
                }
            },

            messages: {
                date: {
                    required: "لطفا تاریخ ویزیت را انتخاب کنید"
                },

                start_time: {
                    required: "لطفا ساعت شروع ویزیت را وارد کنید",
                    number: "لطفا ساعت شروع ویزیت را صحیح وارد کنید"
                },

                end_time: {
                    required: "لطفا ساعت پایان ویزیت را وارد کنید",
                    number: "لطفا ساعت پایان ویزیت را صحیح وارد کنید"
                },

                capacity: {
                    required: "لطفا ظرفیت ویزیت را وارد کنید",
                    number: "لطفا ظرفیت ویزیت را صحیح وارد کنید"
                }
            }

        });

    });

</script>
