@component('mail::message')
@if(count($email_games) == 1)
# The votes are in...

<center><img src="{{ $email_games[0]['thumbnail'] . '#center' }} " alt="{{ $email_games[0]['name'] }}"></center>
<center>{{ $email_games[0]['name'] }}</center>
@else
# Hold up - It's a tie!

The following tied for the most votes:

@foreach($email_games as $game)
<center><img src="{{ $game['thumbnail'] . '#center' }} " alt="{{ $game['name'] }}"></center>
<center>{{ $game['name'] }}</center>
@endforeach
@endif

@component('mail::panel')
### Game Break Details

Location: {{ $break->location }}
Start Time: {{ date('D M jS, g:i a',strtotime($break->event_datetime)) }}
@endcomponent

@component('mail::button', ['url' =>  url('/') . '/break/' . $break->id . '?invitee_id=' . $invitee->id . '&secure=' . $secure])
View Game Break
@endcomponent

___

<center><img src="{{ url('/') . '/images/logo.png#center' }} " alt="Game Break"></center>

@endcomponent
