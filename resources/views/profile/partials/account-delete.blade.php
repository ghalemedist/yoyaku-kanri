<h4 class="mt-3">
    {{ __('translation.Account Delete') }}
</h4>

<form method="post" action="{{ route('kanri.profile.destroy') }}">
@csrf
@method('delete')
    <x-input-label for="current_password" :value="__('translation.Are you sure you want to delete your account?')" />

    <x-input-label for="password" value="{{ __('translation.Password') }}" class="sr-only" />
    <x-text-input
        id="password"
        name="password"
        type="password"
        class="mt-1 block w-3/4"
    />
    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />

<div class="flex items-center gap-4">
    <button 
        class="btn btn-success"
        style="width: 160px; 
            margin: 0;
            background-color: #ff6868"
        >
        {{ __('translation.Account Delete') }}
    </button>

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
