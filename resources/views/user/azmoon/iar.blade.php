@extends('layouts.UserLayouts')

@section('script')
    <script src="/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/pages/form_select2.js"></script>

    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/inputs/touchspin.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/form_input_groups.js')}}"></script>


    <script>
        save_iar = function (type) {
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

            var form = $("form").serializeArray();
            //ajax call to save image inside folder
            $.ajax({
                url: '{{url('/user/ajaxSaveIar')}}',
                data: form,
                type: 'POST',
                success: function (data) {
                    if (!data.errors && data !== 'nulls') {
                        swal.close();
                        $("#alert_show").hide();
                        Swal.fire({
                            type: 'success',
                            title: 'با موفقیت ثبت گردید',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        window.location.replace("{{url('/user/azmoon/iarSubmit/'.$exam_id.'/'.$modir_code)}}");
                    } else if(data === 'nulls'){
                        Swal.fire({
                            type: 'warning',
                            title: 'پر کردن تمامی آیتم ها الزامی است',
                            showConfirmButton: false,
                            timer: 3000
                        });
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

@endsection

@section('content')
    <!-- Solid tabs title -->
    <h6 class="content-group text-semibold">
        فرم ارزشیابی IAR
    </h6>
    <!-- /solid tabs title -->


    <!-- Tabs with solid background -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <small class="display-block">می توانید از تب تحلیل ها وضعیت پشتیبان ها را رویت نمایید</small>

                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                            <li><a data-action="reload"></a></li>
                            <li><a data-action="close"></a></li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                            <li class="active"><a href="#solid-justified-tab1" data-toggle="tab">فرم ازریابی</a></li>
                            <li><a href="#solid-justified-tab2" data-toggle="tab">تاریخچه</a></li>
                        </ul>

                        {{--                        <option value="4">عدد</option>--}}
                        {{--                        <option value="0">پاسخ کوتاه</option>--}}
                        {{--                        <option value="1">پاسخ بلند</option>--}}
                        {{--                        <option value="2">گزینه ای (تک انتخابی)</option>--}}
                        {{--                        <option value="3">گزینه ای (چند انتخابی)</option>--}}


                        <div class="tab-content">
                            <div class="tab-pane active" id="solid-justified-tab1">
                                <form id="formIAR">
                                    @csrf
                                    <input type="hidden" name="modir_code" value="{{$modir_code}}">
                                    <input type="hidden" name="exam_id" value="{{$exam_id}}">
                                    <input type="hidden" name="hozeh_code"
                                           value="@if($hozeh){{$hozeh->hozeh_code}}@endif">
                                    <fieldset class="content-group">
                                        @foreach($questions as $key=>$question)
                                            <div class="form-group">
                                                <label class="control-label col-lg-3">{{$key+1}}
                                                    - {{$question->question}}</label>
                                                <div class="col-lg-9">
                                                    <div class="row">
                                                        <div class="col-xs-7">
                                                            @if($question->type !=4)
                                                                <select name="itemMark{{$question->id}}"
                                                                        class="form-control" required>
                                                                    <option value="">انتخاب کنید</option>
                                                                    <option value="0" @if($iar != null && getHistory($question->id,$iar->id)['mark'] == 0) selected="selected" @endif>مشکی</option>
                                                                    <option value="1"  @if($iar != null && getHistory($question->id,$iar->id)['mark'] == 1) selected="selected" @endif>قرمز</option>
                                                                    <option value="2"  @if($iar != null && getHistory($question->id,$iar->id)['mark'] == 2) selected="selected" @endif> زرد</option>
                                                                    <option value="3"  @if($iar != null && getHistory($question->id,$iar->id)['mark'] == 3) selected="selected" @endif>سبز</option>
                                                                    <option value="4"  @if($iar != null && getHistory($question->id,$iar->id)['mark'] == 4) selected="selected" @endif>سبزپررنگ</option>
                                                                    <option value="5"  @if($iar != null && getHistory($question->id,$iar->id)['mark'] == 5) selected="selected" @endif>آبی</option>
                                                                </select>
                                                            @else
                                                                <input type="number" name="itemMark{{$question->id}}"
                                                                       class="touchspin-postfix-ghalamchi" value="@if($iar != null ){{getHistory($question->id,$iar->id)['mark']}}@endif">
                                                            @endif

                                                        </div>

                                                        <div class="col-xs-5">
                                                            @if($question->type == 0)
                                                                <input type="text" class="form-control"
                                                                       name="itemDesc{{$question->id}}"
                                                                       placeholder="پاسخ کوتاه" value="@if($iar != null ){{getHistory($question->id,$iar->id)['description']}}@endif">
                                                            @elseif($question->type == 1)
                                                                <textarea name="itemDesc{{$question->id}}" rows="5"
                                                                          cols="5"
                                                                          class="form-control"
                                                                          placeholder="توضیحی درج کنید">@if($iar != null ){{getHistory($question->id,$iar->id)['description']}}@endif</textarea>

                                                            @elseif($question->type == 2)
                                                                <select name="itemDesc{{$question->id}}"
                                                                        class="form-control">
                                                                    <option value="">انتخاب کنید</option>
                                                                    @foreach(getGozineh($question->id) as $gozineh)
                                                                        <option
                                                                            value="{{$gozineh->id}}" @if($iar != null && getHistory($question->id,$iar->id)['description'] == $gozineh->id) selected="selected" @endif>{{$gozineh->name}}</option>
                                                                    @endforeach
                                                                </select>

                                                            @elseif($question->type == 4)
                                                                <textarea name="itemDesc{{$question->id}}" rows="5"
                                                                          cols="5"
                                                                          class="form-control"
                                                                          placeholder="توضیحی درج کنید">@if($iar != null ){{getHistory($question->id,$iar->id)['description']}}@endif</textarea>
                                                            @elseif($question->type == 3)
                                                                <div class="input-group">
											                <span class="input-group-btn">
												                <button class="btn btn-default btn-icon"
                                                                        type="button"><i
                                                                        class="icon-select2"></i></button>
											                </span>
                                                                    <select name="itemDesc{{$question->id.'[]'}}"
                                                                            multiple="multiple"
                                                                            class="select-results-color">
                                                                        @foreach(getGozineh($question->id) as $gozineh)
                                                                            <option
                                                                                value="{{$gozineh->id}}" @if($iar != null && strpos($gozineh->id,getHistory($question->id,$iar->id)['description']) !== false ) selected="selected" @endif>{{$gozineh->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <span class="help-block">توضیحات : {{$question->description}}</span>

                                                </div>
                                            </div>
                                        @endforeach
                                    </fieldset>
                                    <div class="text-right">
                                        <a onclick="save_iar('1')" class="btn btn-primary">ثبت و تایید <i
                                                class="icon-arrow-left13 position-right"></i></a>

                                    </div>
                                </form>

                            </div>

                            <div class="tab-pane" id="solid-justified-tab2">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /tabs with solid background -->
@stop

@php
    function getGozineh($id)
    {
        $data = \App\Gozineh::where('question_id',$id)->get();
        return $data;
    }

    function getHistory($question_id,$iar_id)
    {
        $history = \App\DetailsIar::where('iar_id',$iar_id)->where('question_id',$question_id)->first();
        return $history;
    }
@endphp
