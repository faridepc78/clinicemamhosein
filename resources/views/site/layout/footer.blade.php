<div class="clearfix"></div>
<br class="visible-xs-block"/>
<br class="visible-xs-block"/>
<div id="Main_Fade" class="footer fade-in-up">

    <div class="container">
        <div class="row text-center" id="Footer_Font">
            <div class="col-md-12 col-sm-12 padding-top-10 Footer_Reserved">

                <img class="img-responsive" src="{{asset('assets/frontend/images/footer.png')}}" alt="footer">

                <div style="margin-top: 20px !important;">
                    © <a target="_blank" href="http://patterndp.ir">Designing & Development By Pattern Group</a>
                    <a href="{{route('terms-and-conditions')}}">قوانین</a>
                    |
                    <a href="{{route('support')}}">پشتیبانی</a>
                    |
                    <a href="{{route('about-us')}}"><i class="fa fa-info-circle"></i> درباره ما</a>

                    | <a href="{{route('blog')}}"><i class="fa fa-pencil"></i>&nbsp;&nbsp;وبلاگ </a>

                    <ul class="social-footer list-unstyled list-inline pull-right Footer_Social">

                        @if ($setting['telegram']!==null)
                            <li><a href="{{$setting['telegram']}}"><i class="fa fa-send"></i></a></li>
                        @endif

                        @if ($setting['instagram']!==null)
                            <li><a href="{{$setting['instagram']}}"><i class="fa fa-camera-retro"></i></a></li>
                        @endif

                        @if ($setting['linkedin']!==null)
                            <li><a href="{{$setting['linkedin']}}"><i class="fa fa-linkedin"></i></a></li>
                        @endif

                    </ul>
                </div>

            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('assets/frontend/js/jquery-2.2.2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/js/public.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/plugins/validation/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/plugins/validation/js/methods.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/frontend/plugins/slick/slick.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/frontend/js/home.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/plugins/toast/js/toast.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/common/plugins/toast/js/toast-options.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/frontend/js/bootstrap.min.js')}}"></script>
<script type="text/javascript">@include('site.layout.feedbacks')</script>

<script type="text/javascript">

    $(document).ready(function () {

        $('#myCarousel').carousel({
            interval: 4000
        });

        $('#slick-items').slick({
            slidesToShow: 5,
            slidesToScroll: 5,
            infinite: true,
            dots: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('#slick-items2').slick({
            rtl: true,
            dots: false,
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1000,
            responsive: [
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 360,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

    });

</script>

@yield('site_js')

</body>
</html>
