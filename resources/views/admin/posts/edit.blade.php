@section('admin_title')
    <title>پنل مدیریت درمانگاه شبانه روزی امام حسین (ع) | پست ها</title>
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
                                                       href="{{route('posts.edit',$post->id)}}">ویرایش
                                پست ({{$post->name}})</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-success">

                        <div class="card-header">
                            <h3 class="card-title">ویرایش پست ({{$post->name}})</h3>
                        </div>

                        <form id="update_post_form" action="{{route('posts.update',$post->id)}}"
                              method="post" enctype="multipart/form-data">

                            @csrf
                            @method('patch')

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="name">نام پست *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name',$post->name) }}" id="name" name="name"
                                           placeholder="لطفا نام پست را وارد کنید"
                                           autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="slug">اسلاگ پست *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('slug') is-invalid @enderror"
                                           value="{{ old('slug',$post->slug) }}" id="slug" name="slug"
                                           placeholder="لطفا اسلاگ پست را وارد کنید"
                                           autocomplete="slug" autofocus>

                                    @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="category_id">دسته بندی پست *</label>
                                    <select class="form-control  @error('category_id') is-invalid @enderror"
                                            id="category_id"
                                            name="category_id">
                                        <option selected disabled value="">لطفا دسته بندی پست را انتخاب کنید</option>

                                        @if (count($categories))

                                            @foreach($categories as $value)

                                                <option @if ($value->id==old('category_id',$post->category_id))
                                                        selected="selected"
                                                        @endif
                                                        value="{{$value->id}}">{{$value->name}}</option>

                                            @endforeach

                                        @endif

                                    </select>

                                    @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image">تصویر پست</label>

                                    <img class="img-bordered" style="width: 150px;height: 150px" src="{{$post->image->original}}"
                                         alt="{{$post->image->original}}">

                                    <input accept=".jpg,.jpeg,.png" type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           autofocus id="image" name="image">

                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">وضعیت پست *</label>
                                    <select class="form-control  @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status">
                                        <option selected disabled value="">لطفا وضعیت پست را انتخاب کنید</option>

                                        @foreach(\App\Models\Post::$statuses as $value)
                                            <option
                                                @if ($value==old('status',$post->status))
                                                selected="selected"
                                                @endif
                                                value="{{$value}}">@lang($value)</option>
                                        @endforeach

                                    </select>

                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="text">توضیحات پست *</label>
                                    <textarea class="form-control ckeditor @error('text') is-invalid @enderror"
                                              id="text"
                                              name="text" autocomplete="text"
                                              autofocus>{{ old('text',$post->text) }}</textarea>

                                    @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">بروزرسانی</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

@section('admin_js')
    <script type="text/javascript" src="{{asset('assets/common/plugins/ckeditor/ckeditor.js')}}"></script>
@endsection

@include('admin.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        $('#update_post_form').validate({

            rules: {
                name: {
                    required: true
                },

                slug: {
                    required: true
                },

                category_id: {
                    required: true
                },

                status: {
                    required: true
                }
            },

            messages: {
                name: {
                    required: "لطفا نام پست را وارد کنید"
                },

                slug: {
                    required: "لطفا اسلاگ پست را وارد کنید"
                },

                category_id: {
                    required: "لطفا دسته بندی پست را انتخاب کنید"
                },

                status: {
                    required: "لطفا وضعیت پست را انتخاب کنید"
                }
            },
            submitHandler: function (form) {
                if (validateCkeditor(text_field, text_error) === true) {
                    form.submit();
                }
            }

        });

    });

</script>
