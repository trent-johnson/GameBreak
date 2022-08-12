<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <p class="font-medium text-lg">{{ $username }} - Game Collection</p>
        </h2>
    </x-slot>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:show-games :username="$username" />
        </div>
    </div>
</x-app-layout>
