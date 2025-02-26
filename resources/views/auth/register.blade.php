@extends('kanri.layouts.main')
@section('content')    
    <div class="page">
        <h2>{{ __('translation.User Register') }}
        </h2>
        <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
            <div class="person">
            <form method="post" action="{{ route('kanri.user.store') }}">
            @csrf
            @method('post')
            <h4>{{ __('translation.Name') }}</h4>
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" />

                    <h4>{{ __('translation.Email Address') }}</h4>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" />
                    
                    <h4>{{ __('translation.Password') }}</h4>
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')"/>

                <h4>{{ __('translation.Confirm Password') }}</h4>
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" />
                
                <div class="flex items-center gap-4">
                <button class="btn btn-primary" type="submit" 
                    style="width: 150px; margin: 0;"
                    >
                    {{ __('translation.Register') }}</button>
            
                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('translation.Updated') }}</p>
                @endif
            </div>
        </div>
        </form>
        
    </div>
@endsection
    

