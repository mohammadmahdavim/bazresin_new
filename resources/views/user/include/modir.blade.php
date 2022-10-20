<script type="text/javascript" src="{{url('/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{url('/assets/js/pages/datatables_basic.js')}}"></script>
<!-- Style combinations -->
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title"> لیست نتایج </h5>
        <div class="heading-elements">
            <a class="btn btn-success" onclick="export_excel('{{$url}}');">    اکسل جمع بندی<i class="icon-file-excel"></i></a>
            <a class="btn btn-success" onclick="export_excel_iar('{{$url}}');">    اکسل ریز IAR<i class="icon-file-excel"></i></a>
            <a class="btn btn-danger" onclick="export_performance_pdf('{{$url}}');"> عملکرد آزمون محور <i class="icon-file-pdf"></i></a>
        </div>
    </div>

    <div class="panel-body">

        <table class="table datatable-basic table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th> آزمون </th>
                <th>نام مدیر</th>
                <th>بازرس</th>
                <th>وضعیت بازرسی</th>
                <th>نمره</th>
                <th>رنگ نظم</th>
                <th>رنگ کارهای کیفی و کمی</th>
                <th class="text-center">عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($modirs as $modir)
                <tr>
                    <td>{{getExam($modir->exam_id)}}</td>
                    <td>{{\App\lib\EnConverter::ar2fa($modir->modir)}}</td>
                    <td>{{ \App\Bazres::bazres(getmark($modir->exam_id,$modir->modir_code)['bazres_code']) }}</td>
                    <td>{{ (getmark($modir->exam_id,$modir->modir_code)['status'] == 1 ? 'بازرسی شده' : 'عدم بازرسی') }}</td>
                    <td>{{ (getmark($modir->exam_id,$modir->modir_code)['mark'] != null ? getmark($modir->exam_id,$modir->modir_code)['mark'] : 0) }}</td>
                    <td>{{ (getmark($modir->exam_id,$modir->modir_code)['mark_nazm'] != null ? getmark($modir->exam_id,$modir->modir_code)['mark_nazm'] :  0) }}</td>
                    <td>{{ (getmark($modir->exam_id,$modir->modir_code)['mark_performance'] != null ? getmark($modir->exam_id,$modir->modir_code)['mark_performance'] : 0) }}</td>
                    <td>
                        <a href="{{url('/user/report/modir/'.$modir->exam_id.'/'.$modir->modir_code)}}" class="btn btn-info">جزئیات</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
<!-- /style combinations -->
<?php
function getmark($exam_id, $codemeli)
{
    $iar = \App\FormIAR::where('exam_id', $exam_id)
        ->where('modir_code', $codemeli)
        ->first();
    return $iar;
}

function getExam($id)
    {
        $exam = \App\Exam::find($id)->name;
        return $exam;
    }
?>


<script>

    function export_excel(url) {

        Swal.fire({
            title: 'صبر کنید...',
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });

        $.ajax({
            url: '{{url("/user/report/excel")}}?' + url,
            type: 'GET',
            success : function (response) {
                if(response.status === 400){
                    swal.fire({
                        type: 'warning',
                        title: 'هشدار',
                        text: response.error
                    });
                } else {
                    window.swal({
                        title: "درحال ایجاد گزارش",
                        showConfirmButton: false,
                        trxt: 'کمی صبر نمایید',
                        type: 'success',
                        timer: 5000
                    });
                    window.location = '{{url("/user/report/excel")}}?' + url;
                }
            }
        });
    }
</script>


<script>

    function export_excel_iar(url) {

        Swal.fire({
            title: 'صبر کنید...',
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });

        $.ajax({
            url: '{{url("/user/report/excelItemIar")}}?' + url,
            type: 'GET',
            success : function (response) {
                if(response.status === 400){
                    swal.fire({
                        type: 'warning',
                        title: 'هشدار',
                        text: response.error
                    });
                } else {
                    window.swal({
                        title: "درحال ایجاد گزارش",
                        showConfirmButton: false,
                        trxt: 'کمی صبر نمایید',
                        type: 'success',
                        timer: 5000
                    });
                    window.location = '{{url("/user/report/excelItemIar")}}?' + url;
                }
            }
        });
    }
</script>

<script>
    export_performance_pdf = function (url) {
        Swal.fire({
            title: 'صبر کنید...',
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });

        $.ajax({
            url: '{{url("/user/report/pdf")}}?' + url,
            type: 'GET',
            success : function (response) {
                if(response.status === 400){
                    swal.fire({
                        type: 'warning',
                        title: 'هشدار',
                        text: response.error
                    });
                } else {
                    window.swal({
                        title: "درحال ایجاد گزارش",
                        showConfirmButton: false,
                        trxt: 'کمی صبر نمایید',
                        type: 'success',
                        timer: 5000
                    });
                    window.location = '{{url("/user/report/pdf")}}?' + url;
                }
            }
        });
    }
</script>
