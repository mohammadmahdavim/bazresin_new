@extends('layouts.AdminLayouts')

@section('script')
    <script type="text/javascript" src="{{url('/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/datatables_basic.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/ui/ripple.min.js')}}"></script>
@stop

@section('content')
    <!-- Style combinations -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">کاربران سامانه</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">مدیریت کاربران سامانه بازرسان حوزه قلم چی</div>

        <table class="table datatable-basic table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>عنوان کاربری</th>
                <th>موبایل</th>
                <th>تایید موبایل</th>
                <th class="text-center">عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->first_name}}</td>
                    <td>{{$user->last_name}}</td>



                    @if($user->role == 'admin')
                        <td>مدیر</td>
                    @elseif($user->role == 'user')
                        <td>کاربر</td>
                    @elseif($user->role == 'bazres')
                        <td>بازرس</td>
                    @else
                        <td><span class="label label-danger">تایید نشده</span></td>
                    @endif


                    <td>{{$user->mobile}}</td>


                    @if ($user->verification == 'yes')
                        <td><span class="label label-success">فعال</span></td>
                    @else
                        <td><span class="label label-warning">احراز نشده</span></td>
                    @endif


                    <td class="text-center">
                        <div class="media-right media-middle">
                            <ul class="icons-list icons-list-extended text-nowrap">
                                <li><a href="{{url('/admin/users/'.$user->id.'/edit')}}" data-popup="tooltip" title="ویرایش"><i class="icon-database-edit2"></i></a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /style combinations -->
@stop
