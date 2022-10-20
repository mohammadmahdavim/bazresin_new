@extends('layouts.AdminLayouts')

@section('script')
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/form_layouts.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/ui/ripple.min.js')}}"></script>
@stop

@section('content')

    <!-- 2 columns form -->
    <form action="{{url('/admin/users/'.$user->id)}}" method="POST">
        @csrf
        {{ method_field('PATCH') }}

        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">{{$user->first_name.' '.$user->last_name}}</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-semibold"><i class="icon-key position-left"></i>دسترسی ها
                            </legend>

                            <div class="form-group">
                                <select multiple="multiple" disabled="disabled" class="select-icons">
                                    @foreach($user->roles as $role)
                                        @foreach($permissions as  $permission)
                                            <option
                                                @if($role->permissions->contains($permission->id)) selected @endif>{{$permission->label}}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            @if($user->roles->contains(3))
                                <legend class="text-semibold"><i class="icon-location3 position-left"></i>مناطق تحت پوشش
                                </legend>
                                <div class="form-group">
                                    <select multiple="multiple" name="zones_id[]"  class="select-icons">
                                        @foreach($zones as $zone)
                                            <option @if($user->zones->contains($zone->id)) selected @endif value="{{$zone->id}}">{{$zone->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <fieldset>
                            <legend class="text-semibold"><i class="icon-user-check position-left"></i> اطلاعات کاربری
                            </legend>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>نام:</label>
                                        <input type="text" name="first_name" value="{{$user->first_name}}"
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>نام خانوادگی:</label>
                                        <input type="text" name="last_name" value="{{$user->last_name}}"
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>نقش اصلی در سامانه :</label>
                                        <select class="select" name="role">
                                            <option value="admin" @if($user->role == 'admin') selected @endif>مدیرسایت
                                            </option>
                                            <option value="user" @if($user->role == 'user') selected @endif>کاربر عادی
                                            </option>
                                            <option value="bazres" @if($user->role == 'bazres') selected @endif>بازرس
                                            </option>
                                            <option value="unknown" @if($user->role == 'unknown') selected @endif>
                                                غیرفعال
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>موبایل:</label>
                                        <input type="text" name="mobile" value="{{$user->mobile}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>کد ملی:</label>
                                        <input type="text" name="username" value="{{$user->username}}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>نقش های کاربری:</label>
                                        <select multiple="multiple" name="roles_id[]"
                                                data-placeholder="نقشی انتخاب نمایید..." class="select-icons">
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}"
                                                        @if($user->roles->contains($role->id)) selected @endif>{{$role->label}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ایمیل:</label>
                                        <input type="email" name="email" value="{{$user->email}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>جنسیت:</label>
                                        <select class="select" name="sex">
                                            <option value="man" @if($user->sex == 'man') selected @endif>آقا</option>
                                            <option value="woman" @if($user->sex == 'woman') selected @endif>خانم
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">بروزرسانی<i
                            class="icon-arrow-left13 position-right"></i></button>
                </div>
            </div>
        </div>
    </form>
    <!-- /2 columns form -->
@stop
