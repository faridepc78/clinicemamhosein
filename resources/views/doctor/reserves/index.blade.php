@section('doctor_title')
    <title>پنل دکتر درمانگاه شبانه روزی امام حسین (ع) | مدیریت نوبت ها</title>
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
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('reserves.index')}}">مدیریت
                                نوبت ها</a></li>
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
                            <h3 class="card-title mb-3">مدیریت نوبت ها</h3>

                            <div class="card-tools">
                                <form id="filterForm" method="get" action="{{route('reserves.index')}}">
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

                            <a href="{{route('reserves.index',['status='.\App\Models\DoctorReserve::VISITED])}}"
                               class="btn btn-success">@lang(\App\Models\DoctorReserve::VISITED)</a>

                            <a href="{{route('reserves.index',['status='.\App\Models\DoctorReserve::UNVISITED])}}"
                               class="btn btn-warning">@lang(\App\Models\DoctorReserve::UNVISITED)</a>

                            <a href="{{route('reserves.index',['status='.\App\Models\DoctorReserve::CANCELED])}}"
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
                                                       href="{{ route('reserves.change_status', [$value->id,\App\Models\DoctorReserve::VISITED]) }}">
                                                        ویزیت شده
                                                    </a>
                                                    <a class="btn btn-danger"
                                                       href="{{ route('reserves.change_status', [$value->id,\App\Models\DoctorReserve::CANCELED]) }}">
                                                        کنسل شده
                                                    </a>
                                                @elseif($value['status']==\App\Models\DoctorReserve::VISITED)
                                                    <a class="btn btn-warning"
                                                       href="{{ route('reserves.change_status', [$value->id,\App\Models\DoctorReserve::UNVISITED]) }}">
                                                        ویزیت نشده
                                                    </a>
                                                    <a class="btn btn-danger"
                                                       href="{{ route('reserves.change_status', [$value->id,\App\Models\DoctorReserve::CANCELED]) }}">
                                                        کنسل شده
                                                    </a>
                                                @elseif($value['status']==\App\Models\DoctorReserve::CANCELED)
                                                    <a class="btn btn-success"
                                                       href="{{ route('reserves.change_status', [$value->id,\App\Models\DoctorReserve::VISITED]) }}">
                                                        ویزیت شده
                                                    </a>
                                                    <a class="btn btn-warning"
                                                       href="{{ route('reserves.change_status', [$value->id,\App\Models\DoctorReserve::UNVISITED]) }}">
                                                        ویزیت نشده
                                                    </a>
                                                @endif
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

@section('doctor_js')
    <script type="text/javascript"
            src="{{asset('assets/common/plugins/persianDatepicker/js/persianDatepicker.min.js')}}"></script>
@endsection

@include('doctor.layout.footer')

<script type="text/javascript">

    $("#search").persianDatepicker({formatDate: "YYYY-0M-0D"});

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        var base_url = window.location.href;
        var route = "{{route('reserves.index')}}";
        var search = $('#search').val();

        if (search.length !== 0) {
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

</script>
