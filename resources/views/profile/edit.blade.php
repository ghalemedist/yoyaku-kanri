@extends('kanri.layouts.main')
@section('content')    
    <div class="page">
        <h2>{{ __('translation.Profile') }}更新
            <div>{{ Auth::user()->name }}</div>
        </h2>
        <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
        <div class="person">
            @include('profile.partials.update-profile-info')
            @include('profile.partials.update-password')
            {{-- @include('profile.partials.account-delete') --}}
        </div>
        
    </div>
@endsection
    

