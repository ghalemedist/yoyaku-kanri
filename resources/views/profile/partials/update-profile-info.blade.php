<h4 class="mt-3">
    {{ __('translation.Profile Information') }}
</h4>

<form method="post" action="{{ route('kanri.profile.update') }}">
@csrf
@method('patch')
    <x-input-label for="name" :value="__('translation.Name')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />

    <x-input-label for="email" :value="__('translation.Email Address')" />
    <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
    <x-input-error class="mt-2" :messages="$errors->get('email')" />
<div class="flex items-center gap-4">
    <button class="btn btn-success" type="submit" 
        style="width: 150px; margin: 0;"
        >
        {{ __('translation.Update') }}</button>

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
</form>
