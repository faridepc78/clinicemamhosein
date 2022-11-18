@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | جستجو</title>
@endsection

@include('site.layout.header')

<div class="main">

    <div id="Search" class="row center-block margin-top-20 page-body">

        <div class="col-md-12 col-sm-12 search-results-page">

            @if (count($doctors))

                @foreach($doctors as $value)

                    <div class="row search-row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-8">

                                    <h3 class="weight-h3 spurple">دکتر&nbsp;{{$value->f_name}} {{$value->l_name}}</h3>
                                    <p class="small-s2-font margin-bottom-0 margin-right-05 attribute"><i
                                            class="fa fa-flask spurple padding-left-05 small-s2-font"></i><span
                                            class="small-n-font">متخصص:</span><span class="highlight">&nbsp;{{$value->doctor->expertise->name}}</span>
                                    </p>

                                    <p class="small-s2-font margin-bottom-0 margin-right-05 attribute"><i
                                            class="fa  fa-check-square-o spurple padding-left-05 small-s2-font"></i><span
                                            class="small-n-font">حوزه تخصصی:</span>
                                        <span>&nbsp{{$value->doctor->specialized_fields}}</span>
                                    </p>

                                    <br/>

                                    <div class="note note-info">
                                        <div class="more-search-header">

                                    <span class="down-arrow cursor-hand info_btn"
                                          onclick="changeClass({{$value['id']}});"><i id="info_icon-{{$value['id']}}"
                                                                                      class="fa fa-chevron-down"
                                                                                      aria-hidden="true"></i></span>

                                            <h5 class="weight-h3">مطب</h5>
                                            <a class="btn-circle radiation-animation green-light"
                                               href="{{$value->path()}}">
                                                <span>رزرو</span>
                                            </a>
                                            <div style="clear:both;"></div>
                                        </div>

                                        <div id="info_div-{{$value['id']}}" class="more-search-content"
                                             onclick="changeClass()">
                                            <br>
                                            <ul>

                                                <li class="small-s2-font margin-bottom-0 margin-right-05 attribute"><i
                                                        class="fa fa-phone spurple padding-left-05 small-s2-font"></i><span>تلفن:</span>
                                                    <span class="small-s-font">{{$value->doctor->phone}}</span></li>

                                            </ul>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-2">

                            <div class="hospital-intro-pic center-block" id="sina-hospital-pic"
                                 style="background-image: url({{$value->profile}})">
                            </div>

                        </div>
                    </div>

                @endforeach

            @endif

            <div class="pagination">
                {!! $doctors->links() !!}
            </div>

        </div>

    </div>

    <div class="clearfix"></div>

</div>

@include('site.layout.footer')

<script type="text/javascript">

    function changeClass(id) {
        var info_div = '#info_div-' + id;
        var info_icon = '#info_icon-' + id;

        if ($(info_icon).hasClass('fa-chevron-down')) {
            $(info_icon).toggleClass('fa-chevron-down').addClass('fa-chevron-up');
        } else {
            $(info_icon).toggleClass('fa-chevron-up').addClass('fa-chevron-down');
        }

        $(info_div).toggleClass('open my_height');
    }

</script>
