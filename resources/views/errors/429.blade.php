@extends('errors::errorLayout')

@section('code', '429')
@section('title', __('Too Many Requests'))

@section('image')
    <div style="background-image: url({{ asset('/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('متاسفیم! تعداد درخواست های ارسالی شما به سرور بیش از حد مجاز است، لطفا بعد از چند دقیقه دوباره تلاش نمایید.'))
