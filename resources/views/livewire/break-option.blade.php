<div class="max-w-sm rounded overflow-hidden shadow-sm mx-auto relative">
    @if($option->votes->count())
    <span class="flex md:absolute top-0 right-0 mt-1 mr-1">
        <span class="text-green-800 font-bold mr-2 px-2.5 py-0.5 rounded-full">
            {{ $option->votes->count() }}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block fill-green-700" style="margin-top:-7px" viewBox="0 0 20 20" fill="currentColor">
              <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
            </svg>
        </span>
    </span>
    @endif
    <div class="grid grid-cols-2 md:grid-cols-1">
        <div>
            <img class="mx-auto rounded md:rounded-full shadow-xl object-contain h-32 w-32" src="{{ $game['thumbnail'] }}" />
        </div>
        <div>
            <p class="text-center text-ellipsis object-contain">{{(count($game['name']) > 1) ? $game['name'][0]['@attributes']['value'] : $game['name']['@attributes']['value']}}</p>
            <div class="flex flex-wrap gap-4 my-3 mx-auto">
                <div class="flex-auto bg-slate-300 rounded text-gray-500  px-2 py-1 text-sm mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    {{$game['minplayers']['@attributes']['value']}} - {{$game['maxplayers']['@attributes']['value']}}</div>
                <div class="flex-auto bg-slate-300 rounded text-gray-500  px-2 py-1 text-sm mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    {{(array_key_exists('playingtime',$game)) ? $game['playingtime']['@attributes']['value'] . 'm' : 'N/A' }}</div>
                <div class="flex-auto bg-slate-300 rounded text-gray-500  px-2 py-1 text-sm mb-2">
                    <a href="#" data-modal-toggle="{{ $thing_id }}-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg> Details</a>

                    <div id="{{ $thing_id }}-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow">
                                <!-- Modal header -->
                                <div class="flex justify-between items-start p-4 rounded-t border-b ">
                                    <h3 class="text-xl font-semibold text-gray-900 ">
                                        {{(count($game['name']) > 1) ? $game['name'][0]['@attributes']['value'] : $game['name']['@attributes']['value']}} - Details
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="{{ $thing_id }}-modal">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6 space-y-6">
                                    <p class="text-base leading-relaxed text-gray-500">
                                        {!! $game['description'] !!}
                                    </p>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200">
                                    <a href="#" data-modal-toggle="{{ $thing_id }}-modal" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">Close</a>
                                    <a href="https://boardgamegeek.com/boardgame/{{ $thing_id }}" target="_blank" class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">View More Details</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="popover-{{ $thing_id }}-details" role="tooltip" class="inline-block absolute invisible z-10 w-64 text-sm font-light text-gray-500 bg-white rounded-lg border border-gray-200 shadow-sm opacity-0 transition-opacity duration-300 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                        <div class="py-2 px-3 bg-gray-100 rounded-t-lg border-b border-gray-200 dark:border-gray-600 dark:bg-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Description</h3>
                        </div>
                        <div class="py-2 px-3">
                            <p>{{ Str::limit($game['description'],150,'...') }}</p>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                </div>

            </div>
            @if($can_vote)
                <div class="w-auto">
                    <x-loader-animation></x-loader-animation>
                    <div wire:loading.remove>
                        <x-vote :invitee_id="$invitee_id" :disabled="$disabled" :vote_status="$vote_status" >
                            {{ $vote_cta }}
                        </x-vote>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
