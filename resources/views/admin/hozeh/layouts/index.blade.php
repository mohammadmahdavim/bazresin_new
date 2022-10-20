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
@stop

@section('css')

@stop

@section('content')





    <!-- Scrollable datatable -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">چیدمان حوزه آزمون ها</h5>
        </div>

        <table class="table datatable-scroll-y" width="100%">
            <thead>
            <tr>
                <th>نام آزمون</th>
                <th>تاریخ آزمون</th>
                <th>وضعیت</th>
                <th class="text-center">عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($exams as $key=>$exam)
                <tr>
                    <td>{{$exam->name}}</td>
                    <td>{{$exam->date}}</td>
                    <td>
                        @if($exam->status == 1)
                            فعال
                        @else
                            غیرفعال
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="/admin/hozeh/layouts/{{$exam->id}}/edit" class="btn btn-info btn-icon"><i
                                class="icon-pencil6"></i></a>
                        <a href="#" class="btn btn-danger btn-icon"><i class="icon-cancel-circle2"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /scrollable datatable -->


@stop
