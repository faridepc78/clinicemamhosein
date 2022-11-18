@section('admin_title')
    <title>پنل مدیریت درمانگاه شبانه روزی امام حسین (ع) | مدیریت دکتر ({{$doctor->fullName}})</title>
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
                                                       href="{{route('management_doctor',$doctor['id'])}}">مدیریت
                                دکتر ({{$doctor->fullName}})</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-3">مدیریت دکتر ({{$doctor->fullName}})</h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered text-center">

                                <tr>
                                    <th>اطلاعات</th>
                                    <th>مدیریت درباره</th>
                                    <th>مدیریت گالری</th>
                                    <th>مدیریت زمان ها</th>
                                    <th>مدیریت نوبت ها</th>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0)" data-toggle="modal"
                                           data-target="#doctorInfo">
                                            <i class="fa fa-eye text-success"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <a target="_blank"
                                           href="{{route('management_doctor_about',$doctor['id'])}}">
                                            <i class="fa fa-tasks text-primary"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <a target="_blank" href="{{route('management_doctor_gallery',$doctor['id'])}}">
                                            <i class="fa fa-image text-warning"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <a target="_blank" href="{{route('management_doctor_times_index',$doctor['id'])}}">
                                            <i class="fa fa-clock-o text-info"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <a target="_blank" href="{{route('management_doctor_reserves_index',$doctor['id'])}}">
                                            <i class="fa fa-database text-danger"></i>
                                        </a>
                                    </td>
                                </tr>

                                <div class="modal fade mt-lg-5"
                                     id="doctorInfo" tabindex="-1"
                                     role="dialog"
                                     aria-hidden="true">

                                    <div class="modal-dialog modal-lg" role="document">

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <h6 class="modal-title">
                                                    اطلاعات دکتر
                                                    ({{$doctor->fullName}})
                                                </h6>

                                                <a style="color: red;cursor: pointer"
                                                   data-dismiss="modal" aria-label="Close">
                                                    <i style="color: red" class="fa fa-close"></i>
                                                </a>

                                            </div>

                                            <div class="modal-body">

                                                <div class="col-md-12 form-row justify-content-center">
                                                    <img width="50" height="50" src="{{$doctor->profile}}"
                                                         alt="{{$doctor->profile}}">
                                                </div>

                                                <div class="col-md-12 form-row">

                                                    <div class="form-group col-md-4">
                                                        <label for="full_name">
                                                            نام و نام خانوادگی
                                                        </label>
                                                        <input id="full_name" class="form-control" readonly
                                                               value="{{$doctor->fullName}}">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="mobile">
                                                            تلفن همراه
                                                        </label>
                                                        <input id="mobile" class="form-control text-left" readonly
                                                               value="{{$doctor->mobile}}">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="national_code">
                                                            کد ملی
                                                        </label>
                                                        <input id="national_code" class="form-control text-left"
                                                               readonly value="{{$doctor->national_code}}">
                                                    </div>

                                                </div>

                                                <div class="form-row col-md-12">

                                                    <div class="form-group col-md-4">
                                                        <label for="birthday">
                                                            تاریخ تولد
                                                        </label>
                                                        <input id="birthday" class="form-control text-left" readonly
                                                               value="{{\Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($doctor['birthday']))}}">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="sex">
                                                            جنسیت
                                                        </label>
                                                        <input id="sex" class="form-control" readonly
                                                               value="@lang($doctor->sex)">
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </table>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

@include('admin.layout.footer')
