@extends('kanri.layouts.main')

@section('content')
    <div class="page">
        
    <h2>{{ getYoyakuType($yoyakutype_category) }}
    </h2>
    <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
    <h3> 
        @include('kanri.partials.60days-link')
    </h3>
    <div class="page-topbox">
        <div class="topbox-title">予約日付： {{ $yoyakubi->title }} </div>
        <div class="topbox-link">
            <a href="{{ route('kanri.yoyakuuser.add', ['yoyakubi' => $yoyakubi->id]) }}">新規予約 追加</a>
            <a href="#change" class="bg-dev02">予約状況を変更</a>
        </div>
    </div>

    @if (session()->has('message'))
    
    <div class="btn-text">
        {{ session('message') }}
    </div>
    @endif

    <div class="table-responsive">
        <table id="dataTable" class="table display">
            <thead>
                <tr>
                    <th class="text-center">予約時間</th>
                    <th class="text-center">飼い主名</th>
                    <th class="text-center no-sort">ペット名</th>
                    <th class="text-center">予約の種類</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($yoyakuUsers as $item)
                <tr>
                    <td>{{ $item->yoyakujikan->start_time_only }}</td>
                    <td><a href="{{ route('kanri.yoyakuuser.detail', ['yoyakuuser' => $item->id]) }}">
                        {{ $item->your_name }} </a>{{ ($item->yoyakujikan->is_premium > 0)?'プレミアム':'' }}
                        @if($item->yoyaku_status == 0)
                        {!! $item->format_yoyaku_status !!}
                        @endif
                       </td>
                       <td>{{ $item->pet_name }}</td>
                       <td>{{ $item->yoyakutype->title }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <hr id="change" class="mt-5">
    <h3 >
        予約がない場合に限り、変更が可能です。
    </h3>
    <div class="table mt-5">
        <table class="table">
            <tr>
                <th>時間</th>
                <th>予約状況</th>
                <th>アクション</th>
            </tr>
            <tr>
                <td>全日</td>
                <td></td>
                <td class="off">
                    <a href="{{ route('kanri.yoyakubi.change.status', ['yoyakubi' => $yoyakubi->id,
                        'is_active' => '1']) }}" class="btn btn-success">一括で可に変更</a><br>
                <a href="{{ route('kanri.yoyakubi.change.status', ['yoyakubi' => $yoyakubi->id,
                    'is_active' => '0']) }}" class="btn btn-danger">一括で不可に変更</a>
                </td>
            </tr>
            @foreach($yoyakubi->yoyakujikan as $jikans)
            <tr>
                <td>
                        {{ $jikans->start_time_only }} {{ ($jikans->is_premium > 0)?'プレミアム':'' }}
                </td>
                <td>
                    
                    @if(count($jikans->yoyakuuser) > 0)
                    <span class="text-danger">予約不可</span>
                    @else
                        @if($jikans->is_active == '0')
                        <span class="text-danger">予約不可</span>
                        @else
                        <span>予約可</span>
                        @endif
                    @endif
                </td>
                <td>
                    @if(count($jikans->yoyakuuser) > 0)
                        <span>予約が入っています</span>
                    @else
                        @if($jikans->is_active == '0')
                            <a href="{{ route('kanri.yoyakujikan.change.status', ['yoyakujikan' => $jikans->id,
                            'is_active' => '1']) }}" class="btn btn-success">可に変更</a>
                        @else
                            <a href="{{ route('kanri.yoyakujikan.change.status', ['yoyakujikan' => $jikans->id,
                                'is_active' => '0']) }}" class="btn btn-danger" style="">不可に変更</a>
                        @endif
                    @endif
                </td>

            @endforeach
        </table>
    </div>
    @include('kanri.partials._datatable')

    </div>
    <style>
        .page-topbox {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .topbox-link a{
            display: inline-block;
            background-color: var(--dev-color1);
            padding: 5px 20px;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            margin-left: 20px;
        }
        .topbox-link a:hover {
            opacity: 0.8;
        }
        .topbox-link .bg-dev02 {
            background-color: var(--dev-color2);
        }
        @media (max-width: 768px) {
            .page-topbox {
                flex-direction: column;
            }
            .topbox-link a{
                margin-top: 10px;
                margin-right: 20px;
                margin-left: 0;
            }
        }
        table tr td {
            padding: 10px;
        }
    </style>
@endsection