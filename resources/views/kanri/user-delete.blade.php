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
    <div class="red2" style="text-align:center;">
        ※ 以下の情報が削除されます
    </div>
    @if (session()->has('message'))
    <div class="btn-text">
        {{ session('message') }}
    </div>
    @endif
    <div class="person">
        <!--予約フォーム-->
        <h4>日時</h4>
        <p>
          {{ $yoyakuuser->yoyakujikan->yoyakubi->title }}
          {{ $yoyakuuser->yoyakujikan->format_time }}
          </p>
        <h4>予約の種類</h4>
        <p>
          {{ $yoyakuuser->type }}
        </p>
        <h4>お名前</h4>
        <p>
          {{ $yoyakuuser->your_name }}
        </p>
        <h4>フリガナ</h4>
        <p>
          {{ $yoyakuuser->your_kana }}
        </p>
        <h4>メールアドレス</h4>
        <p>
          {{ $yoyakuuser->your_email }}
         </p>
        <h4>郵便番号</h4>
        <p>
          {{ $yoyakuuser->postal_code }}        
        </p>
        <h4>住所</h4>
        <p>
          {{ $yoyakuuser->address_line }}
        </p>
        <h4>電話番号</h4>
        <p>
          {{ $yoyakuuser->tel }}
        </p>
        <h4>ペットのお名前</h4>
        <p>
          {{ $yoyakuuser->pet_name }}
         </p>
        <h4>ペットの種類</h4>
        <p>
          {{ $yoyakuuser->pet_type }}
        </p>

        <h4>ペットの種類詳細</h4>
        <p>
          {{ $yoyakuuser->pet_message }}    
        </p>

        <h4>症状</h4>
          <p>
            {{ $yoyakuuser->pet_message2 }}   
          </p>
          <h4>既往歴</h4>
          <p>
            {{ $yoyakuuser->pet_message3 }}   
          </p>
          <h4>現在使用している薬</h4>
          <p>
            {{ $yoyakuuser->pet_message4 }}   
          </p>
                <h4>ご要望・その他</h4>
        <p>
          {{ $yoyakuuser->pet_message5 }}   
        </p>

        <div class="person-div">
            <div style="width:100%;">
                <form method="post" action="{{ route('kanri.yoyakuuser.destroy', ['yoyakuuser' => $yoyakuuser->id]) }}">
                    @csrf
                    @method('delete')
                <input class="btn" type="submit" value="完全に削除する" name="btn">
                </form>
            </div>
          </div>
      </div>
    </div>
@endsection