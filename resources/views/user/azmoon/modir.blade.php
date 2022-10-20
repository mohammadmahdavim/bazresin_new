@extends('layouts.UserLayouts')

@section('content')

    <!-- Colored table options -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">لیست مدیران های حوزه</h5>
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
                    <th>مدیر</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($records as $key=>$record)
                    <tr>
                        <td>{{$record}}</td>
                        <td>
                            @if(getIar($key,$azmoon->id)['status']  == 1)
                                <span class="btn btn-success">نهایی شد</span>
                            @elseif(getIar($key,$azmoon->id)['status']  == 2)
                                <span class="btn btn-danger">بازرس نمره داد</span>
                            @else
                                <span class="btn btn-info">در انتظار</span>
                            @endif
                        </td>
                        @if(getIar($key,$azmoon->id)['status'] != 1)
                        <td><a class="btn btn-success" href="{{url('/user/azmoon/iar/'.$azmoon->id.'/'.$key)}}"><i
                                        class="icon-plus3"></i></a></td>
                            @else
                            <td>
                                <a class="btn btn-warning" href="{{url('/user/azmoon/iar/pdf/'.$azmoon->id.'/'.$key)}}"><i class="icon-printer2"></i></a>
                                <a class="btn btn-success" href="{{url('user/azmoon/iar/excel/'.$azmoon->id.'/'.$key)}}"><i class="icon-file-excel"></i></a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Button options -->
    <div class="row">


        <div class="panel panel-body border-top-primary text-center">
            <div class="btn-group btn-group-justified">
                <div class="btn-group col-md-3">
                    <a href="{{url('/user/azmoon/'.$azmoon->id)}}" class="btn btn-success bg-slate-700" id="btnSubmit">صفحه پشتیبانان</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /button options -->
    <!-- /colored table options -->
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

@php
    function getIar($modir_code,$exam_id){
        $form = \App\FormIAR::where('exam_id',$exam_id)->where('modir_code',$modir_code)->first();
        return $form;
    }
@endphp
