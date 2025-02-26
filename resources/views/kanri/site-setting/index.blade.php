@extends('kanri.layouts.main')

@section('content')
    <div class="page">
    <h2>サイト設定
    </h2>
    <div class="h2"><img src="{{ asset('css/img/page/h1.svg') }}"></div>
    @if (session()->has('message'))
    <div class="btn-text">
        {{ session('message') }}
    </div>
    @endif
    <div class="person">
        <br/>
        <form action="{{ route('kanri.site-setting.update') }}" method="post" class="h-adr"> 
            @csrf
            @method('patch')
            <h4>予約システム  WEB URL</h4>
            <x-text-input 
                name="yoyaku_url" 
                type="text" 
                :value="old('yoyaku_url', $data->yoyaku_url)" 
                />
            <x-input-error class="mt-2" :messages="$errors->get('yoyaku_url')" /> 
            <h2>Mail Setting</h2>
            <h4>Mail Mailer</h4>
            <x-text-input 
                name="mail_mailer" 
                type="text" 
                :value="old('mail_mailer', $data->mail_mailer)" 
                />
            <x-input-error class="mt-2" :messages="$errors->get('mail_mailer')" /> 
                <h4>Mail Host</h4>
                <x-text-input 
                    name="mail_host" 
                    type="text" 
                    :value="old('mail_host', $data->mail_host)" 
                    />
                <x-input-error class="mt-2" :messages="$errors->get('mail_host')" /> 
                
                    <h4>Mail Port</h4>
            <x-text-input 
                name="mail_port" 
                type="text" 
                :value="old('mail_port', $data->mail_port)" 
                />
            <x-input-error class="mt-2" :messages="$errors->get('mail_port')" /> 
                
                <h4>Mail Encryption</h4>
            <x-text-input 
                name="mail_encryption" 
                type="text" 
                :value="old('mail_encryption', $data->mail_encryption)" 
                />
            <x-input-error class="mt-2" :messages="$errors->get('mail_encryption')" /> 
                
            <h4>Mail Username</h4>
            <x-text-input 
                name="mail_username" 
                type="text" 
                :value="old('mail_username', $data->mail_username)" 
                />
            <x-input-error class="mt-2" :messages="$errors->get('mail_username')" /> 
                
            <h4>Mail Password</h4>
            <x-text-input 
                name="mail_password" 
                type="password" 
                :value="old('mail_password', $data->mail_password)" 
                /> 
            <x-input-error class="mt-2" :messages="$errors->get('mail_password')" />  
            <h2 style="margin-top: 20px;">LINE Messaging API Setting</h2>
            <h4>Channel ID</h4>
            <x-text-input 
                name="channel_id" 
                type="text" 
                :value="old('channel_id', $data->channel_id)" 
                />
            <x-input-error class="mt-2" :messages="$errors->get('channel_id')" /> 

            <h4>Channel Secret</h4>
            <x-text-input 
                name="channel_secret" 
                type="text" 
                :value="old('channel_secret', $data->channel_secret)" 
                />
            <x-input-error class="mt-2" :messages="$errors->get('channel_secret')" /> 
                <h4>Channel Token</h4>
                <textarea name="channel_token">{{ old('channel_token', $data->channel_token) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('channel_token')" /> 

            <h2 style="margin-top: 20px;">LINE LIFF Setting</h2>
            <p style="line-height: 2rem; font-size: 12px;">LIFFアプリをチャネルに追加するときに、profileとopenidスコープを選択してください。
                スコープの選択は、LIFFアプリ追加後もLINE DevelopersコンソールのLIFFタブで変更できます。</p>

            <h4>LIFF Channel ID</h4>
            <x-text-input 
                name="liff_channel_id" 
                type="text" 
                :value="old('liff_channel_id', $data->liff_channel_id)" 
                />
            <x-input-error class="mt-2" :messages="$errors->get('liff_channel_id')" /> 
          
            <h4>LIFF ID　予約システム</h4>
            <x-text-input 
                name="liffId" 
                type="text" 
                :value="old('liffId', $data->liffId)" 
                />
            <x-input-error class="mt-2" :messages="$errors->get('liffId')" /> 
                  
            {{-- <h4>LIFF ID 順番待ち</h4>
                <x-text-input 
                    name="liffId_waiting" 
                    type="text" 
                    :value="old('liffId_waiting', $data->liffId_waiting)" 
                    />
                <x-input-error class="mt-2" :messages="$errors->get('liffId_waiting')" /> 
     --}}
            <div class="person-div">
                <div style="width:100%;">
                <input class="btn" type="submit" value="確認" name="btn">
                </div>
            </div>
        </form>

      </div>
    </div>

@endsection