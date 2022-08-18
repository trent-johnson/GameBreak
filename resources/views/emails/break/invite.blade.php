@component('mail::message')
# You're Invited!

{{$break->user->name}} scheduled a new Game Break and would like you to participate. Here's the details:

### Location: {{$break->location}}

Date: _{{date('D M jS, g:i a',strtotime($break->event_datetime)) }}_

@component('mail::button', ['url' =>  url('/') . '/break/' . $break->id . '?invitee_id=' . $invitee->id . '&secure=' . $secure])
View Game Break
@endcomponent

@component('mail::panel')
If you're interested, you can RSVP and vote for your favorite game to be played by visiting the Game Break page.
@endcomponent
___

<center><img src="{{ url('/') . '/images/logo.png#center' }} " alt="Game Break"></center>

@endcomponent
