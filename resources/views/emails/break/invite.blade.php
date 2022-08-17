@component('mail::message')
    # You're Invited!

    An upcoming Game Break has been scheduled. You can now vote on which game(s) you'd like to see played.

    @component('mail::button', ['url' => 'http://localhost:6099/break/' . $break->id . '?invitee=' . $invitee->id . '&secure=' . $secure])
        View Game Break
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
