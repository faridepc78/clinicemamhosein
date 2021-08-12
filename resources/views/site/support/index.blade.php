@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | پشتیبانی</title>
@endsection

@include('site.layout.header')

<div class="main">


    <div class="row center-block margin-top-40 about-page">
        <div class="col-md-8 col-md-offset-2">
            <h1>پشتیبانی</h1>

            @if ($setting['support']!==null)
                {!! $setting['support'] !!}
            @endif

        </div>
    </div>
</div>

@include('site.layout.footer')
