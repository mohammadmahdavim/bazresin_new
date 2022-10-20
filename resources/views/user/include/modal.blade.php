@if(isset($report))

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">{{$report->poshtiban}} - {{\App\Exam::find($exam_id)->name.' - '.\App\Exam::find($exam_id)->date}}</h5>
            </div>

            <div class="modal-body">
                @if(isset($mark))
                    <div class="table-responsive">
                        <table class="table table-bordered table-framed">
                            <thead>
                            <tr>
                                <th>آیتم</th>
                                <th>نمره</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>نمره کارت</td>
                                <td>{{$mark->card}} از 2</td>
                            </tr>
                            <tr>
                                <td>نمره حضور</td>
                                <td>{{$mark->hozor_ontime}} از 1</td>
                            </tr>
                            <tr>
                                <td>نمره فرم بازرسی</td>
                                <td>{{$mark->form_bazresi}} از 1</td>
                            </tr>

                            <tr>
                                <td>نمره تخته نویسی</td>
                                <td>{{$mark->takhteh_nevisi}} از 1</td>
                            </tr>

                            <tr>
                                <td>نمره کتاب برنامه ریزی</td>
                                <td>{{$mark->num_barnameh}} از 3</td>
                            </tr>


                            <tr>
                                <td>نمره کتاب خودآموز</td>
                                <td>{{$mark->num_khodamoz}} از 3</td>
                            </tr>

                            <tr>
                                <td>نمره کتاب (تابستان، زرد و ...) </td>
                                <td>{{$mark->num_book_tabestan}} از 3</td>
                            </tr>

                            <tr>
                                <td>نمره کلاس رفع اشکال</td>
                                <td>{{$mark->rafe_eshkal}} از 2</td>
                            </tr>

                            <tr>
                                <td>نمره برگه خودنگاری</td>
                                <td>{{$mark->num_khodnegari}} از 2</td>
                            </tr>

                            <tr>
                                <td>نمره ظاهر آموزشی</td>
                                <td>{{$mark->quality_face}} از 2</td>
                            </tr>

                            <tr>
                                <td>نمره ویژه (کارهای بخصوص پشتیبان)</td>
                                <td>{{$mark->extera_mark}} از 2</td>
                            </tr>

                            <tr>
                                <td>نمره نهایی</td>
                                <td>{{$mark->total}} از 20</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-framed">
                            <thead>
                            <tr>
                                <th>آیتم</th>
                                <th>نمره</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="text-align: center">
                                <td colspan="2">هیچ دیتایی موجود نیست</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
@endif
