@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | درباره ما</title>
@endsection

@include('site.layout.header')

<div class="main">

    <div class="row center-block margin-top-40 about-page">
        <div class="col-md-8 col-md-offset-2">
            <h1>درباره ما</h1>

            <div dir="rtl">

                @if ($setting['about']!==null)
                    {!! $setting['about'] !!}
                @endif

            </div>

        </div>
    </div>
</div>

@include('site.layout.footer')
