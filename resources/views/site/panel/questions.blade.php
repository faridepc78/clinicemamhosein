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

                    <form id="filterForm" method="get" action="{{route('user_questions')}}">
                        <input onkeyup="this.value=removeSpaces(this.value)" value="{{request()->input('search')}}"
                               id="search" name="search" type="text"
                               class="form-control input-large input-inline font-IRANSans"
                               placeholder="جستجو بر اساس موضوع و نام دکتر">
                        <button style="margin-right: -5px;margin-bottom: 5px" type="submit" class="btn btn-default"><i
                                class="fa fa-search"></i>
                        </button>
                    </form>

                    <br>

                    <a href="{{route('user_questions','status='.\App\Models\Question::READE)}}"
                       class="btn btn-success">@lang(\App\Models\Question::READE)</a>

                    <a href="{{route('user_questions','status='.\App\Models\Question::UNREAD)}}"
                       class="btn btn-danger">@lang(\App\Models\Question::UNREAD)</a>

                    <br><br>
                </div>

                <div class="tab-pane active in">
                    <div class="table-clearfix">
                        <table class="table table-hover table-bordered table-advance" id="T_list">
                            <thead>
                            <tr>
                                <th>ردیف</th>

                                <th>پزشک</th>

                                <th>موضوع</th>

                                <th>تاریخ و زمان</th>

                                <th>وضعیت</th>

                                <th>جزئیات</th>
                            </tr>
                            </thead>

                            @if (count($questions))

                                @foreach($questions as $key=>$value)

                                    <tbody>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->doctor->fullName}}</td>
                                    <td>{{$value->subject}}</td>
                                    <td>{{\Morilog\Jalali\CalendarUtils::strftime('Y/m/d || H:i:s',strtotime($value->created_at))}}</td>
                                    {!! $value->status() !!}
                                    <td>
                                        <a href="{{route('user_questions_details',\Vinkla\Hashids\Facades\Hashids::encode($value->id))}}"
                                           target="_blank"><i class="fa fa-eye text-success"></i></a></td>
                                    </tbody>

                                @endforeach

                            @endif

                        </table>
                    </div>

                    <div class="pagination mt-3">
                        {!! $questions->withQueryString()->links() !!}
                    </div>

                    <div class="clearfix"></div>
                </div>

            </div>

        </div>
    </div>

</div>

@include('site.layout.footer')

<script type="text/javascript">

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        var base_url = window.location.href;
        var route = "{{route('user_questions')}}";
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
