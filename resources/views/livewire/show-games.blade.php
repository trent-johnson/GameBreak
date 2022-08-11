<div>
    <div class="my-5">
        @foreach($sort_options as $option)
            <button
                class="rounded-full hover:bg-blue-500 text-white py-2 px-4 {{($sort == $option['id']) ? 'bg-blue-400' : 'bg-slate-400'}}" wire:click="sort('{{$option['id']}}')">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 inline-block transition-all {{($sort == $option['id'] && $sort_asc == true) ? '' : 'rotate-180' }}"
                     viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                </svg>
                Sort By {{ $option['name'] }}
            </button>
        @endforeach
    </div>
    <div class="my-5">
        <input
            type="search"
            class="shadow appearance-none border border-gray-400 rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
            name="search_text"
            placeholder="Search..."
            wire:click="search('Wits')"
        />
    </div>
    <div wire:loading class="mx-auto text-center">
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
    <div class="grid grid-cols-4 gap-4" wire:loading.remove>
        @foreach($games as $game)
            <div class="max-w-sm rounded overflow-hidden shadow-sm">

                <img class="mx-auto rounded-full shadow-xl object-contain h-32 w-32" src="{{ $game['thumbnail'] }}" />
                <p class="text-center text-ellipsis object-contain">{{$game['name']}}</p>
                <div class="flex space-x-4 my-3">
                    <div class="bg-slate-300 rounded text-gray-500 font-bold px-2 text-sm">Plays: {{$game['numplays']}}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
