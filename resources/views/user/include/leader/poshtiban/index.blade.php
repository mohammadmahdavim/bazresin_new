
    <div class="table-responsive">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>نام و نام خانوادگی</th>
                <th>موبایل</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($poshtibans as $key=>$poshtiban)
                <tr>
                    <td>{{($poshtibans->currentPage() != 0 ? ($poshtibans->currentPage() - 1) * $poshtibans->perPage() + $key+1 : $key+1 )}}</td>
                    <td>{{$poshtiban->name}}</td>
                    <td>0{{$poshtiban->mobile}}</td>
                    <td>
                        <a href="{{url('user/leader/poshtibans/'.$poshtiban->codemeli)}}" type="button" class="btn btn-success">نمایش</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <div style="text-align: center">
        {{$poshtibans->appends(\Illuminate\Support\Facades\Input::except('page'))->render()}}
    </div>


