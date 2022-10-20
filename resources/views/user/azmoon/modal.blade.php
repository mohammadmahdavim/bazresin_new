
    <table class="table table-bordered table-framed">
        <thead>
        <tr>
            <th>آیتم</th>
            <th>نمره</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>نمره کارت از 2 نمره</td>
            <td>{{($mark != null ? $mark->card : '' )}} </td>
        </tr>
        <tr>
            <td>نمره حضور از 1 نمره</td>
            <td>{{($mark != null ? $mark->hozor_ontime : '')}}</td>
        </tr>
        <tr>
            <td>نمره فرم بازرسی از 1 نمره</td>
            <td>{{($mark != null ? $mark->form_bazresi : '') }} </td>
        </tr>

        <tr>
            <td>نمره تخته نویسی از 1 نمره</td>
            <td>{{($mark != null ? $mark->takhteh_nevisi : '') }}  </td>
        </tr>

        <tr>
            <td>نمره کتاب برنامه ریزی از 3 نمره</td>
            <td>{{($mark != null ? $mark->num_barnameh : '') }} </td>
        </tr>


        <tr>
            <td>نمره کتاب خودآموز از 3 نمره</td>
            <td>{{($mark != null ? $mark->num_khodamoz : '') }}</td>
        </tr>

        <tr>
            <td>نمره کتاب (تابستان، زرد و ...) از 3 نمره</td>
            <td>{{($mark != null ? $mark->num_book_tabestan : '') }} </td>
        </tr>

        <tr>
            <td>نمره کلاس رفع اشکال از 2 نمره</td>
            <td>{{($mark != null ? $mark->rafe_eshkal : '') }} </td>
        </tr>

        <tr>
            <td>نمره برگه خودنگاری از 2 نمره</td>
            <td>{{($mark != null ? $mark->num_khodnegari : '') }} </td>
        </tr>

        <tr>
            <td>نمره ظاهر آموزشی از 2 نمره</td>
            <td>{{($mark != null ? $mark->quality_face : '') }}  </td>
        </tr>

        <tr>
            <td>نمره ویژه (کارهای بخصوص پشتیبان) از 2 نمره</td>
            <td>{{($mark != null ? $mark->extera_mark : '') }}  </td>
        </tr>

        <tr class="success">
            <td>نمره نهایی از 2 + 20 نمره</td>
            <td>{{($mark != null ? $mark->total : '')}}</td>
        </tr>

        </tbody>
    </table>

