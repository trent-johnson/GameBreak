<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Game Break') }}
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('saveBreak') }}">
        @csrf
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="my-3">
                            <p class="text-lg">{{$break->location}} - {{ date('D M jS, g:i a',strtotime($break->event_datetime)) }}</p>
                        </div>
                    </div>
                </div>

                <h2 class="my-5 font-semibold text-xl text-gray-800 text-center">
                    Available Games
                </h2>
                <p class="my-3 text-center">Vote for your favorite game to play during this Game Break.</p>
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">
                    @forelse($break->options as $option)
                        <livewire:break-option :option_id="$option->id" :thing_id="$option->bgg_thing_id" />
                    @empty
                        <p>No games have been added yet for this session.</p>
                    @endforelse
                </div>
        </div>
    </form>
</x-app-layout>
