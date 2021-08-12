@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | قوانین و مقررات</title>
@endsection

@include('site.layout.header')

<div class="main">

    <div class="row center-block margin-top-40 about-page">
        <div class="col-md-8 col-md-offset-2">
            <h1>قوانین و مقررات</h1>

            @if ($setting['terms']!==null)
                {!! $setting['terms'] !!}
            @endif

            <br>
            <br>

        </div>
    </div>
</div>

@include('site.layout.footer')
