<div wire:poll.5000ms>
    <h4 class="text-lg mb-4">
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
