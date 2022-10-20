@extends('layouts.UserLayouts')


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
                    <small class="display-block">می توانید از تب تحلیل ها وضعیت مدیر ها را رویت نمایید</small>

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
                            <li><a href="#solid-justified-tab2" data-toggle="tab">تحلیل ها</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="solid-justified-tab1">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover bg-primary-700">
                                        <thead>
                                        <tr>
                                            <th>عنوان سوال</th>
                                            <th>پاسخ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Eugene</td>
                                            <td>Kopyov</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="solid-justified-tab2">
                                تحلیل ها
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /tabs with solid background -->
@stop
