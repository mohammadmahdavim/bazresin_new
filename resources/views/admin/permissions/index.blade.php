@extends('layouts.AdminLayouts')

@section('script')
    <script>
        $(document).on("click", ".delete", function () {
            var id = $(this).data('id');
            var el = this;

            Swal.fire({
                title: 'از حذف مطمئن هستید؟',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00a018',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.value) {
                    var token = $("meta[name='csrf-token']").attr("content");
                    $.ajax({
                        url: '{{ url('admin/permissions') }}/' + id,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                        },

                        success: function (data) {
                            if (data == 'ok') {
                                Swal.fire(
                                    'موفق',
                                    'حذف گردید',
                                    'success'
                                );
                                $(el).closest("tr").remove();
                            } else {
                                Swal.fire(
                                    'خطا',
                                    'مشکلی رخ داد',
                                    'danger'
                                )
                            }
                        }
                    });
                }
            });
        });

    </script>
    <script>
        $(document).on("click", ".update", function () {
            var id = $(this).data('id');
            var el = this;
            $("#modal_default").modal('show');
            $("#content-update").html("");
            $("#loading_box").show();

            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: '{{ url('admin/permissions') }}/' + id + '/edit',
                type: 'GET',

                success: function (data) {
                    $("#loading_box").hide();
                    $("#content-update").html(data);
                }
            });

        });

    </script>
@stop

@section('css')

@stop
@section('content')

    <!-- Bordered striped table -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">مدیریت مجوزها</h5>
            <div class="heading-elements">
                <a href="{{ url('admin/permissions/create') }}" class="btn bg-blue btn-xs btn-icon">ایجاد مجوز<i
                        class="icon-plus2"></i></a>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="permissions">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام دسترسی</th>
                    <th>عنوان دسترسی</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $key=>$permission)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$permission->name}}</td>
                        <td>{{$permission->label}}</td>
                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600"><a class='update' data-id='<?= $permission->id ?>'><i class="icon-pencil7"></i></a></li>
                                <li class="text-danger-600"><a class='delete' data-id='<?= $permission->id ?>'><i
                                            class="icon-trash"></i></a></li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /bordered striped table -->

    {{ $permissions->links() }}


    <!-- Basic modal -->
    <div id="modal_default" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">بروزرسانی</h5>
                </div>


                <div class="modal-body">
                    <div id="loading_box" align="center" style="display: none;">
                        <i class="icon-spinner9 spinner position-left"></i>
                        <span>در حال دریافت اطلاعات</span>
                    </div>
                    <div id="content-update">

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /basic modal -->
@endsection

