
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
            @foreach($modirs as $key=>$modir)
                <tr>
                    <td>{{($modirs->currentPage() != 0 ? ($modirs->currentPage() - 1) * $modirs->perPage() + $key+1 : $key+1 )}}</td>
                    <td>{{$modir->name}}</td>
                    <td>0{{$modir->mobile}}</td>
                    <td>
                        <a href="{{url('user/leader/modirs/'.$modir->codemeli)}}" type="button" class="btn btn-success">نمایش</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <div style="text-align: center">
        {{$modirs->appends(\Illuminate\Support\Facades\Input::except('page'))->render()}}
    </div>


