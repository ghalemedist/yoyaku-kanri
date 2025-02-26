<h4 class="mt-3">
    {{ __('translation.Update Password') }}
</h4>

<form method="post" action="{{ route('kanri.password.update') }}" class="mt-6 space-y-6">
@csrf
@method('put')
<div>
    <x-input-label for="current_password" :value="__('translation.Current Password')" />
    <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" required/>
    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
</div>

<div>
    <x-input-label for="password" :value="__('translation.New Password')" />
    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" required/>
    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
</div>

<div>
    <x-input-label for="password_confirmation" :value="__('translation.Confirm Password')" />
    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" required/>
    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
</div>

<div class="flex items-center gap-4">
    <button 
        class="btn btn-success"
        style="width: 150px; margin: 0;"
        >{{ __('translation.Update') }}</button>

    @if (session('status') === 'password-updated')
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600"
        >{{ __('translation.Updated') }}</p>
    @endif
</div>
</form>
