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
                                <p class="text-lg pb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>{{$break->location}}</p>
                                <p class="text-lg pb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>{{ date('D M jS, g:i a',strtotime($break->event_datetime)) }}</p>
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
