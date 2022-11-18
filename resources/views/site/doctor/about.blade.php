<div id="about_div" class="tab-pane active">

    <div class="margin-top-20">
        <div class="col-md-9 col-sm-9">

            <h3>دکتر {{$doctor->fullName}}</h3>

            <p
                class="small-s-font doc-advanced"><span
                    class="small-n-font">متخصص: </span><span>{{$doctor->doctor->expertise->name}}</span></p>

            <p class="small-s-font doctor-profeciency"><span
                    class="small-n-font">حوزه تخصصی: </span>{{$doctor->doctor->specialized_fields}}</p>

            @if ($doctor->doctor->specialty!=null)
                <p class="small-s-font doc-super-advanced">
                                        <span
                                            class="small-n-font">فوق تخصص: </span>{{$doctor->doctor->specialty}}
                </p>
            @endif

            @if ($doctor->doctor->science_bar!=null)
                <p class="small-s-font doctor-uni">
                                        <span
                                            class="small-n-font">مرتبه علمی: </span>{{$doctor->doctor->science_bar}}
                </p>
            @endif

            @if ($doctor->doctor->fluent_languages!=null)
                <p class="small-s-font doctor-uni"><span
                        class="small-n-font">زبان های مسلط: </span><span>{{$doctor->doctor->fluent_languages}}</span>
                </p>
            @endif

            @if ($doctor->doctor->place_of_degrees_of_degrees!=null)
                <p class="small-s-font doctor-uni"><span
                        class="small-n-font">محل اخذ مدرک تحصیلی: </span>{{$doctor->doctor->place_of_degrees_of_degrees}}
                </p>
            @endif

            @if ($doctor->doctor->description!=null)
                <p class="small-s-font doctor-uni font-red">
                                        <span
                                            class="small-n-font">توضیحات : </span>{!! $doctor->doctor->description !!}
                </p>
            @endif

        </div>

        <div class="visible-xs col-xs-4"></div>

        <div class="col-md-3 col-sm-3 col-xs-6 text-center">
            <div class="hospital-intro-pic center-block" style="background-image: url('{{$doctor->profile}}')">
            </div>
        </div>

    </div>

</div>
