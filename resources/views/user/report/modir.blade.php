@extends('layouts.UserLayouts')

@section('css')
<style>
    .has-scroll {
        max-height: 192px;
        overflow-y: auto;
    }
</style>
@stop
@section('script')
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/form_layouts.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/datatables_basic.js')}}"></script>



    <script type="text/javascript">
        $(function () {
            $('body').on('click', '.pagination a', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'صبر کنید...',
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
                var url = $(this).attr('href');
                filter_modir(url);
                window.history.pushState("", "", url);
            });
        });
    </script>

@stop


@section('content')
    <!-- Search field -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">جست و جوی مدیر حوزه ها</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"> آزمون:</label>
                        <div class="col-sm-8">
                            <div class="has-scroll">
                                @foreach($exams as $key=>$exam)
                                    <div class="checkbox">
                                        <label class="display-block">
                                            <input class="styled" id="checkbox{{$key}}" type="checkbox"
                                                   name="exam_id[{{$key}}]"
                                                   data-value="{{$exam->id}}"
                                                   @if(array_key_exists('exam_id',$filters) && array_key_exists($key,$filters['exam_id']) && $filters['exam_id']["$key"] == $exam->id) checked @endif
                                            >
                                            {{$exam->name}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">منطقه:</label>
                        <div class="col-sm-8">
                            <div class="has-scroll">
                                @foreach($zones as $key=>$zone)
                                    <div class="checkbox">
                                        <label class="display-block">
                                            <input class="styled" id="checkbox{{$key}}" type="checkbox"
                                                   name="zones[{{$key}}]"
                                                   data-value="{{$zone->zone}}"
                                                   @if(array_key_exists('zones',$filters) && array_key_exists($key,$filters['zones']) && $filters['zones']["$key"] == $zone->zone) checked @endif
                                            >
                                            {{$zone->zone}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /search field -->


    <section class="modirs">
        @include('user.include.modir')
    </section>


    <script>
        const boxs = document.querySelectorAll('input[type="checkbox"]');
        const queries = window.location.search ?
            window.location.search.slice(1).split('&') :
            [];
        boxs.forEach(box => {
            box.addEventListener('change', onFilter)
        });

        function onFilter(e) {
            const {name, checked} = e.target;
            const value = e.target.dataset.value;
            const searchName = queries.map(query => query.split('=')[0])
            const queryIndex = searchName.indexOf(name);

            if (queryIndex !== -1 && !checked) {
                queries.splice(queryIndex, 1);
            } else if (queryIndex === -1 && checked) {
                queries.push(`${name}=${value}`)
            }

            const newSearch = queries.join('&');
            window.history.pushState("", "", `?${newSearch}`);
            var url = window.location.href;
            filter_modir(url);
        }

        function filter_modir(url) {

            Swal.fire({
                title: 'صبر کنید...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            $.ajax({
                url: url
            }).done(function (data) {
                $('.modirs').html('');
                $('.modirs').html(data);
                swal.close();
            }).fail(function () {
                swal.fire({
                    title: 'اوپس...',
                    type: 'warning',
                    text: 'خطایی رخ داد'
                });
            });
        }
    </script>


@stop

