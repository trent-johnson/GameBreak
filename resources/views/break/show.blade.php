<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Game Break') }}
        </h2>
    </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if($invitee)
                    <livewire:invite-control :break="$break" :invitee="$invitee"></livewire:invite-control>
                @endif
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-2">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="my-3">
                                <p class="text-lg">{{$break->location}} - {{ date('D M jS, g:i a',strtotime($break->event_datetime)) }}</p>
                                <p>Created by: {{ $break->user->name }}</p>
                                <p>{{ $break->notes }}</p>
                            </div>
                        </div>
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="my-3">
                                <livewire:invite-list :break="$break"></livewire:invite-list>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="my-5 font-semibold text-xl text-gray-800 text-center">
                    Available Games
                </h2>
                <p class="my-3 text-center">Vote for your favorite game to play during this Game Break.</p>
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4">
                    @forelse($break->options as $option)
                        <livewire:break-option :option_id="$option->id" :thing_id="$option->bgg_thing_id" :invitee_id="($invitee) ? $invitee->id : null" />
                    @empty
                        <p>No games have been added yet for this session.</p>
                    @endforelse
                </div>
        </div>
</x-app-layout>
