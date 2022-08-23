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
                    @if(auth()->user()->bgg_user)
                        <p>Ready to play some games?</p>
                        <div class="py-5">
                            <x-link-button href="/break/new">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg> Create New Game Break
                            </x-link-button>
                        </div>
                    @else
                        <p>Looking to create a new Game Break? You'll need to link your BGG Profile.</p>
                        <div class="py-5">
                            <x-link-button :href="route('profile', ['user' => auth()->user()->id])">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg> Link BGG Profile
                            </x-link-button>
                        </div>
                    @endif
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg">Upcoming Game Breaks</h3>
                    @forelse($breaks->where('event_datetime', '>=', date('Y-m-d'))->sortBy('event_datetime') as $break)
                        <div class="border-b border-gray-200 my-2 py-2 flex gap-4">
                            <div class="flex-auto">
                                {{ date('D M jS, g:i a',strtotime($break->event_datetime)) }} - {{ $break->location }}
                            </div>
                            <div class="flex-none mx-2 px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg> {{ $break->invitees()->count() }}
                            </div>
                            <div class="flex-none mx-2 px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                </svg> {{ $break->invitees()->where('status',0)->count() }}
                            </div>
                            <div class="flex-none mx-2 px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg> {{ $break->invitees()->where('status',1)->count() }}
                            </div>
                            <div class="flex-none mx-2 px-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg> {{ $break->invitees()->where('status',2)->count() }}
                            </div>
                            <div class="flex-none">
                                <a href="/break/{{ $break->id }}" class="inline-block bg-gray-400 hover:bg-gray-300 rounded px-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg> View
                                </a>
                            </div>
                            <div class="flex-none">
                                <form method="POST" action="/break/{{ $break->id }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" @click="confirm('Are you sure you want to delete this Game Break?')" class="inline-block bg-red-600 hover:bg-red-500 text-white rounded px-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        No Upcoming Game Breaks Found
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
