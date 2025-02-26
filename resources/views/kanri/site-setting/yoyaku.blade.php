@extends('kanri.layouts.main')

@section('content')
    <div class="page">
    <h2>イベント予約設定
    </h2>
    <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
    @if (session()->has('message'))
    <div class="btn-text">
        {{ session('message') }}
    </div>
    @endif
    <div class="person">
        
       <div id="app"></div>

      </div>
    </div>

@endsection