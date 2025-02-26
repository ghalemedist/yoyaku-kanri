@extends('kanri.layouts.main')

@section('content')
    <div class="page">
    <h2>{{ getYoyakuType($yoyakutype_category) }}<div>（追加する）</div>
    </h2>
    <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
    <h3> 
        @include('kanri.partials.2weeks-link')
        @include('kanri.partials.60days-link')
          日の一覧を見たい場合はこちら<a href="{{ route('kanri.yoyakuuser', ['yoyakubi' => $yoyakubis->id]) }}">こちら</a><br/>
      </h3>
    </h3>
    @if (session()->has('message'))
    <div class="btn-text">
        {{ session('message') }}
    </div>
    @endif
    <div class="person">
        <form action="{{ route('kanri.yoyakuuser.confirm',['yoyakubi' => $yoyakubis->id]) }}" method="post" class="h-adr"> 
            @csrf
            @method('post') 
            @include('kanri.partials.yoyakuuser-add-form')    
            <div class="person-div">
                <div style="width:100%;">
                <input class="btn btn-success" type="submit" value="入力内容確認へ" name="btn">
                </div>
            </div>
        </form>

      </div>
    </div>

@endsection