@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | وبلاگ</title>
@endsection

@section('site_css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/post.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/rtl.css')}}">
@endsection

@include('site.layout.header')

<section class="page-title-area page-title-bg1" style="background-image: url('{{asset('assets/frontend/images/blog.jpg')}}')">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-title-content">
                    <h2>وبلاگ-دسته بندی ({{$category->name}})</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="blog-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="row">

                    @if (count($posts))

                        @foreach($posts as $value)

                            <div class="col-lg-6 col-md-6">
                                <div class="single-blog-post">
                                    <div class="post-image">
                                        <a href="{{$value->path()}}"><img src="{{$value->image->original}}" alt="{{$value->name}}"></a>
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <ul>
                                                <li>{{\Morilog\Jalali\CalendarUtils::strftime('l j F Y',$value->created_at)}}</li>
                                                <li><a href="{{$value->category->path()}}">{{$value->category->name}}</a></li>
                                            </ul>
                                        </div>
                                        <h3><a href="{{$value->path()}}">{{$value->name}}</a></h3>
                                        <p>{!! Str::limit($value->text) !!}</p>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    @endif

                    <div class="col-lg-12 col-md-12">

                        <div class="pagination-area mt-3">
                            {!! $posts->links() !!}
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <aside class="widget-area" id="secondary">

                    @include('site.blog.common.index')

                </aside>
            </div>

        </div>
    </div>
</section>

@include('site.layout.footer')

@include('site.blog.common.script')
