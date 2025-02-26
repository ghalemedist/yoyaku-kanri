@extends('kanri.layouts.main')

@section('content')
    <div class="page">
    <h2>{{ getYoyakuType($yoyakujikan->type) }}診察予約<div>（診察予約　確認）</div>
    </h2>
    <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
    {{-- <h3> 
      @include('kanri.partials.2weeks-link')
      @include('kanri.partials.60days-link')
      日の一覧を見たい場合はこちら<a href="{{ route('kanri.yoyakuuser', ['yoyakubi' => $yoyakubi->id]) }}">こちら</a><br/>
    </h3> --}}
    @if (session()->has('message'))
    <div class="btn-text">
        {{ session('message') }}
    </div>
    @endif
    <div class="user-info mt-5">
        <ul>
            <li>
              <div>予約日時</div>
              <div>{{ $yoyakubi->title }}  {{ $yoyakujikan->format_time }}
              </div>
            </li>
            <li>
                <div>予約の種類</div>
                <div>{{ $yoyakutype_title->title }}</div>
            </li>
            <li>
                <div>お名前</div>
                <div>{{ session('yoyakuuser.your_name') }}</div>
            </li>
            <li>
                <div>フリガナ</div>
                <div>{{ session('yoyakuuser.your_kana') }}</div>
            </li>
            <li>
                <div>メールアドレス</div>
                <div>{{ session('yoyakuuser.your_email') }}</div>
            </li>
            <li>
                <div>郵便番号</div>
                <div>{{ session('yoyakuuser.postal_code') }}</div>
            </li>
            <li>
                <div>住所</div>
                <div>{{ session('yoyakuuser.address_line') }}</div>
            </li>
            <li>
                <div>電話番号</div>
                <div>{{ session('yoyakuuser.tel') }}</div>
            </li>
            <li>
                <div>ペットのお名前</div>
                <div>{{ session('yoyakuuser.pet_name') }}</div>
            </li>
            <li>
                <div>ペットの種類</div>
                <div>{{ session('yoyakuuser.pet_type') }}</div>
            </li>
            <li>
                <div>ペットの年齢</div>
                <div>{{ session('yoyakuuser.pet_year') }}</div>
            </li>
            <li>
                <div>ペットの性別</div>
                <div>{{ session('yoyakuuser.pet_gender') }}</div>
            </li>
            <li>
                <div>ペットの種類詳細</div>
                <div>{{ session('yoyakuuser.pet_message') }}</div>
            </li>
            <li>
                <div>症状</div>
                <div>{{ session('yoyakuuser.pet_message2') }}</div>
            </li>
            <li>
                <div>既往歴</div>
                <div>{{ session('yoyakuuser.pet_message3') }}</div>
            </li>
            <li>
                <div>現在使用している薬</div>
                <div>{{ session('yoyakuuser.pet_message4') }}</div>
            </li>
            <li>
                <div>ご要望・その他</div>
                <div>{{ session('yoyakuuser.pet_message5') }}</div>
            </li>
            
        </ul>
        
        
        <form action="{{ route('kanri.yoyakuuser.store',['yoyakubi' => $yoyakubi->id ])}}" method="post">
            @csrf
            @method('post') 
            <input type="hidden" name="yoyakujikan_id" value="{{ $yoyakujikan->id }}">
            <input type="hidden" name="type" value="{{ session('yoyakuuser.type') }}">
            <input type="hidden" name="your_name" value="{{ session('yoyakuuser.your_name') }}">
            <input type="hidden" name="your_kana" value="{{ session('yoyakuuser.your_kana') }}">
            <input type="hidden" name="your_email" value="{{ session('yoyakuuser.your_email') }}">
            <input type="hidden" name="postal_code" value="{{ session('yoyakuuser.postal_code') }}">
            <input type="hidden" name="address_line" value="{{ session('yoyakuuser.address_line') }}">
            <input type="hidden" name="tel" value="{{ session('yoyakuuser.tel') }}">
            <input type="hidden" name="pet_name" value="{{ session('yoyakuuser.pet_name') }}">
            <input type="hidden" name="pet_type" value="{{ session('yoyakuuser.pet_type') }}">
            <input type="hidden" name="pet_year" value="{{ session('yoyakuuser.pet_year') }}">
            <input type="hidden" name="pet_gender" value="{{ session('yoyakuuser.pet_gender') }}">
            <input type="hidden" name="pet_message" value="{{ session('yoyakuuser.pet_message') }}">
            <input type="hidden" name="pet_message2" value="{{ session('yoyakuuser.pet_message2') }}">
            <input type="hidden" name="pet_message3" value="{{ session('yoyakuuser.pet_message3') }}">
            <input type="hidden" name="pet_message4" value="{{ session('yoyakuuser.pet_message4') }}">
            <input type="hidden" name="pet_message5" value="{{ session('yoyakuuser.pet_message5') }}">
            <input type="hidden" name="jikan_type" value="{{ $yoyakujikan->type }}">

            <div class="mt-2">
        <a href="{{ url()->previous() }}" class="btn btn-danger mt-3" style="width: 200px; padding: 10px 0;">前のページに戻る</a>
            
        <button type="submit" class="btn btn-success mt-3" value="" style="width: 200px; padding: 10px 0;">予約する</button>
        </form>
            </div>
      </div>
    </div>
@endsection