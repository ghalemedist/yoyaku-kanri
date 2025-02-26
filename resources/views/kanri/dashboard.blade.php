@extends('kanri.layouts.main')

@section('content')
    <div class="page">
    <h2>{{ getYoyakuType(1) }}
    </h2>
    <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
    <h3> 
        @include('kanri.partials.60days-link')
        日付の詳細画面を見たい場合は以下の日付をクリックしてください。<br/>
        予約者名をクリックすると予約者の詳細が表示されます。<br>
    </h3>
    <form action="" autocomplete="off" method="GET">
        @csrf
    <div class="search-box">
        <div class="search-row">
            <div class="form-group">
                <label>日付　（スタート）</label>
                <input type="text" class="form-control start_date" 
                placeholder="" 
                name="start_date"
                value="{{ isset($_GET['start_date'])?$_GET['start_date']:'' }}" 
                >
            </div>
            <div class="form-group">
                <label>日付　（エンド）</label>
                <input type="text" 
                class="form-control end_date" 
                placeholder="" 
                name="end_date"
                value="{{ isset($_GET['end_date'])?$_GET['end_date']:'' }}" 
                >
            </div>
        </div>
        <div class="search-row">
            <div class="form-group">
                <label>予約の種類</label>
                <select name="yoyakutype_id" class="form-control">
                    <option value="">全て</option>
                    @foreach($yoyakutype as $item)
                    <option value="{{ $item->id }}" 
                    {{ isset($_GET['yoyakutype_id']) && $_GET['yoyakutype_id'] == $item->id?'selected':'' }}
                    >{{ $item->title }}</option>
                    @endforeach   
                </select>
            </div>
            <div class="form-group">
                <label></label>
                <input type="submit" class="form-control" value="検索">
            </div>
        </div>
    </div>
</form>
    
    
    <div class="table-responsive">
        <table id="dataTable" class="table display">
            <thead>
                <tr>
                    <th class="text-center">予約日</th>
                    <th class="text-center">予約時間</th>
                    <th class="text-center no-sort">飼い主名</th>
                    <th class="text-center">予約の種類</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($yoyakuUsers as $item)
                <tr>
                    <td>
                        <a href="{{ route('kanri.yoyakuuser', ['yoyakubi' => $item->yoyakubi_id]) }}"><b>{{ $item->title }}</b></a>
                    </td>
                    <td>{{ $item->yoyakujikan->format_time }}</td>
                    <td><a href="{{ route('kanri.yoyakuuser.detail', ['yoyakuuser' => $item->id]) }}">
                        {{ $item->your_name }}</a>
                        @if($item->yoyaku_status == 0)
                        {!! $item->format_yoyaku_status !!}
                        @endif
                       </td>
                       <td>{{ $item->yoyakutype->title }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

{{-- <script src="https://rawgit.com/jquery/jquery-ui/master/ui/i18n/datepicker-ja.js"></script> --}}

@include('kanri.partials._datatable')

<style>
    .search-box {
        display: flex;
        justify-content: space-between;
        border: 1px solid #ccc;
        padding: 10px;
        margin: 20px 0;
        flex-wrap: wrap;
    }
    .search-row {
        width: 49%;
        display: flex;
        justify-content: space-between;
    }
    .search-row .form-group {
        width: 48%;
    }
    #ui-datepicker-div {
        font-size: 1.5rem;
    }
    @media (max-width: 768px) {
        .search-row {
            width: 100%;
            flex-wrap: wrap;
        }   
        .search-row .form-group {
            width: 100%;
        }
        #ui-datepicker-div {
            width: 350px;
        }
    }
    
</style>

<script>
    $(".start_date").datepicker({
        language: 'ja',
        dateFormat: "yy/mm/dd", 
        closeText: "閉じる",
        prevText: "前",
        nextText: "次",
        currentText: "今日",
        monthNames: [ "1月", "2月", "3月", "4月", "5月", "6月",
        "7月", "8月", "9月", "10月", "11月", "12月" ],
        monthNamesShort: [ "1月", "2月", "3月", "4月", "5月", "6月",
        "7月", "8月", "9月", "10月", "11月", "12月" ],
        dayNames: [ "日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日" ],
        dayNamesShort: [ "日", "月", "火", "水", "木", "金", "土" ],
        dayNamesMin: [ "日", "月", "火", "水", "木", "金", "土" ],
        weekHeader: "週",
        isRTL: false,
        showMonthAfterYear: true,
        yearSuffix: "年",
        showButtonPanel:  false,
        beforeShowDay: function (date) {
            setTimeout(function () {
            $("#ui-datepicker-div").find(".ui-state-active").removeClass("ui-state-active");
            },100);
              return [true, '', ''];
            },
            language: 'ja',
            showButtonPanel:  false,
            onSelect: function(date){

            var selectedDate = new Date(date);
            var endDate = new Date(selectedDate.getTime());

            $(".end_date").datepicker( "option", "minDate", endDate );

            }
        });


    $(".end_date").datepicker({
        language: 'ja',
        dateFormat: "yy/mm/dd", 
        closeText: "閉じる",
        prevText: "前",
        nextText: "次",
        currentText: "今日",
        monthNames: [ "1月", "2月", "3月", "4月", "5月", "6月",
        "7月", "8月", "9月", "10月", "11月", "12月" ],
        monthNamesShort: [ "1月", "2月", "3月", "4月", "5月", "6月",
        "7月", "8月", "9月", "10月", "11月", "12月" ],
        dayNames: [ "日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日" ],
        dayNamesShort: [ "日", "月", "火", "水", "木", "金", "土" ],
        dayNamesMin: [ "日", "月", "火", "水", "木", "金", "土" ],
        weekHeader: "週",
        isRTL: false,
        showMonthAfterYear: true,
        yearSuffix: "年",
        showButtonPanel:  false,
            onSelect: function(date){

            var selectedDate = new Date(date);
            var endDate = new Date(selectedDate.getTime());

            //Set Minimum Date of EndDatePicker After Selected Date of StartDatePicker
            $(".start_date").datepicker( "option", "maxDate", endDate );

            }
        });

</script>
@endsection
