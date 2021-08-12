@section('admin_title')
    <title>پنل مدیریت درمانگاه شبانه روزی امام حسین (ع) | مدیریت گالری دکتر ({{$doctor->fullName}})</title>
@endsection

@include('admin.layout.header')

@include('admin.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('management_doctor',$doctor['id'])}}">مدیریت دکتر
                                ({{$doctor->fullName}})</a></li>
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('management_doctor_gallery',$doctor->id)}}">مدیریت
                                گالری دکتر ({{$doctor->fullName}})</a></li>
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
                            <h3 class="card-title">مدیریت گالری دکتر ({{$doctor->fullName}})</h3>
                        </div>

                        <form id="management_doctor_gallery_form"
                              action="{{route('management_doctor_gallery_do',$doctor['id'])}}"
                              method="post"
                              enctype="multipart/form-data">

                            @csrf

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="image">تصویر گالری دکتر *</label>
                                    <input accept=".jpg,.jpeg,.png,.jfif" type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           autofocus id="image" name="image">

                                    @error('image')
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
                            <h3 class="card-title mb-3">مدیریت گالری دکتر ({{$doctor->fullName}})</h3>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered text-center">

                                <tr>
                                    <th>ردیف</th>
                                    <th>تصویر</th>
                                    <th>حذف</th>
                                </tr>

                                @if(count($data))

                                    @foreach($data as $key=>$value)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td><img class="img-bordered" style="width: 110px;height: 110px"
                                                     src="{{$value->image->original}}"
                                                     alt="{{$value->image->original}}"></td>
                                            <td>
                                                <a href="{{ route('management_doctor_gallery_destroy', [$doctor['id'],$value->id]) }}"
                                                   onclick="destroyDoctorGallery(event,{{ $doctor['id'] }}, {{ $value->id }})"><i
                                                        class="fa fa-remove text-danger"></i></a>
                                                <form
                                                    action="{{ route('management_doctor_gallery_destroy', [$doctor['id'],$value->id]) }}"
                                                    method="post"
                                                    id="destroy-DoctorGallery-{{ $doctor['id'] }}-{{ $value->id }}">
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
                            {!! $data->links() !!}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

@include('admin.layout.footer')

<script type="text/javascript">

    function destroyDoctorGallery(event,doctor_id, id) {
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
                document.getElementById(`destroy-DoctorGallery-${doctor_id}-${id}`).submit()
            }
        })
    }

    $(document).ready(function () {

        $('#management_doctor_gallery_form').validate({

            rules: {
                image: {
                    required: true
                }
            },

            messages: {
                image: {
                    required: "لطفا تصویر گالری دکتر را انتخاب کنید"
                }
            }

        });

    });

</script>
