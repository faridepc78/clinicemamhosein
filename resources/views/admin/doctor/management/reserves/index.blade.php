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
                                                       href="{{route('management_doctor_reserves_index',$doctor->id)}}">مدیریت
                                نوبت های ({{$doctor->fullName}})</a></li>
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
                            <h3 class="card-title mb-3">مدیریت نوبت های دکتر ({{$doctor->fullName}})</h3>

                            <div class="card-tools">
                                <form id="filterForm" method="get" action="{{route('management_doctor_reserves_index',$doctor['id'])}}">
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input readonly id="search" value="{{request()->input('search')}}" type="text"
                                               name="search"
                                               class="form-control float-right"
                                               placeholder="جستجو بر اساس تاریخ گرفتن نوبت">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <a href="{{route('management_doctor_reserves_index',[$doctor['id'],'status='.\App\Models\DoctorReserve::VISITED])}}"
                               class="btn btn-success">@lang(\App\Models\DoctorReserve::VISITED)</a>

                            <a href="{{route('management_doctor_reserves_index',[$doctor['id'],'status='.\App\Models\DoctorReserve::UNVISITED])}}"
                               class="btn btn-warning">@lang(\App\Models\DoctorReserve::UNVISITED)</a>

                            <a href="{{route('management_doctor_reserves_index',[$doctor['id'],'status='.\App\Models\DoctorReserve::CANCELED])}}"
                               class="btn btn-danger">@lang(\App\Models\DoctorReserve::CANCELED)</a>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered text-center">

                                <tr>
                                    <th>ردیف</th>
                                    <th>بیمار</th>
                                    <th>تاریخ گرفتن نوبت</th>
                                    <th>زمان ویزیت</th>
                                    <th>وضعیت</th>
                                    <th>تغییر وضعیت به</th>
                                    <th>حذف</th>
                                </tr>

                                @if(count($data))

                                    @foreach($data as $key=>$value)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$value->patient->fullName}}</td>
                                            <td>{{\Morilog\Jalali\CalendarUtils::strftime('j F Y ساعت: H:i:s', strtotime($value['created_at']))}}</td>
                                            <td>{{$value->time->fullTime}}</td>
                                            {!! $value->status() !!}
                                            <td>
                                                @if ($value['status']==\App\Models\DoctorReserve::UNVISITED)
                                                    <a class="btn btn-success"
                                                       href="{{ route('management_doctor_reserves_change_status', [$doctor['id'],$value->id,\App\Models\DoctorReserve::VISITED]) }}">
                                                        ویزیت شده
                                                    </a>
                                                    <a class="btn btn-danger"
                                                       href="{{ route('management_doctor_reserves_change_status', [$doctor['id'],$value->id,\App\Models\DoctorReserve::CANCELED]) }}">
                                                        کنسل شده
                                                    </a>
                                                @elseif($value['status']==\App\Models\DoctorReserve::VISITED)
                                                    <a class="btn btn-warning"
                                                       href="{{ route('management_doctor_reserves_change_status', [$doctor['id'],$value->id,\App\Models\DoctorReserve::UNVISITED]) }}">
                                                        ویزیت نشده
                                                    </a>
                                                    <a class="btn btn-danger"
                                                       href="{{ route('management_doctor_reserves_change_status', [$doctor['id'],$value->id,\App\Models\DoctorReserve::CANCELED]) }}">
                                                        کنسل شده
                                                    </a>
                                                @elseif($value['status']==\App\Models\DoctorReserve::CANCELED)
                                                    <a class="btn btn-success"
                                                       href="{{ route('management_doctor_reserves_change_status', [$doctor['id'],$value->id,\App\Models\DoctorReserve::VISITED]) }}">
                                                        ویزیت شده
                                                    </a>
                                                    <a class="btn btn-warning"
                                                       href="{{ route('management_doctor_reserves_change_status', [$doctor['id'],$value->id,\App\Models\DoctorReserve::UNVISITED]) }}">
                                                        ویزیت نشده
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('management_doctor_reserves_destroy', [$doctor['id'],$value->id]) }}"
                                                   onclick="destroyDoctorReserve(event,{{ $doctor['id'] }}, {{ $value->id }})"><i
                                                        class="fa fa-remove text-danger"></i></a>
                                                <form
                                                    action="{{ route('management_doctor_reserves_destroy', [$doctor['id'],$value->id]) }}"
                                                    method="post"
                                                    id="destroy-DoctorReserve-{{ $doctor['id'] }}-{{ $value->id }}">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </td>
                                        </tr>

                                    @endforeach

                                @else

                                    <div class="alert alert-danger text-center">
                                        <p>اطلاعات این بخش ثبت نشده است</p>
                                    </div>

                                @endif

                            </table>

                        </div>

                        <div class="pagination mt-3">
                            {!! $data->withQueryString()->links() !!}
                        </div>

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

    $("#search").persianDatepicker({formatDate: "YYYY-0M-0D"});

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        var base_url = window.location.href;
        var route = "{{route('management_doctor_reserves_index',$doctor['id'])}}";
        var search = $('#search').val();

        if (search.length!==0){
            if (base_url.indexOf('?' + 'search' + '=') != -1 || base_url.indexOf('&' + 'search' + '=') != -1) {
                var new_url = replaceUrlParam(base_url, 'search', search);
                window.location.href = removeURLParameter(new_url, 'page');
            } else {
                if (base_url === route) {
                    this.submit();
                } else {
                    var new_url = base_url + '&search=' + search;
                    window.location.href = removeURLParameter(new_url, 'page');
                }
            }
        }

    })

    function destroyDoctorReserve(event, doctor_id, id) {
        event.preventDefault();
        Swal.fire({
            title: 'آیا از حذف اطمینان دارید ؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(221, 51, 51)',
            cancelButtonColor: 'rgb(48, 133, 214)',
            confirmButtonText: 'بله',
            cancelButtonText: 'خیر'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`destroy-DoctorReserve-${doctor_id}-${id}`).submit()
            }
        })
    }

</script>
