@extends('layouts.UserLayouts')

@section('script')

    <script type="text/javascript"
            src="<?= url('assets/js/plugins/forms/selects/bootstrap_select.min.js'); ?>"></script>

    <script type="text/javascript" src="<?= url('assets/js/pages/form_bootstrap_select.js'); ?>"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/inputs/touchspin.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/form_input_groups.js')}}"></script>

    <meta name="_token" content="{{csrf_token()}}">

    <script>
        $(document).ready(function () {

            function fetch_customer_data(query) {
                Pace.ignore(function(){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{url('/user/leader/poshtibanSearchAjax')}}",
                        type: 'POST',
                        data: {query: query},
                        success: function (response) {
                            $('#showTable').html('');
                            $('#showTable').html(response);
                        },
                        error: function () {

                        }
                    });
                });

            }

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                var url = new URL(window.location.href);
                var query_string = url.search;
                var search_params = new URLSearchParams(query_string);
                search_params.delete('query');
                search_params.append('query', query);
                url.search = search_params.toString();
                var new_url = url.toString();
                window.history.pushState("", "", new_url);
                fetch_customer_data(query);
            });
        });
    </script>
@stop

@section('content')

    <!-- Both borders -->
    <div class="panel panel-flat">

        <div class="panel-heading">
            <h6 class="panel-title">لیست پشتیبان ها</h6>
            <div class="heading-elements">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" id="search" @if(isset($data['query'])) value="{{$data['query']}}" @endif class="form-control" placeholder="جست و جو ...">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-info btn-icon"><i class="icon-three-bars"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /input field with button -->
        <div id="showTable">
            @include('user.include.leader.poshtiban.index', ['poshtibans' => $poshtibans])
        </div>
        <!-- /both borders -->
    </div>
@stop
