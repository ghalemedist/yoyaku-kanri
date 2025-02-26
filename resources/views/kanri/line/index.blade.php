@extends('kanri.layouts.main')

@section('content')
    <div class="page">
    <h2>LINE ともだち<div>あおい動物病院</div>
    </h2>
    <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
    
    @if (session()->has('message'))
    <div class="btn-text">
        {{ session('message') }}
    </div>
    @endif
    <div id="app"></div>
    
    </div>

@endsection