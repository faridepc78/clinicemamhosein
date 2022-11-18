@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | دکتر ({{$doctor->fullName}})</title>
@endsection

@section('site_css')
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/frontend/plugins/lightgallery/css/lightgallery.css')}}">
@endsection

@include('site.layout.header')

<div class="main">

    <div id="Clinic"
         class="row center-block margin-top-20  page-body">
        <div class="col-md-12">

            <div class="hospital-name-container">
                <h1 class="container-name-text" style="font-size:27.03px;">{{$doctor->fullName}}</h1>
            </div>

            <div class="row">
                <div class="col-md-12 padding-top-5" id="profile-right-box">
                    <br class="visible-sm visible-xs"/>
                    <br class="visible-sm visible-xs"/>
                    <br class="visible-sm visible-xs"/>
                    <br class="visible-sm visible-xs"/>
                    <br class="visible-sm visible-xs"/>
                    <br class="visible-sm visible-xs"/>
                    <br class="visible-sm visible-xs"/>
                    <br class="visible-sm visible-xs"/>

                    <p class="font-size-15">
                        <i class="fa  fa-check-square-o "></i>&nbsp;{{$doctor->doctor->experience}} سال تجربه
                    </p>

                    @if ($doctor->doctor->phone!=null)
                        <p class="font-size-15"><i class="fa fa-phone"></i>&nbsp;تلفن: {{$doctor->doctor->phone}} </p>
                    @endif

                </div>

            </div>

            <div class="row margin-top-20">
                <div class="col-md-3 col-sm-3">
                    <h4 class="hos-spec-head">حوزه های تخصصی </h4>
                    <hr id="spec-hr">
                    <div class="hos-spec-body">
                        <div class="spec-flex">
                            <a href=""><span>{{$doctor->doctor->expertise->name}}</span></a>

                        </div>
                    </div>
                </div>

                <div class="hp-content col-md-9">
                    <ul class="nav nav-tabs border-color-grey">

                        <li id="about_tab" class="active">
                            <a>درباره</a>
                        </li>

                        <li id="reserve_tab">
                            <a>وقتهای رزرو </a>
                        </li>

                        <li id="gallery_tab">
                            <a>گالری تصاویر </a>
                        </li>

                    </ul>

                    <div class="tab-content background-color-white">

                        @include('site.doctor.about')

                        @include('site.doctor.reserve')

                        @include('site.doctor.gallery')

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@section('site_js')
    <script type="text/javascript"
            src="{{asset('assets/frontend/plugins/lightgallery/js/picturefill.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/frontend/plugins/lightgallery/js/lightgallery.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/frontend/plugins/lightgallery/js/lg-pager.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/frontend/plugins/lightgallery/js/lg-autoplay.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/frontend/plugins/lightgallery/js/lg-fullscreen.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/frontend/plugins/lightgallery/js/lg-zoom.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/frontend/plugins/lightgallery/js/lg-hash.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/frontend/plugins/lightgallery/js/lg-share.js')}}"></script>
    <script type="text/javascript">
        lightGallery(document.getElementById('gallery'), {
            download: false,
            cssEasing: 'cubic-bezier(0.25, 0, 0.25, 1)',
            zoom: true
        });
    </script>
@endsection

@include('site.layout.footer')

<script type="text/javascript">

    function submitReserveForm() {
        $('#reserve_form').submit();
    }

    $(document).ready(function () {

        let about_tab = $('#about_tab');
        let about_div = $('#about_div');

        let reserve_tab = $('#reserve_tab');
        let reserve_div = $('#reserve_div');

        let gallery_tab = $('#gallery_tab');
        let gallery_div = $('#gallery_div');

        about_tab.on('click', function () {
            about_div.addClass('active');
            reserve_div.removeClass('active');
            gallery_div.removeClass('active');
        });

        reserve_tab.on('click', function () {
            reserve_div.addClass('active');
            about_div.removeClass('active');
            gallery_div.removeClass('active');
        });

        gallery_tab.on('click', function () {
            gallery_div.addClass('active');
            about_div.removeClass('active');
            reserve_div.removeClass('active');
        });

    });

</script>
