@section('admin_title')
    <title>پنل مدیریت درمانگاه شبانه روزی امام حسین (ع) | مدیریت مدیا پست ({{$post->name}})</title>
@endsection

@include('admin.layout.header')

@include('admin.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('posts.index')}}">مدیریت پست ها</a></li>
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('post_media_index',$post->id)}}">مدیریت
                                مدیا پست ({{$post->name}})</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">مدیریت مدیا پست ({{$post->name}})</h3>
                        </div>

                        <form id="management_post_media_form"
                              action="{{route('post_media_store',$post['id'])}}"
                              method="post"
                              enctype="multipart/form-data">

                            @csrf

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="media">مدیا پست *</label>
                                    <input accept=".jpg,.jpeg,.png" type="file"
                                           class="form-control @error('media') is-invalid @enderror"
                                           autofocus id="media" name="media">

                                    @error('media')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">ثبت</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-3">مدیریت مدیا پست ({{$post->name}})</h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered text-center">

                                <tr>
                                    <th>ردیف</th>
                                    <th>مدیا</th>
                                    <th>حذف</th>
                                </tr>

                                @if(count($media))

                                    @foreach($media as $key=>$value)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td><img class="img-bordered" style="width: 150px;height: 150px"
                                                     src="{{$value->media->original}}"
                                                     alt="{{$value->media->original}}"></td>
                                            <td>
                                                <a href="{{ route('post_media_destroy', [$post['id'],$value->id]) }}"
                                                   onclick="destroyPostMedia(event,{{ $post['id'] }}, {{ $value->id }})"><i
                                                        class="fa fa-remove text-danger"></i></a>
                                                <form
                                                    action="{{ route('post_media_destroy', [$post['id'],$value->id]) }}"
                                                    method="post"
                                                    id="destroy-PostMedia-{{ $post['id'] }}-{{ $value->id }}">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </td>
                                        </tr>

                                    @endforeach

                                @else

                                    <div class="alert alert-danger text-center">
                                        <p>اطلاعات این بخش ثبت نشده است</p>
                                    </div>

                                @endif

                            </table>

                        </div>

                        <div class="pagination mt-3">
                            {!! $media->links() !!}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

@include('admin.layout.footer')

<script type="text/javascript">

    function destroyPostMedia(event,post_id, id) {
        event.preventDefault();
        Swal.fire({
            title: 'آیا از حذف اطمینان دارید ؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'rgb(221, 51, 51)',
            cancelButtonColor: 'rgb(48, 133, 214)',
            confirmButtonText: 'بله',
            cancelButtonText: 'خیر'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`destroy-PostMedia-${post_id}-${id}`).submit()
            }
        })
    }

    $(document).ready(function () {

        $('#management_post_media_form').validate({

            rules: {
                media: {
                    required: true
                }
            },

            messages: {
                media: {
                    required: "لطفا مدیا پست را انتخاب کنید"
                }
            }

        });

    });

</script>
