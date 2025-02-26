@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'red2']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
