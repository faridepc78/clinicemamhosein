@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | خانه</title>
@endsection

@section('site_css')
    <link rel="stylesheet" href="{{asset('assets/frontend/css/post.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/rtl.css')}}">
@endsection

@include('site.layout.header')

<div class="main">

    <div id="Home" class="container ng-scope">

        <div class="row fade-in-up center-block">
            <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
                <div class="row">
                    <div class="col-md-12">
                        <img style="height: 250px!important;margin-top: 50px" class="center-block logo-sh img-size-64"
                             alt="درمانگاه شبانه روزی امام حسین (ع)"
                             src="{{asset('assets/frontend/images/logo.png')}}"
                             title="درمانگاه شبانه روزی امام حسین (ع)">
                    </div>
                </div>

                <div class="row form">

                    <form onkeyup="this.value=removeSpaces(this.value)" id="search_doctor_form" method="get"
                          action="{{route('search')}}">

                        <div id="search-box-home" class="form-group">
                            <div class="input-group">

                                <input style="border-color: #1BA39C" class="form-control input-lg fadeInRight"
                                       id="search"
                                       placeholder="نام پزشک یا تخصص را وارد کنید."
                                       type="text" name="search">

                                <span class="input-group-btn">
                                    <button id="search-btn" class="btn btn-success btn-lg home-search-btn"
                                            type="submit"><i class="search-icon"></i></button>
                                </span>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div id="home-main-item" class="container">
            <div class="row speciality fade-in-up center-block LG_PADD">

                <a id="home-expert" href="#home-main-item" class="col-md-4 col-sm-4 col-xs-6">
                    <img src="{{asset('assets/frontend/images/Expert_2.svg')}}" class="center-block my-center-icons">
                    <span>&zwnj;&zwnj;تخصص ها</span>
                    <span id="expert-tip" style="border-top-color: white;"></span>
                </a>

                <a id="home-doctor" href="#home-main-item" class="col-md-4 col-sm-4 col-xs-6">
                    <img src="{{asset('assets/frontend/images/Expert_2.svg')}}" class="center-block my-center-icons">
                    <span>دکتر ها</span>
                    <span id="doctor-tip" style="border-top-color: white;"></span>
                </a>

                <a href="{{route('about-us')}}" class="col-md-4 col-sm-4 col-xs-6">
                    <img src="{{asset('assets/frontend/images/HospitalClinic_2.svg')}}" class="center-block my-center-icons">
                    <span>کلینک ها</span>
                </a>

            </div>
        </div>

        <div id="home-expert-list" class="home-item-list" style="display: none;">
            <a class="close-thik" href="#home-main-item" title="بستن"></a>
            <div class="row speciality ltr fade-in-up center-block LG_PADD">

                @if (count($expertises))

                    @foreach($expertises as $expertise)

                        <a href="{{$expertise->path()}}" class="col-md-1 col-sm-2 col-xs-4">
                            <img src="{{$expertise->image->original}}" class="center-block LG_WIDTH"
                                 alt="{{$expertise->name}}">
                            <span>{{$expertise->name}}</span>
                        </a>

                    @endforeach

                @endif

            </div>

        </div>

        <div id="home-doctor-list" class="home-item-list" style="display: none;">
            <a class="close-thik" href="#home-main-item" title="بستن"></a>
            <div class="row speciality ltr fade-in-up center-block LG_PADD">

                @if (count($doctors))

                    @foreach($doctors as $doctor)

                        <a href="{{$doctor->path()}}" class="col-md-1 col-sm-2 col-xs-4">
                            <img src="{{$doctor->profile}}" class="center-block LG_WIDTH"
                                 alt="{{$doctor->fullName}}">
                            <span>{{$doctor->fullName}}</span>
                            <span style="color: red">{{$doctor->doctor->expertise->name}}</span>
                        </a>

                    @endforeach

                @endif

            </div>
        </div>

        <div class="clearfix"></div>
    </div>

    @include('site.home.doctors')

    @include('site.home.popular_doctors')

    @include('site.home.new_posts')

{{--    @include('site.home.about_box')--}}

    @include('site.home.partners')

</div>

@include('site.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        $('#search_doctor_form').on('submit', function (e) {
            e.preventDefault();
            var search = $('#search').val();

            if (search.length !== 0) {
                this.submit();
            }

        });

    });
</script>
