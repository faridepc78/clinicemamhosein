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
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('times.index')}}">مدیریت
                                زمان ها</a></li>
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
                            <h3 class="card-title mb-3">مدیریت زمان ها</h3>

                            <div class="card-tools">
                                <form id="filterForm" method="get" action="{{route('times.index')}}">
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input readonly id="search" value="{{request()->input('search')}}" type="text"
                                               name="search"
                                               class="form-control float-right"
                                               placeholder="جستجو بر اساس تاریخ">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <a href="{{route('times.index',['status='.'active'])}}"
                               class="btn btn-success">منقضی نشده(تاریخ)</a>

                            <a href="{{route('times.index',['status='.'not-capacity'])}}"
                               class="btn btn-warning">اتمام ظرفیت</a>

                            <a href="{{route('times.index',['status='.'expire-date'])}}"
                               class="btn btn-danger">منقضی شده(تاریخ)</a>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered text-center">

                                <tr>
                                    <th>ردیف</th>
                                    <th>تاریخ</th>
                                    <th>بازه زمانی</th>
                                    <th>ظرفیت</th>
                                    <th>ویرایش</th>
                                    <th>حذف</th>
                                </tr>

                                @if(count($data))

                                    @foreach($data as $key=>$value)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{\Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($value['date']))}}</td>
                                            <td>{{$value->time}}</td>
                                            <td>{{$value->capacity}}</td>
                                            <td>
                                                <a target="_blank" href="{{route('times.edit',[$value->id])}}">
                                                    <i class="fa fa-edit text-primary"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('times.destroy', [$value->id]) }}"
                                                   onclick="destroyDoctorTime(event, {{ $value->id }})"><i
                                                        class="fa fa-remove text-danger"></i></a>
                                                <form
                                                    action="{{ route('times.destroy', [$value->id]) }}"
                                                    method="post"
                                                    id="destroy-DoctorTime-{{ $value->id }}">
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
        var route = "{{route('times.index')}}";
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

    function destroyDoctorTime(event, id) {
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
                document.getElementById(`destroy-DoctorTime-${id}`).submit()
            }
        })
    }

</script>
