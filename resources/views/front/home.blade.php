@extends('app')

@section('title', 'Home')

@section('content')
    @include('front.elements.header')
    home
    @if(session('success'))
        {{ session()->get('success') }}
    @endif
@endsection
