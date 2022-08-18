<div class="max-w-sm rounded overflow-hidden shadow-sm mx-auto relative">
    <img class="mx-auto rounded-full shadow-xl object-contain h-32 w-32" src="{{ $game['thumbnail'] }}" />
    <p class="text-center text-ellipsis object-contain">{{(count($game['name']) > 1) ? $game['name'][0]['@attributes']['value'] : $game['name']['@attributes']['value']}}</p>
    <div class="flex space-x-4 my-3 mx-auto">
        <div class="flex-auto bg-slate-300 rounded text-gray-500  px-2 py-1 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            {{$game['minplayers']['@attributes']['value']}} - {{$game['maxplayers']['@attributes']['value']}}</div>
        <div class="flex-auto bg-slate-300 rounded text-gray-500  px-2 py-1 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
            </svg>
            {{(array_key_exists('playingtime',$game)) ? $game['playingtime']['@attributes']['value'] . 'm' : 'N/A' }}</div>
        <div class="flex-auto bg-slate-300 rounded text-gray-500  px-2 py-1 text-sm">
            <a href="https://boardgamegeek.com/boardgame/{{ $thing_id }}" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg> Details</a>
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
