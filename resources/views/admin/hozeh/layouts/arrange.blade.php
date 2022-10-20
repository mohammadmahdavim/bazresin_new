<div class="alert alert-danger" style="display:none" id="alert_show"></div>
<div class="alert alert-success" style="display:none" id="alert_show_success"></div>
<form>
    @csrf
    <input type="hidden" value="{{$modir_code}}" name="modir_code">
    <input type="hidden" value="{{$exam_id}}" name="exam_id">
    <div class="form-group">
        <label> حوزه ی <span style="color: red">{{getModir($modir_code)}}</span> </label>
        <select class="select-results-color" name="name_hozeh">
            @foreach($hozeh as $h)
                <option value="{{$h->name_hozeh}}">{{$h->name_hozeh}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label> بازرس </label>
        <select multiple="multiple" name="bazres_code[]" class="select-results-color">
            @foreach($inspector as $ins)
                <option
                    value="{{$ins->codemeli}}"
                    @if( getBazres($modir_code,$exam_id,$ins->codemeli) )  selected="selected" @endif>{{$ins->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="modal-footer">
        <a href="/admin/modir/upload" class="btn btn-success" onclick="save_arrangment()">اعمال</a>
    </div>
</form>

<script src="/assets/js/jquery.js"></script>
<script type="text/javascript" src="/assets/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="/assets/js/pages/form_select2.js"></script>

<script>
    save_arrangment = function () {
        Swal.fire({
            title: 'صبر کنید ...',
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });
        event.preventDefault();
        jQuery.noConflict();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var data = $("form").serializeArray();
        $.ajax({
            url: '{{ url('/admin/hozeh/layouts/arange_save') }}',
            type: 'POST',
            data: data,

            success: function (data) {
                if (!data.errors) {
                    swal.close();
                    $("#alert_show").hide();
                    Swal.fire({
                        type: 'success',
                        title: 'با موفقیت ثبت گردید',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    window.location.replace("{{url('/admin/hozeh/layouts/'.$exam_id.'/edit')}}");
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


@php
    function getModir($code)
    {
        $modir = \App\Modir::where('codemeli',$code)->first();
        return $modir->name;
    }

    function getBazres($code,$exam_id,$bazres_code)
    {
        $bazres = \Illuminate\Support\Facades\DB::table('exam'.$exam_id)
        ->where('modir_code',$code)
        ->where('bazres_code',$bazres_code)
        ->get();
        if(count($bazres) != 0){
            return true;
        }
        return false;
    }
@endphp
