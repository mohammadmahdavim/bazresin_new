@extends('layouts.AdminLayouts')


@section('content')

    <div class="row">
        <div class="col-lg-12">
            @foreach($errors->all() as $error)
                <div class="alert alert-warning no-border">
                    <span class="text-semibold">{{$error}}</span>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span>
                    </button>
                </div>
            @endforeach
        </div>
        {!! Form::open(['url'=>'admin/iar/question']) !!}
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">ایجاد سوال جدید</h5>
                    <div class="heading-elements">
                        <a href="{{ url('admin/iar/question') }}" class="btn bg-blue btn-xs btn-icon">بازگشت به مدیریت
                            سوالات<i class="icon-backward"></i></a>
                    </div>
                </div>


                <div class="panel-body">
                    <div class="form-group">
                        <label>عنوان سوال</label>
                        <input type="text" name="question" value="{{old('question')}}" class="form-control"
                               placeholder="صورت سوال">
                    </div>

                    <div class="form-group">
                        <label> فرمت جواب دهی </label>
                        <select name="type" class="form-control" id="select_type">
                            <option>انتخاب کنید</option>
                            <option value="4">عدد</option>
                            <option value="0">پاسخ کوتاه</option>
                            <option value="1">پاسخ بلند</option>
                            <option value="2">گزینه ای (تک انتخابی)</option>
                            <option value="3">گزینه ای (چند انتخابی)</option>

                        </select>
                    </div>

                    <div class="form-group colors" id="show-gozineh" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dynamic_field">
                                <tr>
                                    <td><input type="text" name="gozineh[]" placeholder="گزینه را بنویسید..."
                                               class="form-control name_list"/></td>
                                    <td>
                                        <button type="button" name="add" id="add" class="btn btn-success">اضافه کردن گزینه
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>توضیحات سوال</label>
                        <textarea type="text" name="description" class="form-control" rows="5"
                                  placeholder="توضیحاتی راجب این آیتم برای راهنمایی بازرس درج نمایید">{{old('description')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>نمره این آیتم</label>
                        <input type="text" name="mark" value="{{old('mark')}}" class="form-control"
                               placeholder="نمره از 100">
                    </div>


                    <div class="text-right">
                        {!! Form::submit('ثبت سوال',['class'=>'btn btn-success']) !!}
                    </div>
                </div>

            </div>


        </div>
        {!! Form::close() !!}
    </div>
@endsection


@section('script')

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
@endsection
