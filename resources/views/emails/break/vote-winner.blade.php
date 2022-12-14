@component('mail::message')
@if(count($email_games) == 1)
# The votes are in...

<center><img src="{{ $email_games[0]['thumbnail'] . '#center' }} " alt="{{ $email_games[0]['name'] }}"></center>
<center>{{ $email_games[0]['name'] }}</center>

If you're not familiar with {{ $email_games[0]['name'] }} or just want to brush up with an overview, here's a
quick video:

<center><a href="https://www.youtube.com/watch?v={{ $email_games[0]['yt_info']['id']['videoId'] }}"><img src="{{ $email_games[0]['yt_info']['snippet']['thumbnails']['default']['url'] . '#center' }}" width="{{ $email_games[0]['yt_info']['snippet']['thumbnails']['default']['width'] }}" height="{{ $email_games[0]['yt_info']['snippet']['thumbnails']['default']['height'] }}" /></a></center>
<center>{{  $email_games[0]['yt_info']['snippet']['title'] }}</center>

@else
# Hold up - It's a tie!

The following tied for the most votes:

@foreach($email_games as $game)
<center><img src="{{ $game['thumbnail'] . '#center' }} " alt="{{ $game['name'] }}"></center>
<center>{{ $game['name'] }}</center>

If you're not familiar with {{ $game['name'] }} or just want to brush up with an overview, here's a
quick video:

<center><a href="https://www.youtube.com/watch?v={{ $game['yt_info']['id']['videoId'] }}"><img src="{{ $game['yt_info']['snippet']['thumbnails']['default']['url'] . '#center' }}" width="{{ $game[0]['yt_info']['snippet']['thumbnails']['default']['width'] }}" height="{{ $game['yt_info']['snippet']['thumbnails']['default']['height'] }}" /></a></center>
<center>{{ $game['yt_info']['snippet']['title'] }}</center>
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
