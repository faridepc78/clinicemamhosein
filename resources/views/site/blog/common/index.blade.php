<section class="widget widget_search">
    <form id="search_post_form" class="search-form" method="get" action="{{route('blog.search')}}">

        <label>
            <span class="screen-reader-text">جستجو:</span>
            <input value="{{request()->input('search')}}" onkeyup="this.value=removeSpaces(this.value)" id="search" name="search" type="search"
                   class="search-field" placeholder="جستجو...">
        </label>

        <button type="submit"><i class="fa fa-search"></i></button>

    </form>

</section>

<section class="widget widget_categories">
    <h3 class="widget-title">دسته بندی ها</h3>
    <ul>

        @if (count($categories))

            @foreach($categories as $value)

                <li><a href="{{$value->path()}}">{{$value->name}}</a></li>

            @endforeach

        @endif

    </ul>
</section>
