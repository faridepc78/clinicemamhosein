@section('admin_title')
    <title>پنل مدیریت درمانگاه شبانه روزی امام حسین (ع) | مدیریت درباره دکتر ({{$doctor->fullName}})</title>
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
                                                       href="{{route('management_doctor_about',$doctor->id)}}">مدیریت
                                درباره ({{$doctor->fullName}})</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="card @if ($info['status']=='store')
                        card-primary
                    @else card-success @endif">

                        <div class="card-header">
                            <h3 class="card-title">مدیریت درباره دکتر ({{$doctor->fullName}})</h3>
                        </div>

                        <form id="createOrUpdate_doctor_about_form"
                              @if ($info['status']=='store')
                              action="{{route('management_doctor_about_post',$doctor['id'])}}"
                              @else
                              action="{{route('management_doctor_about_update',[$doctor['id'],$info['id']])}}"
                              @endif
                              method="post">

                            @csrf

                            @if($info['status']!='store')
                                @method('patch')
                            @endif

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="clerk_id">منشی دکتر *</label>
                                    <select class="form-control  @error('clerk_id') is-invalid @enderror"
                                            id="clerk_id"
                                            name="clerk_id">
                                        <option selected disabled value="">لطفا منشی دکتر را انتخاب کنید</option>

                                        @if (count($clerks))

                                            @foreach($clerks as $clerk)

                                                <option @if ($clerk->id==old('clerk_id',$info['clerk_id']))
                                                        selected="selected"
                                                        @endif
                                                        value="{{$clerk->id}}">{{$clerk->f_name.' '.$clerk->l_name}}</option>

                                            @endforeach

                                        @endif

                                    </select>

                                    @error('clerk_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="expertise_id">تخصص دکتر *</label>
                                    <select class="form-control  @error('expertise_id') is-invalid @enderror"
                                            id="expertise_id"
                                            name="expertise_id">
                                        <option selected disabled value="">لطفا تخصص دکتر را انتخاب کنید</option>

                                        @if (count($expertises))

                                            @foreach($expertises as $expertise)

                                                <option @if ($expertise->id==old('expertise_id',$info['expertise_id']))
                                                        selected="selected"
                                                        @endif
                                                        value="{{$expertise->id}}">{{$expertise->name}}</option>

                                            @endforeach

                                        @endif

                                    </select>

                                    @error('expertise_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="experience">سال تجربه دکتر *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('experience') is-invalid @enderror"
                                           value="{{ old('experience',$info['experience']) }}" id="experience"
                                           name="experience"
                                           placeholder="لطفا سال تجربه دکتر را وارد کنید"
                                           autocomplete="experience" autofocus>

                                    @error('experience')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="specialized_fields">حوزه تخصصی دکتر *</label>
                                    <textarea rows="5" style="resize: vertical" onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('specialized_fields') is-invalid @enderror"
                                           id="specialized_fields"
                                           name="specialized_fields"
                                           placeholder="لطفا حوزه تخصصی دکتر را وارد کنید"
                                              autocomplete="specialized_fields" autofocus>{{ old('specialized_fields',$info['specialized_fields']) }}</textarea>

                                    @error('specialized_fields')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="specialty">فوق تخصص دکتر</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('specialty') is-invalid @enderror"
                                           value="{{ old('specialty',$info['specialty']) }}" id="specialty"
                                           name="specialty"
                                           placeholder="فوق تخصص دکتر را وارد کنید"
                                           autocomplete="specialty" autofocus>

                                    @error('specialty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="science_bar">مرتبه علمی دکتر</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('science_bar') is-invalid @enderror"
                                           value="{{ old('science_bar',$info['science_bar']) }}" id="science_bar"
                                           name="science_bar"
                                           placeholder="مرتبه علمی دکتر را وارد کنید"
                                           autocomplete="science_bar" autofocus>

                                    @error('science_bar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="fluent_languages">زبان های مسلط دکتر</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('fluent_languages') is-invalid @enderror"
                                           value="{{ old('fluent_languages',$info['fluent_languages']) }}"
                                           id="fluent_languages"
                                           name="fluent_languages"
                                           placeholder="زبان های مسلط دکتر را وارد کنید"
                                           autocomplete="fluent_languages" autofocus>

                                    @error('fluent_languages')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="place_of_degrees_of_degrees">محل اخذ مدرک تحصیلی دکتر</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('place_of_degrees_of_degrees') is-invalid @enderror"
                                           value="{{ old('place_of_degrees_of_degrees',$info['place_of_degrees_of_degrees']) }}"
                                           id="place_of_degrees_of_degrees"
                                           name="place_of_degrees_of_degrees"
                                           placeholder="محل اخذ مدرک تحصیلی دکتر را وارد کنید"
                                           autocomplete="place_of_degrees_of_degrees" autofocus>

                                    @error('place_of_degrees_of_degrees')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone">تلفن دکتر</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone',$info['phone']) }}" id="phone" name="phone"
                                           placeholder="تلفن دکتر را وارد کنید"
                                           autocomplete="phone" autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">توضیحات دکتر</label>
                                    <textarea class="form-control ckeditor @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description" autocomplete="description"
                                              autofocus>{{ old('description',$info['description']) }}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                @if ($info['status']=='store')
                                    <button type="submit" class="btn btn-primary">ثبت</button>
                                @else
                                    <button type="submit" class="btn btn-success">بروزرسانی</button>
                                @endif
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

        $('#createOrUpdate_doctor_about_form').validate({

            rules: {
                clerk_id: {
                    required: true
                },

                expertise_id: {
                    required: true
                },

                experience: {
                    required: true,
                    number: true
                },

                specialized_fields: {
                    required: true
                }
            },

            messages: {
                clerk_id: {
                    required: "لطفا منشی دکتر را انتخاب کنید"
                },

                expertise_id: {
                    required: "لطفا تخصص دکتر را انتخاب کنید"
                },

                experience: {
                    required: "لطفا سال تجربه دکتر را وارد کنید",
                    number: "لطفا سال تجربه دکتر را صحیح وارد کنید"
                },

                specialized_fields: {
                    required: "لطفا حوزه تخصصی دکتر را وارد کنید"
                }
            }

        });

    });

</script>
