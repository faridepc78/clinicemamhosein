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
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('questions.index')}}">مدیریت پرسش ها</a></li>
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
                            <h3 class="card-title mb-3">مدیریت پرسش ها</h3>

                            <div class="card-tools">
                                <form id="filterForm" method="get" action="{{route('questions.index')}}">
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input onkeyup="this.value=removeSpaces(this.value)" id="search"
                                               value="{{request()->input('search')}}" type="text"
                                               name="search"
                                               class="form-control float-right"
                                               placeholder="جستجو بر اساس موضوع و نام بیمار">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <a href="{{route('questions.index',['status='.\App\Models\Question::READE])}}"
                               class="btn btn-success">@lang(\App\Models\Question::READE)</a>

                            <a href="{{route('questions.index',['status='.\App\Models\Question::UNREAD])}}"
                               class="btn btn-danger">@lang(\App\Models\Question::UNREAD)</a>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered text-center">

                                <tr>
                                    <th>ردیف</th>
                                    <th>بیمار</th>
                                    <th>موضوع</th>
                                    <th>تاریخ و زمان</th>
                                    <th>وضعیت</th>
                                    <th>جزئیات</th>
                                    <th>حذف</th>
                                </tr>

                                @if(count($data))

                                    @foreach($data as $key=>$value)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$value->patient->fullName}}</td>
                                            <td>{{$value->subject}}</td>
                                            <td>{{\Morilog\Jalali\CalendarUtils::strftime('j F Y ساعت: H:i:s', strtotime($value['created_at']))}}</td>
                                            {!! $value->status() !!}
                                            <td><a href="{{route('questions.details',$value['id'])}}" target="_blank"><i
                                                        class="fa fa-eye text-success"></i></a></td>
                                            <td>
                                                <a href="{{ route('questions.destroy', $value->id) }}"
                                                   onclick="destroyQuestion(event, {{ $value->id }})"><i
                                                        class="fa fa-remove text-danger"></i></a>
                                                <form action="{{ route('questions.destroy', $value->id) }}"
                                                      method="post" id="destroy-Question-{{ $value->id }}">
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

@include('doctor.layout.footer')

<script type="text/javascript">

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        var base_url = window.location.href;
        var route = "{{route('questions.index')}}";
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

    function destroyQuestion(event, id) {
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
                document.getElementById(`destroy-Question-${id}`).submit()
            }
        })
    }

</script>
