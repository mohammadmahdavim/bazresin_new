@extends('errors::errorLayout')

@section('code', '403')
@section('title', __('Unauthorized'))

@section('image')
    <div style="background-image: url({{ asset('/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('متأسفیم! شما دسترسی لازم را ندارید'))
