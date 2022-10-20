@extends('layouts.AdminLayouts')

@section('css')
    <style>
        * {
            box-sizing: border-box;
        }

        #myInput {
            background-image: url('/assets/images/search.png');
            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }

        #myTable {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
            font-size: 18px;
        }

        #myTable th, #myTable td {
            text-align: left;
            padding: 12px;
        }

        #myTable tr {
            border-bottom: 1px solid #ddd;
        }

        #myTable tr.header, #myTable tr:hover {
            background-color: #f1f1f1;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
@endsection

@section('content')


    <!-- Select2 selects -->
    <h6 class="content-group text-semibold">
        انتخاب مدیران حوزه و آزمون
    </h6>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">مدیریت چیدمان</h5>
                    <div class="heading-elements">
                        <button type="button" class="btn btn-primary btn-icon" data-toggle="modal"
                                data-target="#modal_default_save">
                            <i class="icon-file-excel"></i> آپلود چیدمان حوزه
                        </button>
                    </div>
                </div>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="col-md-4">
                            <div class="alert alert-danger alert-bordered">
                                <span class="text-semibold">{{$error}}</span>
                            </div>
                        </div>
                    @endforeach
                @endif


                <input id="myInput" type="text" placeholder="جست و جو...">
                <table id="myTable">
                    <thead>
                    <tr class="header">
                        <th>حوزه</th>
                        <th>مدیر</th>
                        <th>بازرس</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>

                    <tbody id="searchTable">
                    @foreach($modir as $key=>$row)

                        <tr>
                            <td>{{$row->name_hozeh}}</td>
                            <td>{{getModir($row->modir_code)}}</td>
                            <td @if(getBazres($row->modir_code,$exam_id) == 'بدون بازرس') style="color: red" @endif>{{getBazres($row->modir_code,$exam_id)}}</td>
                            <td class="text-center">
                                <ul class="icons-list">
                                    <li class="text-primary-600"><a class='update' data-id='{{$row->modir_code}}'><i
                                                class="icon-pencil7"></i></a></li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $("#myInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#searchTable tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <!-- /scrollable datatable -->


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





    <!-- Basic modal -->
    <div id="modal_default_save" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">ایجاد لیست چیدمان حوزه ها</h5>
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
                    <a href="{{url('/assets/templates/arrange.xlsx')}}" class="btn btn-success">دریافت تمپلیت راهنما</a>
                    <a href="/admin/modir/upload" class="btn btn-primary">آپلود</a>
                </div>

            </div>
        </div>
    </div>
    <!-- /basic modal -->


    <!-- Basic modal -->
    <div id="modal_default_hozeh" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">اعمال بازرس</h5>
                </div>


                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-control-static">
                            <p>در این قسمت همیشه نام حوزه ها و مدیرانی که هیچ بازرسی برای آنها انتخاب نگردیده است نشان
                                داده می شود.</p>
                        </div>
                    </div>

                    <div id="loading_box1" align="center">
                        <i class="icon-spinner9 spinner position-left"></i>
                        <span>در حال دریافت اطلاعات</span>
                    </div>
                    <div id="arrange_exam">


                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- /basic modal -->



@endsection


@section('script')

    <script src="/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/pages/form_select2.js"></script>

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
            var modir_code = $(this).data('id');
            var el = this;
            event.preventDefault();
            jQuery.noConflict();
            $("#modal_default").modal('show');
            $("#content-update").html("");
            $("#loading_box").show();

            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: '{{ url('/admin/hozeh/layouts/arange_update') }}',
                type: 'POST',
                data: {"_token": "{{csrf_token()}}", "modir_code": modir_code, "exam_id": "{{$exam_id}}"},

                success: function (data) {
                    $("#loading_box").hide();
                    $("#content-update").html(data);
                }
            });

        });

    </script>


    <?php
    $url = url('admin/ajax_arrange_exam');
    ?>
    <script>
        edit_arrangment = function (id) {
            event.preventDefault();
            jQuery.noConflict();
            $("#modal_default_hozeh").modal('show');
            $("#arrange_exam").html("");
            $("#loading_box1").show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ $url }}',
                type: 'POST',
                data: {"_token": "{{csrf_token()}}", "exam_id": id},

                success: function (data) {
                    if (data == 'error') {
                        $("#loading_box1").hide();
                        alert('خطا در دسترسی');

                    } else {
                        $("#loading_box1").hide();
                        $("#arrange_exam").html(data);
                    }
                }
            });
        };
    </script>

@endsection

@php
    function getHozeh($code,$exam_id){

        $hozeh = \Illuminate\Support\Facades\DB::table('exam'.$exam_id)
        ->where('modir_code',$code)
        ->first();
        if($hozeh && $hozeh->name_hozeh != '0'){
             return $hozeh->name_hozeh;
        } else {
            return 'بدون نام';
        }
    }

    function getBazres($codemeli,$exam_id){
        $bazres = \Illuminate\Support\Facades\DB::table('exam'.$exam_id)
        ->where('modir_code',$codemeli)
        ->select('bazres_code')
        ->groupBy('bazres_code')
        ->pluck('bazres_code')
        ->toArray();

        foreach ($bazres as $bazre){
            $bazres = \App\Bazres::where('codemeli',$bazre)->first();
        $users[] =$bazres->name ?? '';
        }

        $name = implode(' و ',array_unique($users));
        return $name;
    }

    function getModir($codemeli){
        $modir = \App\Modir::where('codemeli', $codemeli)->first();
        if($modir){
             return $modir->name;
        } else {
            return 'در دیتابیس موجود نیست';
        }
    }
@endphp
