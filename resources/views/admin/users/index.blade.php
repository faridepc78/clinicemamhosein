@section('admin_title')
    <title>پنل مدیریت درمانگاه شبانه روزی امام حسین (ع) | کاربران</title>
@endsection

@include('admin.layout.header')

@include('admin.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="my-active" href="{{route('users.index')}}">مدیریت
                                کاربران</a></li>
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
                            <h3 class="card-title mb-3">مدیریت کاربران</h3>

                            <div class="card-tools">
                                <form id="filterForm" method="get" action="{{route('users.index')}}">
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input onkeyup="this.value=removeSpaces(this.value)" id="search" value="{{request()->input('search')}}" type="text"
                                               name="search"
                                               class="form-control float-right"
                                               placeholder="جستجو بر اساس نام،کد ملی و تلفن همراه">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <a href="{{route('users.index',['role='.\App\Models\User::ADMIN])}}"
                               class="btn btn-success">مدیر</a>

                            <a href="{{route('users.index',['role='.\App\Models\User::DOCTOR])}}"
                               class="btn btn-primary">پزشک</a>

                            <a href="{{route('users.index',['role='.\App\Models\User::CLERK])}}"
                               class="btn btn-warning">منشی</a>

                            <a href="{{route('users.index',['role='.\App\Models\User::PATIENT])}}"
                               class="btn btn-danger">بیمار</a>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered text-center">

                                <tr>
                                    <th>ردیف</th>
                                    <th>نام و نام خانوادگی</th>
                                    <th>تلفن همراه</th>
                                    <th>کد ملی</th>
                                    <th>پروفایل</th>
                                    <th>نقش کاربری</th>
                                    <th>مدیریت</th>
                                    <th>ویرایش</th>
                                    <th>حذف</th>
                                </tr>

                                @if(count($users))

                                    @foreach($users as $key=>$value)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$value->fullName}}</td>
                                            <td>{{$value->mobile}}</td>
                                            <td>{{$value->national_code}}</td>
                                            <td><img width="50" height="50" src="{{$value->profile}}"
                                                     alt="{{$value->profile}}"></td>
                                            <td>@lang($value->role)</td>

                                            @can('checkDoctor',[\App\Models\User::class,$value['id']])
                                                <td>
                                                    <a target="_blank" href="{{route('management_doctor',$value->id)}}">
                                                        <i class="fa fa-database text-success"></i>
                                                    </a>
                                                </td>
                                            @else
                                                <td>
                                                    <i class="fa fa-lock text-dark"></i>
                                                </td>
                                            @endcan

                                            @can('update_user',[\App\Models\User::class,$value['id']])
                                                <td>
                                                    <a target="_blank" href="{{route('users.edit',$value->id)}}">
                                                        <i class="fa fa-edit text-primary"></i>
                                                    </a>
                                                </td>
                                            @else
                                                <td>
                                                    <i class="fa fa-lock text-dark"></i>
                                                </td>
                                            @endcan

                                            @can('destroy_user',[\App\Models\User::class,$value['id']])
                                                <td><a href="{{ route('users.destroy', $value->id) }}"
                                                       onclick="destroyUser(event, {{ $value->id }})"><i
                                                            class="fa fa-remove text-danger"></i></a>
                                                    <form action="{{ route('users.destroy', $value->id) }}"
                                                          method="post" id="destroy-User-{{ $value->id }}">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                </td>
                                            @else
                                                <td>
                                                    <i class="fa fa-lock text-dark"></i>
                                                </td>
                                            @endcan

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
                            {!! $users->withQueryString()->links() !!}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

@include('admin.layout.footer')

<script type="text/javascript">

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        var base_url = window.location.href;
        var route = "{{route('users.index')}}";
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

    function destroyUser(event, id) {
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
                document.getElementById(`destroy-User-${id}`).submit()
            }
        })
    }
</script>
