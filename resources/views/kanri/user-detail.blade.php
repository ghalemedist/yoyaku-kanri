@extends('kanri.layouts.main')

@section('content')
    <div class="page">
      
    <h2>{{ $yoyakuuser->yoyakujikan->yoyaku_type }}<div>（{{ $yoyakuuser->your_name }}　様）</div>
    </h2>
    <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
    <div class="page-topbox">
      <div class="topbox-title">予約者情報 </div>
  </div>
    <h3> 
      
      {{-- @include('kanri.partials.2weeks-link') --}}
      {{-- @include('kanri.partials.60days-link') --}}
        {{-- 日の一覧を見たい場合はこちら<a href="{{ route('kanri.yoyakuuser', ['yoyakubi' => $yoyakuuser->yoyakujikan->yoyakubi_id, 'type' => 2]) }}">こちら</a><br/> --}}
    </h3>
    <!-- <div class="red2" style="text-align:center;">
        ※ 他の予約がある場合は上書きされてしまいますので、
        <br>日付を変更する際にはお気をつけください。
    </div> -->
    @if (session()->has('message'))
    <div class="btn-text">
        {{ session('message') }}
    </div>
    @endif
    <div class="user-info mt-4">
      <ul>
        <li>
          <div>予約日時</div>
          <div><a href="{{ route('kanri.yoyakuuser', ['yoyakubi' => $yoyakuuser->yoyakujikan->yoyakubi_id, 'type' => 2]) }}">
            {{ $yoyakuuser->yoyakujikan->yoyakubi->title }}
            {{ $yoyakuuser->yoyakujikan->format_time }}</a>
          </div>
        </li>
        <li>
          <div>予約の種類</div>
          <div>{{ $yoyakuuser->yoyakutype->title }}</div>
        </li>
        <li>
          <div>お名前</div>
          <div>{{ $yoyakuuser->your_name }}</div>
        </li>
        <li>
          <div>フリガナ</div>
          <div>{{ $yoyakuuser->your_kana }}</div>
        </li>
        <li>
          <div>メールアドレス</div>
          <div>{{ $yoyakuuser->your_email }}</div>
        </li>
        <li>
          <div>郵便番号</div>
          <div>{{ $yoyakuuser->postal_code }}</div>
        </li>
        <li>
          <div>住所</div>
          <div>{{ $yoyakuuser->address_line }}</div>
        </li>
        <li>
          <div>電話番号</div>
          <div>{{ $yoyakuuser->tel }}</div>
        </li>
        <li>
          <div>ペットの種類</div>
          <div>{{ $yoyakuuser->pet_type }}</div>
        </li>
        <li>
          <div>ペットのお名前</div>
          <div>{{ $yoyakuuser->pet_name }}</div>
        </li>
        <li>
          <div>ペットの年齢</div>
          <div>{{ $yoyakuuser->pet_year }}</div>
        </li>
        <li>
          <div>ペットの性別</div>
          <div>{{ $yoyakuuser->pet_gender }}</div>
        </li>
        <li>
          <div>ペットの種類詳細</div>
          <div>{{ $yoyakuuser->pet_message }}</div>
        </li>

        <li>
          <div>症状</div>
          <div>{{ $yoyakuuser->pet_message2 }}</div>
        </li>
        <li>
          <div>既往歴</div>
          <div>{{ $yoyakuuser->pet_message3 }}</div>
        </li>
        <li>
          <div>現在使用している薬</div>
          <div>{{ $yoyakuuser->pet_message4 }}</div>
        </li>
        <li>
          <div>ご要望・その他</div>
          <div>{{ $yoyakuuser->pet_message5 }}</div>
        </li>

        <li>
          <div>予約ステータス</div>
          <div>{!! $yoyakuuser->format_yoyaku_status !!}</div>
        </li>
        <li>
          <div>登録日時</div>
          <div>{{ $yoyakuuser->format_created_at }}</div>
        </li>
      </ul>
    </div>
    <div class="person-div">
      <div>
        <a href="{{ route('kanri.yoyakuuser.edit', ['yoyakuuser' => $yoyakuuser->id]) }}" class="btn btn-primary">内容を修正</a>
      </div>
      <div>
        <form method="post" action="{{ route('kanri.yoyakuuser.destroy', ['yoyakuuser' => $yoyakuuser->id]) }}" id="deleteUserForm">
          @csrf
          @method('delete')
      </form>
        <a href="" class="btn isDelete">情報を削除</a>
      </div>
  </div>
    </div>
    <script>
      $(document).ready(function() {
        $('.isDelete').click(function(e) {
          e.preventDefault()
          let isDelete = confirm('削除の場合、データが戻ることができません。\n削除してもよろしいですか?');
          if(isDelete){
            $('#deleteUserForm').submit()
          }
        })
      })
    </script>
@endsection