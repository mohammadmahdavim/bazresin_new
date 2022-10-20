@extends('layouts.AdminLayouts')

@section('script')

@stop

@section('css')

@stop


@section('content')

    <!-- Bordered striped table -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">مدیریت مجوزها</h5>
            <div class="heading-elements">
                <a href="{{ url('admin/roles/create') }}" class="btn bg-blue btn-xs btn-icon">ایجاد نقش<i class="icon-plus2"></i></a>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام نقش</th>
                    <th>عنوان نقش</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $key=>$role)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$role->name}}</td>
                        <td>{{$role->label}}</td>
                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600"><a href="{{url('/admin/roles/'.$role->id.'/edit')}}"><i class="icon-pencil7"></i></a></li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /bordered striped table -->


    {{ $roles->links() }}
@endsection
