@section('admin_title')
    <title>پنل مدیریت درمانگاه شبانه روزی امام حسین (ع) | کاربران لیست سیاه</title>
@endsection

@section('admin_css')
    <link type="text/css" rel="stylesheet"
          href="{{asset('assets/common/plugins/persianDatepicker/css/persianDatepicker-default.css')}}">
@endsection

@include('admin.layout.header')

@include('admin.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('blacklists.index')}}">مدیریت کاربران لیست سیاه</a>
                        </li>
                        <li class="breadcrumb-item"><a class="my-active"
                                                       href="{{route('blacklists.edit',$block_user->id)}}">ویرایش
                                کاربر لیست سیاه ({{$block_user->user->fullName}})</a></li>
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
                            <h3 class="card-title">ویرایش کاربر لیست سیاه ({{$block_user->user->fullName}})</h3>
                        </div>

                        <form id="update_blacklist_form" action="{{route('blacklists.update',$block_user->id)}}"
                              method="post">

                            @csrf
                            @method('patch')

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="user_id">کاربر لیست سیاه *</label>
                                    <select class="form-control  @error('user_id') is-invalid @enderror"
                                            id="user_id"
                                            name="user_id">
                                        <option selected disabled value="">لطفا کاربر لیست سیاه را انتخاب کنید</option>

                                        @if (count($users))

                                            @foreach($users as $value)

                                                <option @if ($value->id==old('user_id',$block_user['user_id']))
                                                        selected="selected"
                                                        @endif
                                                        value="{{$value->id}}">{{$value->fullName}}</option>

                                            @endforeach

                                        @endif

                                    </select>

                                    @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="date">تاریخ پایان بلاک کاربر</label>
                                    <input readonly onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('date') is-invalid @enderror"
                                           @if ($block_user->date!=null)
                                           value="{{ old('date',\Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($block_user['date']))) }}"
                                           @else
                                           value="{{ old('date') }}"
                                           @endif
                                           id="date"
                                           name="date"
                                           placeholder="در صورت تمایل تاریخ پایان بلاک کاربر را وارد کنید"
                                           autocomplete="date" autofocus>

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="text">توضیحات بلاک کاربر</label>
                                    <textarea onkeyup="this.value=removeSpaces(this.value)" placeholder="در صورت تمایل توضیحات بلاک کاربر را وارد کنید" rows="5"
                                              style="resize: vertical"
                                              class="form-control @error('text') is-invalid @enderror"
                                              id="text"
                                              name="text" autocomplete="text"
                                              autofocus>{{ old('text',$block_user->text) }}</textarea>

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
    <script type="text/javascript"
            src="{{asset('assets/common/plugins/persianDatepicker/js/persianDatepicker.min.js')}}"></script>
@endsection

@include('admin.layout.footer')

<script type="text/javascript">

    $(document).ready(function () {

        $("#date").persianDatepicker({formatDate: "YYYY/0M/0D"});

        $('#update_blacklist_form').validate({

            rules: {
                user_id: {
                    required: true
                }
            },

            messages: {
                user_id: {
                    required: "لطفا کاربر لیست سیاه را انتخاب کنید"
                }
            }

        });

    });

</script>
