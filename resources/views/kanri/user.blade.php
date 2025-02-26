@extends('kanri.layouts.main')

@section('content')
    <div class="page">
        <h2>{{ __('ユーザー一覧') }}
        </h2>
        <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>

        @if (session()->has('message'))
            <h3 style="color: #608600">
                {{ session('message') }}
            </h3>
        @endif
        <a href="{{ route('kanri.user.create') }}" class="btn btn-success" 
            style="width: 100px; margin: 20px; color: #fff;"
            >{{ __('translation.Add New') }}</a>
            <br/>
        <table class="">
            <tbody>
                <tr>
                    <th>{{ __('translation.Name') }}</th>
                    <th style="text-align: center;">{{ __('translation.Email Address') }}(作成日)</th>
                </tr>
               @foreach($users as $value)
               <tr class="small-font">
                <td>{{ $value->name }}</td>
                <td>{{ $value->email }}
                    ({{ $value->format_created_at }})
                </td>
               </tr>
               @endforeach
            </tbody>
        </table>
    </div>
    <style>
        table tr td {
            font-size: 1.2rem !important;
        }
    </style>
@endsection