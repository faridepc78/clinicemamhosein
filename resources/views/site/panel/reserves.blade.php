@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | پنل بیمار</title>
@endsection

@include('site.layout.header')

<div class="main">

    <div id="Profile" class="row profile-page">
        <div class="col-md-12">

            <div class="row margin-top-20">
                <div class="col-md-12 ">
                    <img class="client-avatar center-block" width="100"
                         src="{{auth()->user()->profile}}"/>
                </div>
            </div>

            <div class="row">
                <h2 class="col-md-12 margin-top-10 ">{{auth()->user()->fullName}}</h2>
            </div>

            @include('site.panel.menu')

            <div class="tab-content">

                <div class="col-md-6 col-sm-12">

                    <form id="filterForm" method="get" action="{{route('user_reserves')}}">
                        <input onkeyup="this.value=removeSpaces(this.value)" value="{{request()->input('search')}}" id="search" name="search" type="text"
                               class="form-control input-large input-inline font-IRANSans"
                               placeholder="جستجو بر اساس نام دکتر">
                        <button style="margin-right: -5px;margin-bottom: 5px" type="submit" class="btn btn-default"><i
                                class="fa fa-search"></i>
                        </button>
                    </form>

                    <br>

                    <a href="{{route('user_reserves','status='.\App\Models\DoctorReserve::VISITED)}}"
                       class="btn btn-success">@lang(\App\Models\DoctorReserve::VISITED)</a>

                    <a href="{{route('user_reserves','status='.\App\Models\DoctorReserve::UNVISITED)}}"
                       class="btn btn-warning">@lang(\App\Models\DoctorReserve::UNVISITED)</a>

                    <a href="{{route('user_reserves','status='.\App\Models\DoctorReserve::CANCELED)}}"
                       class="btn btn-danger">@lang(\App\Models\DoctorReserve::CANCELED)</a>

                    <br><br>
                </div>

                <div class="tab-pane active in">
                    <div class="table-clearfix">
                        <table class="table table-hover table-bordered table-advance" id="T_list">
                            <thead>
                            <tr>
                                <th>ردیف</th>

                                <th>پزشک</th>

                                <th>تخصص</th>

                                <th>تاریخ</th>

                                <th>زمان حضور</th>

                                <th>وضعیت</th>

                                <th>عملیات</th>
                            </tr>
                            </thead>

                            @if (count($reserves))

                                @foreach($reserves as $key=>$value)

                                    <tbody>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->doctor->fullName}}</td>
                                    <td>{{$value->expertise->name}}</td>
                                    <td>{{\Morilog\Jalali\CalendarUtils::strftime('Y/m/d',strtotime($value->time->date))}}</td>
                                    <td>{{$value->time->time}}</td>
                                    {!! $value->status() !!}
                                    <td>
                                        @if ($value->status==\App\Models\DoctorReserve::UNVISITED && $value->time->date >= \Carbon\Carbon::now()->toDateString())
                                            <a href="{{ route('cancel_reserve') }}"
                                               onclick="cancelReserve(event, {{ $value->id }})"><i
                                                    class="fa fa-remove text-danger"></i></a>
                                            <form action="{{ route('cancel_reserve') }}"
                                                  method="post" id="cancel-Reserve-{{ $value->id }}">
                                                <input type="hidden" name="reserve_id"
                                                       value="{{\Vinkla\Hashids\Facades\Hashids::encode($value->id)}}">
                                                @csrf
                                            </form>
                                        @else
                                            _____
                                        @endif
                                    </td>
                                    </tbody>

                                @endforeach

                            @endif

                        </table>
                    </div>

                    <div class="pagination mt-3">
                        {!! $reserves->withQueryString()->links() !!}
                    </div>

                    <div class="clearfix"></div>
                </div>

            </div>

        </div>
    </div>

</div>

@section('site_js')
    <script type="text/javascript" src="{{asset('assets/common/plugins/sweetalert/js/sweetalert2@10.js')}}"></script>
@endsection

@include('site.layout.footer')

<script type="text/javascript">

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        var base_url = window.location.href;
        var route = "{{route('user_reserves')}}";
        var search = $('#search').val();

        /*if (search.length!==0){

        }*/
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
    })

    function cancelReserve(event, id) {
        event.preventDefault();
        Swal.fire({
            title: 'آیا از کنسل اطمینان دارید ؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(221, 51, 51)',
            cancelButtonColor: 'rgb(48, 133, 214)',
            confirmButtonText: 'بله',
            cancelButtonText: 'خیر'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`cancel-Reserve-${id}`).submit()
            }
        })
    }

</script>
