@extends('kanri.layouts.main')

@section('content')
    <div class="page">
    <h2>{{ $yoyakuuser->yoyakujikan->yoyaku_type }}<div>（{{ $yoyakuuser->your_name }}　様）</div>
    </h2>
    <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
    <h3> 
        @include('kanri.partials.2weeks-link')
        @include('kanri.partials.60days-link')
          日の一覧を見たい場合はこちら<a href="{{ route('kanri.yoyakuuser', ['yoyakubi' => $yoyakuuser->yoyakujikan->yoyakubi_id]) }}">こちら</a><br/>
      </h3>
    </h3>
    <div class="red2 mt-5" style="text-align:center;">
       
    </div>
    @if (session()->has('message'))
    <div class="btn-text">
        {{ session('message') }}
    </div>
    @endif
    <div class="person">
        <form action="{{ route('kanri.yoyakuuser.update',['yoyakuuser' => $yoyakuuser->id]) }}" method="post" class="h-adr"> 
            @csrf
            @method('put') 
            @include('kanri.partials.yoyakuuser-form')    
        </form>

      </div>
    </div>

@endsection