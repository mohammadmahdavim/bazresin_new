@extends('layouts.AdminLayouts')

@section('css')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: center;
            padding: 8px;
            border-bottom: -20px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }


    </style>
@endsection

@section('script')
    <script>
        function toggle(column, obj, proj_id) {
            var $input = $(obj);
            if ($input.prop('checked')) {
                required(column,proj_id,1);
            }
            else {
                required(column,proj_id,0);
            }
        }

        function required(column,proj_id,type) {

            Swal.fire({
                title: 'در حال ثبت ...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            $.ajax({
                url: '{{ url('/admin/ajaxChangeRequireColumn') }}',
                type: 'POST',
                data: {"_token": "{{csrf_token()}}", "column":column, "type":type, "proj_id": proj_id},
                success: function (data) {
                    if(data.status === 200){
                        Swal.fire({
                            type: 'success',
                            title: 'انجام شد',
                            showConfirmButton: false,
                            timer: 5000
                        })
                    } else {
                        Swal.fire({
                            type: 'warning',
                            title: 'خطای نامشخص',
                            showConfirmButton: false,
                            timer: 5000
                        })
                    }

                }

            });
        }
    </script>
@endsection

@section('content')
    <!-- Dashed border styling -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <table>
                <tr>
                    <th style="text-align:right;">
                        <h5 class="panel-title">تغییر در ستون های آزمون</h5></th>
                    <th>
                        <a data-toggle="modal" data-target="#editname"
                           style="text-align: center;" class="btn btn-primary a-btn-slide-text">

                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            <span><strong>نام و اجزا پروژه را تغییر دهید...</strong></span>

                        </a></th>
                </tr>
            </table>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">

            در این قسمت میتوانید تغییراتی در ستون های آزمون ایجاد کنید
            <br><br>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>اجباری</th>
                        <th>نوع ستون</th>
                        <th>نام ستون</th>
                        <th>مشاهده گزینه ها</th>
                        <th>تغییر نام ستون</th>
                        <th>افزودن ستون</th>
                        <th>حذف ستون</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach( getcolum($exam) as $column )
                        <?php $x = 0; ?>
                        <tr class="border-dashed">

                            <td><input type="checkbox" @if(getRequired($column,$exam) == 1) checked @endif name="required_{{$exam}}" onclick="toggle('{{$column}}', this, '{{$exam}}')"></td>
                            <td>
                                <select class="select" onchange="type_columns_change(this,'{{$column}}')">


                                    <option value="0" @if(getTypeColumn($column,$exam) == 0) selected="selected" @endif>
                                        قابل نمایش
                                    </option>

                                    <option value="1" @if(getTypeColumn($column,$exam) == 1) selected="selected" @endif>
                                        قابل نوشتن
                                    </option>

                                    <option value="2" @if(getTypeColumn($column,$exam) == 2) selected="selected" @endif>
                                        تک گزینه
                                    </option>

                                    <option value="3" @if(getTypeColumn($column,$exam) == 3) selected="selected" @endif>
                                        چند گزینه
                                    </option>

                                    <option value="4" @if(getTypeColumn($column,$exam) == 4) selected="selected" @endif>
                                        عددی
                                    </option>

                                    <option value="6" @if(getTypeColumn($column,$exam) == 6) selected="selected" @endif>
                                        مخفی
                                    </option>

                                </select>
                            </td>
                            <td>{{$header->$column}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-success btn-sm" type="button" data-toggle="dropdown"
                                            id="{{$column}}12">تغییر آیتم ها
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        @foreach ($items as $item)
                                            @if($item->$column != "")
                                                <?php $x = 1; ?>
                                                <li><a data-toggle="modal" data-target="#{{$column}}{{$item->id}}"><span
                                                            class="glyphicon glyphicon-eye-open"></span> {{$item->$column}}
                                                    </a></li>

                                            @endif
                                            @if( $x == 1)
                                                <script type="text/javascript">
                                                    document.getElementById("{{$column}}12").disabled = false;
                                                </script>
                                            @endif
                                        @endforeach
                                        <li class="divider"></li>
                                        <li>

                                            <a data-toggle="modal" data-target="#{{$column}}222"
                                               style="text-align: center;">
                                                <span class="glyphicon">&#x2b;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>


                            </td>

                            <td>

                                <div data-fab-label="تغییر نام ستون">
                                    <a data-toggle="modal" data-target="#{{$column}}"
                                       class="btn btn-default btn-rounded btn-icon btn-float">
                                        <i class="icon-pencil"></i>
                                    </a>

                                </div>


                            </td>
                            <td><a data-toggle="modal" data-target="#{{$column}}1" class="btn btn-info">
                                    <span class="glyphicon glyphicon-plus-sign"></span> افزودن
                                </a></td>

                            <td>

                                <a onclick="deletecolumn('{{$exam}}','{{$column}}')"
                                   class="btn btn-danger a-btn-slide-text"><span class="glyphicon glyphicon-remove"
                                                                                 aria-hidden="true"></span>
                                    <span><strong>حذف</strong></span></a>


                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- /page container -->

    <!-- Vertical form modal -->



    @foreach( getcolum($exam) as $column1 )
        <div id="{{$column1}}" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">تغییر نام ستون {{$column1}}</h5>
                    </div>

                    <form action="{{ URL::to('/admin/exams/update/editname') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>نام جدید ستون</label>
                                        <input type="text" name="newname" class="form-control" required
                                               oninvalid="this.setCustomValidity('لطفا این فیلد را پر کنید')"
                                               oninput="this.setCustomValidity('')">
                                    </div>


                                    <input type="hidden" value="{{$exam}}" id="date10" name="exam_id"
                                           class="form-control">

                                </div>
                            </div>


                            <input type="hidden" name="colname" value="{{$column1}}">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">لغو</button>
                            <button type="submit" class="btn btn-primary">ثبت</button>
                        </div>
                        {{ Form::close() }}
                    </form>


                    <!-- /basic layout -->


                </div>
            </div>
        </div>
    @endforeach





    @foreach( getcolum($exam) as $column13 )
        @foreach( $items as $item1 )
            <div id="{{$column13}}{{$item1->id}}" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h5 class="modal-title">تغییر نام آیتم "<span
                                    style="color:red;">{{$item1->$column13}}</span>"</h5>
                        </div>

                        <form action="{{ URL::to('/admin/exams/update/edititem') }}" method="post">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label>نام جدید آیتم</label>
                                            <input type="text" name="newname" class="form-control" required
                                                   oninvalid="this.setCustomValidity('لطفا این فیلد را پر کنید')"
                                                   oninput="this.setCustomValidity('')">
                                        </div>


                                        <input type="hidden" value="{{$exam}}" id="date10" name="exam_id"
                                               class="form-control">

                                    </div>
                                </div>


                                <input type="hidden" name="colname" value="{{$column13}}">
                                <input type="hidden" name="itemid" value="{{$item1->id}}">

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-remove" data-dismiss="modal">لغو</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"
                                        onclick="delitem('{{$exam}}','{{$item1->id}}','{{$column13}}')">حذف
                                </button>
                                <button type="submit" class="btn btn-primary">ثبت</button>
                            </div>
                            {{ Form::close() }}
                        </form>


                        <!-- /basic layout -->


                    </div>
                </div>
            </div>
        @endforeach
    @endforeach



    <!-- add column -->
    <?php $z = 0; ?>
    @foreach( getcolum($exam) as $column2 )
        <?php $z = $z + 1; ?>
        <div id="{{$column2}}1" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">افزودن ستون</h5>
                    </div>

                    <form action="{{ URL::to('/admin/exams/update/addcol') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>نام ستون</label>
                                        <input type="text" name="name" class="form-control" required
                                               oninvalid="this.setCustomValidity('لطفا این فیلد را پر کنید')"
                                               oninput="this.setCustomValidity('')">
                                    </div>
                                    <br><br>
                                    <hr>
                                    <div class="col-sm-12">
                                        <label>نام ستون در دیتابیس</label>
                                        <input type="text" name="newcol" class="form-control" required
                                               oninvalid="this.setCustomValidity('لطفا این فیلد را پر کنید')"
                                               oninput="this.setCustomValidity('')">
                                    </div>
                                    <br><br>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <label>این ستون گزینه انتخابی دارد</label>
                                        </div>
                                        <div class="switchery-xs">
                                            <input type="checkbox" id="myCheck{{$z}}" class="styled" name="select"
                                                   onclick="itemfield('{{$z}}')">
                                        </div>
                                    </div>

                                    <hr>
                                    <p id="parag{{$z}}" style="display: none">
                                        <label>گزینه های ستون رو به مانند مثال وارد کنید</label>
                                        <textarea type="text" id="items{{$z}}" name="items" class="form-control"
                                                  placeholder="اولویت اول/اولویت دوم/اولیت سوم"
                                                  oninvalid="this.setCustomValidity('شما گفته اید این ستون گزینه انتخابی دارد')"
                                                  oninput="this.setCustomValidity('')"></textarea>
                                    </p>

                                    <input type="hidden" value="{{$exam}}" id="date10" name="exam_id"
                                           class="form-control">

                                </div>
                            </div>


                            <input type="hidden" name="colname" value="{{$column2}}">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">لغو</button>
                            <button type="submit" class="btn btn-primary">ثبت</button>
                        </div>
                        {{ Form::close() }}
                    </form>


                    <!-- /basic layout -->


                </div>
            </div>
        </div>


    @endforeach



    @foreach( getcolum($exam) as $column22 )
        <div id="{{$column22}}222" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title">افزودن گزینه</h5>
                    </div>
                    <hr>
                    <form action="{{ URL::to('/admin/exams/update/additem') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>نام آیتم</label>

                                        <input type="text" name="name" class="form-control" required
                                               oninvalid="this.setCustomValidity('لطفا این فیلد را پر کنید')"
                                               oninput="this.setCustomValidity('')">
                                    </div>

                                    <input type="hidden" value="{{$exam}}" id="date110" name="exam_id"
                                           class="form-control">

                                </div>
                            </div>


                            <input type="hidden" name="colname" value="{{$column22}}">

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">لغو</button>
                            <button type="submit" class="btn btn-primary">ثبت</button>
                        </div>
                        {{ Form::close() }}
                    </form>


                    <!-- /basic layout -->


                </div>
            </div>
        </div>

    @endforeach



    <div id="editname" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">تغییر پروژه</h5>
                </div>

                <form action="{{ URL::to('/admin/exams/update_exam') }}" class="form-horizontal" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">نام پروژه:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" name="name"
                                           value="{{$totalproj->name}}" required
                                           oninvalid="this.setCustomValidity('لطفا این فیلد را پر کنید')">
                                </div>
                            </div>

                            <input type="hidden" name="exam_id" value="{{$exam}}">


                            <div class="form-group">
                                <label class="col-lg-3 control-label">توضیحات آزمون :</label>
                                <div class="col-lg-9">
                                    <textarea rows="5" cols="5" name="description" class="form-control"
                                              placeholder="متن مورد نظرتان را اینجا بنویسید"
                                              required>{{$totalproj->description}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label">تاریخ آزمون :</label>
                                <div class="col-lg-9">
                                    <input type="text" id="date1" class="form-control" name="date"
                                           value="{{$totalproj->date}}">
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-lg-3 control-label">شماره تماس مسئول آزمون</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" value="{{$totalproj->supervisor}}"
                                           name="supervisor" placeholder="...09">
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" id="project" class="btn btn-primary project">بروزرسانی<i
                                        class="icon-arrow-left13 position-right"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /basic layout -->
            </div>
        </div>
    </div>


    <!-- /dashed border styling -->
@endsection




<script>


    function show(str) {

        $.ajax({
            type: "post",
            url: "/admin/exams/update/show",

            data: {'email': 'che607@yahoo.com'},
            dataType: 'json',
            success: function (data) {
                console.log('SUCCESS: ', data);
            },
            error: function (data) {
                console.log('ERROR: ', data);
            },
        });

    }


    function deletecolumn(id, column) {

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
                window.location.href = "/admin/exams/update/" + id + '/' + column;
            }
        });

    }

    function delitem(id, itemid, column) {

        window.location.href = "/admin/exams/update/" + id + '/' + itemid + '/' + column;
    }


    function itemfield(z) {
        var checkBox = document.getElementById("myCheck" + z);
        var text = document.getElementById("items" + z);
        var p = document.getElementById("parag" + z);

        if (checkBox.checked == true) {
            p.style.display = "block";
            document.getElementById("items").required = true;

        } else {
            p.style.display = "none";
            document.getElementById("items").required = false;
        }
    }


