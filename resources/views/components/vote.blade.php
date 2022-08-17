@props(['invitee_id', 'disabled' => false, 'vote_status'])
<button {{ $disabled ? 'disabled' : '' }}  class=" @if($vote_status == 1) disabled:opacity-75 bg-indigo-600 hover:bg-indigo-600 @else bg-green-800 hover:bg-green-700 active:bg-green-900 focus:border-green-900 ring-green-300 disabled:opacity-25 @endif block w-full items-center px-4 py-2  border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest  focus:outline-none  focus:ring  transition ease-in-out duration-150" wire:click="vote({{$invitee_id}})">
    {{ $slot }}
</button>
