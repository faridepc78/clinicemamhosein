<div id="gallery_div" class="tab-pane background-color-white">

    <div class="row">
        <div class="col-md-12">

            <div id="gallery">

                @if (count($doctor->gallery))

                    @foreach($doctor->gallery as $value)

                        <a class="cover" href="{{$value->image->original}}">
                            <img width="110" height="110"
                                src="{{$value->image->original}}"/>
                        </a>

                    @endforeach

                @endif

            </div>

            <div class="clearfix"></div>

        </div>
    </div>

</div>
