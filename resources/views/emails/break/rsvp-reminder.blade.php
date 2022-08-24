@component('mail::message')
# Reminder: Upcoming Game Break

Don't forget! {{ $break->user->name }} has invited you to a game break, and it's almost here. You can accept or decline by
accessing the game break using the button below.

Your invite will be automatically declined if you don't RSVP within 24 hours of this notice.

@component('mail::button', ['url' =>  url('/') . '/break/' . $break->id . '?invitee_id=' . $invitee->id . '&secure=' . $secure])
    View Game Break
@endcomponent

@component('mail::panel')
### Details

Location: {{ $break->location }}
Start Time: {{ date('D M jS, g:i a',strtotime($break->event_datetime)) }}

@endcomponent

___

<center><img src="{{ url('/') . '/images/logo.png#center' }} " alt="Game Break"></center>

@endcomponent
