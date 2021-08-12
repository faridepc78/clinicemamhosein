@if(session()->has('feedbacks'))
    @foreach(session()->get('feedbacks') as $message)
        toastr.{{$message['type']}}("{{$message['body']}}","{{$message['title']}}")
    @endforeach
@endif
