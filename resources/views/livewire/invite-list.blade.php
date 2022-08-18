<div wire:poll.5000ms>
    <h4 class="text-lg mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        Invite List
    </h4>
    <div class="flex gap-4 border-b border-1 border-gray-400">
        <div class="">
            {{ $break->invitees()->where('status',1)->count() }} Accepted
        </div>
        <div class="">
            {{ $break->invitees()->where('status',2)->count() }} Declined
        </div>
        <div class="">
            {{ $break->invitees()->where('status',0)->count() }} Pending
        </div>
    </div>

    <ul>
    @forelse($break->invitees()->get() as $invite)
        <li class="my-2">
            - {{ ($invite->user) ? $invite->user->name : $invite->email }}
            @if($invite->pivot->status == 0)
                <x-invite-tentative></x-invite-tentative>
            @elseif($invite->pivot->status == 1)
                <x-invite-accepted></x-invite-accepted>
            @else
                <x-invite-declined></x-invite-declined>
            @endif
        </li>
    @empty
        <li>No invites have been added to this Game Break.</li>
    @endforelse
    </ul>
</div>
