@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | پست ({{$post->name}})</title>
@endsection

@section('site_css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/post.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/rtl.css')}}">
@endsection

@include('site.layout.header')

<section class="page-title-area" style="background-image: url('{{asset('assets/frontend/images/post.jpg')}}')">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="page-title-content">
                    <h2>جزئیات پست ({{$post->name}})</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="blog-details-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="blog-details-desc">
                    <div class="article-image">
                        <img src="{{$post->image->original}}" alt="image">
                    </div>

                    <div class="article-content">
                        <div class="entry-meta">
                            <ul>
                                <li><span>منتشر شده در:</span> <i
                                        class="fa fa-calendar"></i> {{\Morilog\Jalali\CalendarUtils::strftime('l j F Y',$post->created_at)}}</li>
                            </ul>
                        </div>

                        <h3>{{$post->name}}</h3>

                        {!! $post->text !!}

                    </div>

                    <div class="article-footer">

                        <div class="article-tags">
                            <span><i class="fa fa-bookmark"></i></span>
                            <a href="{{$post->category->path()}}">{{$post->category->name}}</a>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <aside class="widget-area" id="secondary">

                    @include('site.blog.common.index')

                    <section class="widget widget_fovia_posts_thumb">

                        <h3 class="widget-title">پست های مرتبط</h3>

                        @if (count($related_posts))

                            @foreach($related_posts as $value)

                                <article class="item">
                                    <a href="{{$value->path()}}" class="thumb">
                                        <span class="fullimage cover" role="img" style="background-image: url({{$value->image->original}})"></span>
                                    </a>
                                    <div>
                                        <time>{{\Morilog\Jalali\CalendarUtils::strftime('l j F Y',$value->created_at)}}</time>
                                        <h4 class="title usmall"><a href="{{$value->path()}}">{{$value->name}}</a></h4>
                                    </div>
                                    <div class="clear"></div>
                                </article>

                            @endforeach

                        @endif

                    </section>

                </aside>
            </div>

        </div>
    </div>
</section>

@include('site.layout.footer')

@include('site.blog.common.script')
