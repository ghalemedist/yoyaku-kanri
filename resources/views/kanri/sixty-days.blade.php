@extends('kanri.layouts.main')

@section('content')
    <div class="page">
    <h2>診察予約<div>（ 今日～{{ $yoyakubi->last()->title }} ）</div>
    </h2>
    <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
    <h3> {{-- 本日から2週間の予定を見たい場合は
         <a href="{{ route('kanri.yoyaku.dashboard') }}">こちら</a><br/> --}}
        日付の詳細画面を見たい場合は以下の日付をクリックしてください。<br/>
        色がついている日は予約が入っています。<br>
    </h3>
    <table class="d60 mt-4">
        <tbody>
            @foreach($yoyakubi as $key => $item)
            @if($key == 0 || $key % 5 == 0)
            <tr>
            @endif
            @php 
            $totalusers = countUsersByYoyakubiId($item->id);
            if($totalusers > 0){
                $class= 'off';
            }else if(countActiveYoyakujikanByYoyakubiId($item->id) > 0){
                $class = '';
            }else{
                $class = 'on';
            }
            @endphp
                <td class="{{ $class }}">
                    <a href="{{ route('kanri.yoyakuuser', ['yoyakubi' => $item->id, 'type' => 1]) }}">{{ date_create($item->date)->format('m/d') }}<br/>
                        ({{ getWeekDayName(date_create($item->date)->format('w'), 'title') }}) </a>
                </td>
            @if($key != 0 && ($key + 1) % 5 == 0)
            </tr>
            @endif
            @endforeach
            
        </tbody>
    </table>
    </div>
@endsection