@extends('layouts.UserLayouts')

@section('script')

    <script type="text/javascript"
            src="<?= url('assets/js/plugins/forms/selects/bootstrap_select.min.js'); ?>"></script>

    <script type="text/javascript" src="<?= url('assets/js/pages/form_bootstrap_select.js'); ?>"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/inputs/touchspin.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/form_input_groups.js')}}"></script>



    <script>
        save_poshtiban = function () {
            Swal.fire({
                title: 'صبر کنید ...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });
            var data = $("#form_poshtiban").serializeArray();
            $.ajax({
                url: '{{ url('/user/azmoon/poshtiban/create') }}',
                type: 'POST',
                data: data,

                success: function (data) {
                    if (!data.errors) {
                        swal.close();
                        $("#alert_show").hide();
                        Swal.fire({
                            type: 'success',
                            title: 'با موفقیت ایجاد گردید گردید',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        window.location.replace("{{url('/user/azmoon/edit/'.$azmoon->id)}}/" + data.messages.row_id);
                    } else {
                        $("#alert_show").html('');
                        jQuery.each(data.errors, function (key, value) {
                            jQuery('.alert-danger').show();
                            jQuery('.alert-danger').append('<p>' + value + '</p>');
                        });
                        swal.close();
                    }

                },
            });
        };
    </script>
@stop

@section('content')

    <!-- Colored table options -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">لیست پشتیبان های حوزه</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <input type="text" id="myInput" class="form-control" onkeyup="searchTable()"
                           placeholder="نام را بنویسید...">
                </ul>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover bg-active-700" id='myTable'>
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>مدیر</th>
                    <th>نام پشتیبان</th>
                    <th>نمره</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($records as $key=>$record)
                    <tr
                        @if($record->status == 1)
                        class="success" style="color: green"
                        @elseif($record->status == 2)
                        class="warning"
                        @elseif($record->status == 3 || $record->status == 4)
                        class="danger"
                        @endif
                    >
                        <td>{{$key+1}}</td>
                        <td>{{App\lib\EnConverter::ar2fa($record->modir)}}</td>
                        <td>{{App\lib\EnConverter::ar2fa($record->poshtiban)}}</td>
                        <td>{{\App\Mark::mark($record->poshtiban_code,$azmoon->id)}}</td>
                        <td>
                            @if($record->status == 1)
                                <span class="btn btn-success">موفق</span>
                            @elseif($record->status == 2)
                                <span class="btn btn-warning">بازدید مجدد</span>
                            @elseif($record->status == 3)
                                <span class="btn btn-danger">غایب</span>
                            @elseif($record->status == 4)
                                <span class="btn btn-danger">انصراف</span>
                            @else
                                <span class="btn btn-info">در انتظار</span>
                            @endif
                        </td>
                        <td><a class="btn btn-primary" href="{{url('/user/leader/poshtiban/'.$azmoon->id.'/'.$record->id)}}"><i
                                    class="icon-pencil"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /colored table options -->
    <!-- Button options -->
    <div class="row">


        <div class="panel panel-body border-top-primary text-center">
            <div class="btn-group btn-group-justified">
                <div class="btn-group col-md-6">
                    <a href="{{url('/user/azmoon/modir/'.$azmoon->id)}}" class="btn btn-success bg-slate-700"
                       id="btnSubmit">ثبت فرم IAR مدیران</a>
                </div>

                <div class="btn-group col-md-6">
                    <button type="button" data-toggle="modal" data-target="#modal_default"
                            class="btn bg-pink-400 btn-raised">
                        ایجاد پشتیبان
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /button options -->







    <!-- Basic modal -->
    <div id="modal_default" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">ایجاد پشتیبان جدید</h5>
                </div>
                <div class="alert alert-danger" style="display:none" id="alert_show"></div>
                <form id="form_poshtiban">
                    @csrf
                    <input type="hidden" name="exam_id" value="{{$azmoon->id}}">
                    <div class="modal-body">
                        <!-- Default select -->
                        <div class="form-group">
                            <label>مدیر این پشتیبان</label>
                            <select name="modir_poshtiban_code" class="bootstrap-select" data-style="btn-success"
                                    data-width="100%">
                                <option value="">انتخاب کنید</option>
                                @foreach($modir_codes as $key=>$modir)
                                    <option value="{{$key}}">{{$modir}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- /default select -->

                        <div class="form-group">
                            <label>نام پشتیبان</label>
                            <input type="text" name="poshtiban" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>کد ملی پشتیبان</label>
                            <input type="text" name="poshtiban_code" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>تعداد کل دانش آموزان تحت پوشش</label>
                            <input type="number" name="total_student" class="touchspin-empty">
                        </div>

                        <div class="text-right">
                            <a class="btn btn-success" onclick="save_poshtiban()"> ایجاد <i
                                    class="icon-plus-circle2 position-right"></i></a>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- /basic modal -->





    <script>
        function searchTable() {
            var input, filter, found, table, tr, td, i, j;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                    }
                }
                if (found) {
                    tr[i].style.display = "";
                    found = false;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>
@stop
