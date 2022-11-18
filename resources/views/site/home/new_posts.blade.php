<section class="blog-area ptb-100">
    <div class="container">
        <div class="section-title">
            <h2>وبلاگ</h2>
        </div>

        <div class="row">

            @if (count($new_posts))

                @foreach($new_posts as $value)

                    <div class="col-lg-4 col-md-6">
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

        </div>
    </div>
</section>

