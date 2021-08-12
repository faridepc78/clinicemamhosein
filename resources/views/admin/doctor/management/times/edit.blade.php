@section('admin_title')
    <title>پنل مدیریت درمانگاه شبانه روزی امام حسین (ع) | مدیریت زمان های دکتر ({{$doctor->fullName}})</title>
@endsection

@section('admin_css')
    <link type="text/css" rel="stylesheet"
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
                        <li class="breadcrumb-item"><a href="{{route('management_doctor',$doctor['id'])}}">مدیریت دکتر
                                ({{$doctor->fullName}})</a></li>
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('management_doctor_times_index',$doctor->id)}}">مدیریت
                                زمان های ({{$doctor->fullName}})</a></li>
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('management_doctor_times_edit',[$doctor->id,$time['id']])}}">ویرایش
                                زمان های ({{$doctor->fullName}})</a></li>
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
                            <h3 class="card-title">ویرایش زمان های دکتر ({{$doctor->fullName}})</h3>
                        </div>

                        <form id="update_doctor_time_form"
                              action="{{route('management_doctor_times_update',[$doctor['id'],$time['id']])}}"
                              method="post">

                            @csrf
                            @method('patch')

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="date">تاریخ ویزیت دکتر *</label>
                                    <input readonly onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('date') is-invalid @enderror"
                                           value="{{ old('date',\Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($time['date']))) }}"
                                           id="date"
                                           name="date"
                                           placeholder="لطفا تاریخ ویزیت دکتر را وارد کنید"
                                           autocomplete="date" autofocus>

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="start_time">ساعت شروع ویزیت دکتر *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('start_time') is-invalid @enderror"
                                           value="{{ old('start_time',$time['start_time']) }}" id="start_time"
                                           name="start_time"
                                           placeholder="لطفا ساعت شروع ویزیت دکتر را وارد کنید"
                                           autocomplete="start_time" autofocus>

                                    @error('start_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="end_time">ساعت پایان ویزیت دکتر *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('end_time') is-invalid @enderror"
                                           value="{{ old('end_time',$time['end_time']) }}" id="end_time"
                                           name="end_time"
                                           placeholder="لطفا ساعت پایان ویزیت دکتر را وارد کنید"
                                           autocomplete="end_time" autofocus>

                                    @error('end_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="capacity">ظرفیت ویزیت دکتر</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('capacity') is-invalid @enderror"
                                           value="{{ old('capacity',$time['capacity']) }}" id="capacity"
                                           name="capacity"
                                           placeholder="ظرفیت ویزیت دکتر را وارد کنید"
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

@section('admin_js')
    <script type="text/javascript"
            src="{{asset('assets/common/plugins/persianDatepicker/js/persianDatepicker.min.js')}}"></script>
@endsection

@include('admin.layout.footer')

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
                    number: true
                }
            },

            messages: {
                date: {
                    required: "لطفا تاریخ ویزیت دکتر را انتخاب کنید"
                },

                start_time: {
                    required: "لطفا ساعت شروع ویزیت دکتر را وارد کنید",
                    number: "لطفا ساعت شروع ویزیت دکتر را صحیح وارد کنید"
                },

                end_time: {
                    required: "لطفا ساعت پایان ویزیت دکتر را وارد کنید",
                    number: "لطفا ساعت پایان ویزیت دکتر را صحیح وارد کنید"
                },

                capacity: {
                    number: "لطفا ظرفیت ویزیت دکتر را صحیح وارد کنید"
                }
            }

        });

    });

</script>
