@props(['successes'])

@if ($successes)
    <div {{ $attributes }}>
        <div class="font-medium text-green-600">
            {{ __('Complete!') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-green-600">
            @foreach ($successes as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
