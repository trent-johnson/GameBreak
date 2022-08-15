<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Game Breaks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>Ready to play some games?</p>
                    <div class="py-5">
                        <x-link-button href="/break/new">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg> Create New Game Break
                        </x-link-button>
                    </div>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    @forelse($breaks as $break)
                        {{ date('D M jS, g:i a',strtotime($break->event_datetime)) }} - {{ $break->location }}
                    @empty
                        No Upcoming Game Breaks Found
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
