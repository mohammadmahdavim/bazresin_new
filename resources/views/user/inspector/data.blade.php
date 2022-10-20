<table class="table datatable-basic" id='myTable'>
    <thead>
    <tr>
        <th>منطقه</th>
        <th>مدیر</th>
        <th>موبایل</th>
        <th>کل دانش آموزان</th>
        <th>دانش آموزان حاضر</th>
        <th>دانش آموزان متاخر</th>
        <th>غائبین</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($modirs as $key=>$record)
        <tr>
            <td>{{$record->zone}}</td>
            <td>{{$record->modir}}</td>
            <td>{{$record->modir_mobile}}</td>
            <td>{{$record->total}}</td>
            <td>{{$record->hozor_ontime}}</td>
            <td>{{$record->hozor_delay}}</td>
            <td>{{($record->total - $record->hozor_ontime - $record->hozor_delay)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