</script>

<?php $url = url('/admin/ajax_change_type_column'); ?>
<script>


    type_columns_change = function (selectObject, column) {
        var value = selectObject.value;
        Swal.fire({
            title: 'صبر کنید ...',
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ $url }}',
            type: 'POST',
            data: {"_token": "{{csrf_token()}}", "column": column, "type": value, "proj_id": '{{$exam}}'},

            success: function (data) {
                Swal.fire({
                    type: 'success',
                    title: 'انجام شد',
                    showConfirmButton: false,
                    timer: 5000
                })
            }

        });
    };
</script>
<?php

function getcolum($exam_id)
{
    $table_col = DB::getSchemaBuilder()->getColumnListing('exam' . $exam_id);
    $remove = ["id", "bazres", "date", "status", 'condition', "bazres_code", "modir_code", "modir_mobile", "poshtiban_mobile", "poshtiban_code", "type", 'comment'];
    $table_col = \array_diff($table_col, $remove);
    return $table_col;
}


function getitems($exam_id, $colname)
{
    $item_name = DB::table('exam' . $exam_id)->where('id', 3)->select($colname)->pluck('name_culomn')->toArray();
    return $item_name;
}

function getTypeColumn($column, $exam)
{
    $type = DB::table('exam' . $exam)->first();
    return $type->$column;
}

function getRequired($column,$id){
    $required = \Illuminate\Support\Facades\DB::table('exam'.$id)
        ->where('type',4)
        ->first();
    if($required != null){
        return $required->$column;
    }

    return false;
}
?>
