@section('site_title')
    <title>درمانگاه شبانه روزی امام حسین (ع) | پنل بیمار</title>
@endsection

@include('site.layout.header')

<div class="main">

    <div class="row">
        <div class="col-md-12">

            <div class="card text-center">
                <h4 class="card-header">{{$question->subject}}</h4>
                <div class="card-body">
                    <h5 class="card-title">{{$question->doctor->fullName}}</h5>
                    @if($question->media_id!=null)
                        <img style="width: 250px;height: 250px" src="{{$question->media->original}}"
                             alt="{{$question->media->original}}">
                    @endif
                    <p class="card-text">{!! $question->message !!}</p>
                </div>
            </div>

            <br><br>

            <div class="alert alert-info text-center"><p>جواب پرسش</p></div>

            <div class="card text-center">

                @if ($question->answer==null)
                    <div class="card-body">
                        <p class="card-text alert alert-danger">هنوز جواب داده نشده است</p>
                    </div>
                @else
                    <div class="card-body">
                        <p class="card-text">{!! $question->answer !!}</p>
                    </div>
                @endif

            </div>

        </div>
    </div>

</div>

@include('site.layout.footer')
