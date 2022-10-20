{!! Form::model( $permission , [ 'method'=>'PATCH' ,'id'=>'formUpdate', 'onsubmit' => 'update_ajax();return false;'] ) !!}
<div class="form-group">
    <label>نام لاتین مجوز:</label>
    <input type="text" class="form-control" value="{{$permission->name}}" name="name">
</div>

<div class="form-group">
    <label>عنوان مجوز:</label>
    <input type="text" class="form-control" value="{{$permission->label}}" name="label">
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-link" data-dismiss="modal">لغو</button>
    <button type="button" class="btn btn-primary update-btn" data-id='<?= $permission->id ?>'>بروزرسانی</button>
</div>

{!! Form::close() !!}


<script>
    $(document).on("click", ".update-btn", function () {
        var data = $("#formUpdate").serialize();
        console.log(data);
        var id = $(this).data('id');
        $.ajax({
            url: '{{ url('admin/permissions/')}}/' + id,
            type: 'PUT',
            data: data,
            success: function (data) {
                if(data == 'ok'){
                    Swal.fire(
                        'موفق',
                        'بروزرسانی شد',
                        'success'
                    );
                    window.location.replace("{{url('/admin/permissions')}}");
                }
            }
        });

    });
</script>
