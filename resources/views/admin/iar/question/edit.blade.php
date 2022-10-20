{!! Form::model( $question , [ 'method'=>'PATCH' ,'id'=>'formUpdate', 'onsubmit' => 'update_ajax();return false;'] ) !!}
<div class="form-group">
    <label>عنوان سوال</label>
    <input type="text" name="question" value="{{$question->question}}" class="form-control" placeholder="صورت سوال">
</div>
<div class="form-group">
    <label> فرمت جواب دهی </label>
    <select name="type" class="form-control" id="select_type">
        <option>انتخاب کنید</option>
        <option value="4" @if($question->type == 4) selected @endif>عدد</option>
        <option value="0" @if($question->type == 0) selected @endif>پاسخ کوتاه</option>
        <option value="1" @if($question->type == 1) selected @endif>پاسخ بلند</option>
        <option value="2" @if($question->type == 2) selected @endif>گزینه ای (تک انتخابی)</option>
        <option value="3" @if($question->type == 3) selected @endif>گزینه ای (چند انتخابی)</option>
    </select>
</div>


    <div class="table-responsive colors" id="show-gozineh" @if(count($gozineh) == 0)style="display:none;"@endif>
        <table class="table table-bordered" id="dynamic_field">
            <tr>
                <td>گزینه ها</td>
                <td>
                    <button type="button" name="add" id="add" class="btn btn-success">اضافه کردن گزینه
                    </button>
                </td>
            </tr>
            @foreach($gozineh as $gozin)
                <tr tr id="row{{$gozin->id}}" class="dynamic-added">
                    <td><input type="text" name="gozineh[]" placeholder="گزینه را بنویسید..."
                               class="form-control name_list" value="{{$gozin->name}}"></td>
                    <td>
                        <button type="button" name="remove" id="{{$gozin->id}}" class="btn btn-danger btn_remove">X</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>


<div class="form-group">
    <label>توضیحات سوال</label>
    <textarea type="text" name="description" class="form-control" rows="5"
              placeholder="توضیحاتی راجب این آیتم برای راهنمایی بازرس درج نمایید">{{$question->description}}</textarea>
</div>

<div class="form-group">
    <label>نمره این آیتم</label>
    <input type="text" name="mark" value="{{$question->mark}}" class="form-control" placeholder="نمره از 100">
</div>

<div class="form-group">
    <label>وضعیت</label>
    <select name="status" class="form-control">
        <option value="0" @if($question->status == 0) selected @endif>غیر فعال</option>
        <option value="1" @if($question->status == 1) selected @endif> فعال</option>
    </select>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-link" data-dismiss="modal">لغو</button>
    <button type="button" class="btn btn-primary update-btn" data-id='<?= $question->id ?>'>بروزرسانی</button>
</div>

{!! Form::close() !!}


<script>
    $(document).on("click", ".update-btn", function () {
        var data = $("#formUpdate").serialize();
        console.log(data);
        var id = $(this).data('id');
        $.ajax({
            url: '{{ url('admin/iar/question/')}}/' + id,
            type: 'PUT',
            data: data,
            success: function (data) {
                if (data === 'ok') {
                    Swal.fire(
                        'موفق',
                        'بروزرسانی شد',
                        'success'
                    );
                    window.location.replace("{{url('/admin/iar/question')}}");
                } else if (data === 'max_denied') {
                    Swal.fire(
                        'خطا',
                        'مقدار نمره کل سوالات فعال نباید بیش از 100 گردد',
                        'warning'
                    );
                }
            }
        });

    });
</script>
<script>
    $(function() {
        $('#select_type').change(function(){
            $('.colors').hide();
            if($(this).val() == 2 || $(this).val() == 3){
                $('#show-gozineh').show();
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var i = 1;

        $('#add').click(function () {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="text" name="gozineh[]" placeholder="گزینه را بنویسید..." class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

    });
</script>
