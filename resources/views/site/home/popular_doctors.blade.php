<div class="container-fluid margin-bottom-5">
    <h3 class="slick-title text-center"> پزشکان محبوب</h3>
    <div class="container restrict dis-section" id="slick-items">

        @if (count($popular_doctors))

            @foreach($popular_doctors as $value)

                <a style="text-decoration: none" class="slick-item ImportantDoctor" href="{{$value->path()}}">

                    <img class="slick-item-logo" src="{{$value->profile}}"
                         alt="{{$value->fullName}}"
                         draggable="false">
                    <h4 class="slick-item-name">دکتر {{$value->fullName}}</h4>
                    <h5 class="slick-item-expert"> متخصص {{$value->doctor->expertise->name}} </h5>

                </a>

            @endforeach

        @endif

    </div>
</div>

<div class="clear"></div>
