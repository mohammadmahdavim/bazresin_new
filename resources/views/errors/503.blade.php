@extends('errors::errorLayout')

@section('code', '503')
@section('title', __('Service Unavailable'))

@section('image')
    <div style="background-image: url({{ asset('/svg/503.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __($exception->getMessage() ?: 'متاسفیم! سامانه فعلا در حال توسعه می باشد. چند دقیقه دیگر به ما سر بزنید.'))