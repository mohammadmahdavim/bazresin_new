@extends('errors::errorLayout')

@section('code', '419')
@section('title', __('Page Expired'))

@section('image')
    <div style="background-image: url({{ asset('/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('خطا! زمان بلا استفاده ماندن سیستم از حد مجاز گذشته است. لطفا صفحه را رفرش نموده و دوباره تلاش نمایید!'))
