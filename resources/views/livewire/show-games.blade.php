<div>
    <div class="my-5 md:flex md:flex-wrap md:gap-4">
        <!-- Sorting Buttons -->
        @foreach($sort_options as $option)
            <button
                class="rounded-full flex-none hover:bg-blue-500 text-white py-2 px-4 {{($sort == $option['id']) ? 'bg-blue-400' : 'bg-slate-400'}}" wire:click.prevent="sort('{{$option['id']}}')">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 inline-block transition-all {{($sort == $option['id'] && $sort_asc == true) ? '' : 'rotate-180' }}"
                     viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                </svg>
                Sort By {{ $option['name'] }}
            </button>
        @endforeach
        <!-- Player SLIDER -->
        <div class="w-full md:w-1/4 px-5">
            <div class="text-center">Player Count</div>
            <div x-data="range()" x-init="mintrigger(); maxtrigger()" class="relative w-full">
                <div>
                    <input type="range"
                           step="1"
                           x-bind:min="min" x-bind:max="max"
                           x-on:input="mintrigger"
                           x-model="minprice"
                           wire:model="min_players"
                           class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                    <input type="range"
                           step="1"
                           x-bind:min="min" x-bind:max="max"
                           x-on:input="maxtrigger"
                           x-model="maxprice"
                           wire:model="max_players"
                           class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                    <div class="relative z-10 h-2">

                        <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>

                        <div class="absolute z-20 top-0 bottom-0 rounded-md bg-blue-400" x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                        <div class="absolute z-30 w-6 h-6 top-0 left-0 bg-blue-400 rounded-full -mt-2 -ml-1" x-bind:style="'left: '+minthumb+'%'"></div>

                        <div class="absolute z-30 w-6 h-6 top-0 right-0 bg-blue-400 rounded-full -mt-2 -mr-3" x-bind:style="'right: '+maxthumb+'%'"></div>

                    </div>

                </div>

                <div class="flex justify-between items-center py-5">
                    <div>
                        <input type="text" maxlength="5" x-on:input="mintrigger" x-model="minprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                    </div>
                    <div>
                        <input type="text" maxlength="5" x-on:input="maxtrigger" x-model="maxprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                    </div>
                </div>

            </div>
        </div>

        <!-- Time SLIDER -->
        <div class="w-full md:w-1/4 px-5">
            <div class="text-center">Playtime</div>
            <div x-data="timerange()" x-init="mintrigger(); maxtrigger()" class="relative w-full">
                <div>
                    <input type="range"
                           step="15"
                           x-bind:min="min" x-bind:max="max"
                           x-on:input="mintrigger"
                           x-model="minprice"
                           wire:model="min_time"
                           class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                    <input type="range"
                           step="15"
                           x-bind:min="min" x-bind:max="max"
                           x-on:input="maxtrigger"
                           x-model="maxprice"
                           wire:model="max_time"
                           class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                    <div class="relative z-10 h-2">

                        <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>

                        <div class="absolute z-20 top-0 bottom-0 rounded-md bg-blue-400" x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                        <div class="absolute z-30 w-6 h-6 top-0 left-0 bg-blue-400 rounded-full -mt-2 -ml-1" x-bind:style="'left: '+minthumb+'%'"></div>

                        <div class="absolute z-30 w-6 h-6 top-0 right-0 bg-blue-400 rounded-full -mt-2 -mr-3" x-bind:style="'right: '+maxthumb+'%'"></div>

                    </div>

                </div>

                <div class="flex justify-between items-center py-5">
                    <div>
                        <input type="text" maxlength="5" x-on:input="mintrigger" x-model="minprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                    </div>
                    <div>
                        <input type="text" maxlength="5" x-on:input="maxtrigger" x-model="maxprice" class="px-3 py-2 border border-gray-200 rounded w-24 text-center">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="my-5">
        <input
            type="search"
            class="shadow appearance-none border border-gray-400 rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
            name="search_text"
            placeholder="Search..."
            wire:model="search_string"
        />
    </div>

    <!-- Refresh Loader -->
    <div wire:loading class="mx-auto text-center">
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    <!-- Game Grid -->
    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-4" wire:loading.remove>
        @foreach($games as $game)
            @if($break)
              <div>
                <input type="checkbox" id="{{ $game['@attributes']['objectid']}}_option" name="game_options[]" value="{{ $game['@attributes']['objectid']}}" class="hidden peer">
                <label for="{{ $game['@attributes']['objectid']}}_option" class="inline-flex justify-between items-center p-5 w-full rounded-lg border-2 border-gray-200 cursor-pointer peer-checked:border-blue-600 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50 peer-checked:bg-gray-50 ">
            @endif
            <div class="max-w-sm rounded  overflow-hidden shadow-sm mx-auto relative">
                @if(intval($game['stats']['rating']['@attributes']['value']) >= 7)
                    <span class="flex md:absolute h-10 w-10 top-0 right-0 mt-1 mr-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ (intval($game['stats']['rating']['@attributes']['value']) >= 9) ? 'fill-amber-400' : 'fill-amber-900'}}" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </span>
                @endif
                <p class="text-center text-ellipsis object-contain pb-2">{{$game['name']}}</p>
                <div class="grid grid-cols-2 md:grid-cols-1">
                   <div>
                       <img class="mx-auto rounded md:rounded-full shadow-xl object-contain h-32 w-32" src="{{ $game['thumbnail'] }}" />
                   </div>
                    <div class="flex flex-wrap gap-4 my-3 mx-auto">
                        <div class="flex-auto bg-slate-300 rounded text-gray-500  px-2 py-1 text-sm mb-2">Plays: {{$game['numplays']}}</div>
                        <div class="flex-auto bg-slate-300 rounded text-gray-500  px-2 py-1 text-sm mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            {{$game['stats']['@attributes']['minplayers']}} - {{$game['stats']['@attributes']['maxplayers']}}</div>
                        <div class="flex-auto bg-slate-300 rounded text-gray-500  px-2 py-1 text-sm mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            {{(array_key_exists('playingtime',$game['stats']['@attributes'])) ? $game['stats']['@attributes']['playingtime'] . 'm' : 'N/A' }}</div>
                        <div class="flex-auto bg-slate-300 rounded text-gray-500  px-2 py-1 text-sm mb-2">
                            <a href="https://boardgamegeek.com/boardgame/{{ $game['@attributes']['objectid'] }}" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg></a>
                        </div>
                    </div>
                </div>

            </div>
            @if($break)
                </label>
              </div>
            @endif
        @endforeach
    </div>
        <script>
            function range() {
                return {
                    minprice: 2,
                    maxprice: 5,
                    min: 1,
                    max: 8,
                    minthumb: 2,
                    maxthumb: 5,

                    mintrigger() {
                        this.minprice = Math.min(this.minprice, this.maxprice - 1);
                        this.minthumb = ((this.minprice - this.min) / (this.max - this.min)) * 100;
                    },

                    maxtrigger() {
                        this.maxprice = Math.max(this.maxprice, this.minprice + 1);
                        this.maxthumb = 100 - (((this.maxprice - this.min) / (this.max - this.min)) * 100);
                    },
                }
            }

            function timerange() {
                return {
                    minprice: 15,
                    maxprice: 360,
                    min: 15,
                    max: 360,
                    minthumb: 0,
                    maxthumb: 0,

                    mintrigger() {
                        this.minprice = Math.min(this.minprice, this.maxprice - 15);
                        this.minthumb = ((this.minprice - this.min) / (this.max - this.min)) * 100;
                    },

                    maxtrigger() {
                        this.maxprice = Math.max(this.maxprice, this.minprice + 15);
                        this.maxthumb = 100 - (((this.maxprice - this.min) / (this.max - this.min)) * 100);
                    },
                }
            }
        </script>
</div>
