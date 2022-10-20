@extends('layouts.AdminLayouts')


@section('script')
    <script type="text/javascript" src="{{url('assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {

            // Table setup
            // ------------------------------
            // Setting datatable defaults
            $.extend($.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    width: '100px',
                    targets: [4]
                }],
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '<span>جست و جو:</span> _INPUT_',
                    searchPlaceholder: 'چیزی تایپ کنید...',
                    lengthMenu: '<span>نمایش:</span> _MENU_',
                    paginate: {'first': 'First', 'last': 'Last', 'next': '&larr;', 'previous': '&rarr;'}
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });


            // Basic datatable
            $('.datatable-basic').DataTable();


            // Alternative pagination
            $('.datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': 'Next &larr;', 'previous': '&rarr; Prev'}
                }
            });


            // Datatable with saving state
            $('.datatable-save-state').DataTable({
                stateSave: true
            });


            // Scrollable datatable
            $('.datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });


            // External table additions
            // ------------------------------

            // Enable Select2 select for the length option
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });

        });
    </script>
@endsection

@section('content')

    <!-- Scrollable datatable -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"> لیست مدیران</h5>
            <div class="heading-elements">
                <button type="button" class="btn btn-primary btn-icon" data-toggle="modal" data-target="#modal_default">
                    <i class="icon-file-excel"></i> آپلود لیست مدیران
                </button>
            </div>
        </div>

        <table class="table datatable-scroll-y" width="100%">
            <thead>
            <tr>
                <th>نام</th>
                <th>موبایل</th>
                <th>کد پرسنلی</th>
                <th>آخرین ویرایش</th>
                <th class="text-center">عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($modirs as $modir)
                <tr>
                    <td>{{$modir->name}}</td>
                    <td>{{$modir->mobile}}</td>
                    <td>{{$modir->codemeli}}</td>
                    <td>{{\Morilog\Jalali\jDate::forge($modir->updated_at)->format('datetime')}}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-icon"><i class="icon-pencil6"></i></button>
                        <button type="button" class="btn btn-danger btn-icon"><i class="icon-cancel-circle2"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /scrollable datatable -->

    <!-- Basic modal -->
    <div id="modal_default" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">بروزرسانی مدیران از طریق آپلود اکسل</h5>
                </div>


                <div class="modal-body">
                    <div class="form-group">
                        <label class="text-semibold">توضیحات:</label>
                        <div class="form-control-static">
                            <p>توجه داشته باشید که فایل اکسل باید به فرمتی خاص تهیه شده باشد و برای دریافت فرمت اکسل از
                                قسمت پایین بر روی دکمه تمپلیت راهنما کلیک نمایید!</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{url('/assets/templates/modir.xlsx')}}" class="btn btn-success">دریافت تمپلیت راهنما</a>
                    <a href="/admin/modir/upload" class="btn btn-primary">آپلود</a>
                </div>

            </div>
        </div>
    </div>
    <!-- /basic modal -->


@endsection
