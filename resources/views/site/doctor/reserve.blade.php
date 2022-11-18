<div id="reserve_div" class="tab-pane background-color-white">

    <div class="row">

            @if (count($times))

                @foreach($times as $time)

                <form id="reserve_form" method="post" action="{{route('reserve')}}">
                    @csrf
                    <div class="owl-item active center" style="width: auto;">
                        <div class="item dayItem dayFreamTurn">
                            <strong
                                class="tit">{{\Morilog\Jalali\CalendarUtils::strftime('j F Y', $time->date)}}</strong>
                            <span class="yekan">{{$time->start_time}} الی {{$time->end_time}} ( {{$time->capacity}} نفر )</span>
                            <br>
                            <input type="hidden" name="time_id"
                                   value="{{\Vinkla\Hashids\Facades\Hashids::encode($time['id'])}}">
                            <button style="margin-right: 35px!important;width: 100px" class="schedule-week-button">رزرو</button>
                        </div>
                    </div>
                </form>

                @endforeach

            @endif

        <div class="clearfix"></div>

    </div>

</div>
