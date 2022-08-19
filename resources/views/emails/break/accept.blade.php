@component('mail::message')
# Here's your Calendar Invite

Attached is your calendar invite for {{$break->user->name}}'s Game Break.

### Location: {{$break->location}}

Date: _{{date('D M jS, g:i a',strtotime($break->event_datetime)) }}_

@component('mail::button', ['url' =>  url('/') . '/break/' . $break->id . '?invitee_id=' . $invitee->id . '&secure=' . $secure])
    View Game Break
@endcomponent

___

<center><img src="{{ url('/') . '/images/logo.png#center' }} " alt="Game Break"></center>

@endcomponent
