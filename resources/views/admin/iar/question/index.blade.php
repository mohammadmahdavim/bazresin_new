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
                        url: '{{ url('admin/iar/question') }}/' + id,
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
                url: '{{ url('admin/iar/question') }}/' + id + '/edit',
                type: 'GET',

                success: function (data) {
                    $("#loading_box").hide();
                    $("#content-update").html(data);
                }
            });

        });

    </script>
@endsection


@section('content')
    <!-- Dashed border styling -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">مدیریت سوال های فرم IAR</h5>
            <div class="heading-elements">
                <a href="{{ url('admin/iar/question/create') }}" class="btn bg-blue btn-xs btn-icon"> افزودن سوال <i
                        class="icon-plus2"></i></a>
            </div>
        </div>

        <div class="panel-body">
            سوالاتی که به بازرس ها در فرم ارزشیابی عملکرد آزمون نشان داده خواهد شد در این قسمت قرار دارد. هر سوالی که
            وضعیت آن فعال باشد به بازرس ها نشان داده خواهد شد.
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>عنوان سوال</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($questions as $key=>$question)
                    <tr class="border-dashed">
                        <td>{{$key+1}}</td>
                        <td>{{$question->question}}</td>
                        <td>
                            @if($question->status == 1)
                                <button type="button" class="btn bg-success">فعال</button>
                            @else
                                <button type="button" class="btn bg-pink">غیرفعال</button>
                            @endif
                        </td>
                        <td>
                            <ul class="icons-list">
                                <li class="text-primary-600"><a class='update' data-id='<?= $question->id ?>'><i
                                            class="icon-pencil7"></i></a></li>
                                <li class="text-danger-600"><a class='delete' data-id='<?= $question->id ?>'><i
                                            class="icon-trash"></i></a></li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /dashed border styling -->


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
