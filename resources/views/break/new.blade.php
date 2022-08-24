<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule New Game Break') }}
        </h2>
    </x-slot>

    <!-- Validation Errors -->
    <x-app-success-messages class="mx-auto sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg mb-4" :successes="$successes" />

    <form method="POST" action="{{ route('saveBreak') }}">
        @csrf
        <div class="pt-6">
            <div class="text-center">
                <x-button>
                    {{ __('Schedule') }}
                </x-button>
            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6 bg-white border-b border-gray-200 w-full">
                            <div class="mb-3">
                                <p class="text-lg">Event Details</p>
                            </div>
                            <div class="my-3">
                                <x-label for="event_datetime" :value="__('Date and Time')" />

                                <x-input id="event_datetime" class="block mt-1 w-full p-2" type="datetime-local" name="event_datetime" :value="old('event_datetime', $break->event_datetime)" required autofocus />
                            </div>
                            <div class="my-3">
                                <x-label for="location" :value="__('Location')" />
                                <x-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $break->location)" required />
                            </div>
                            <div class="my-3">
                                <x-label for="notes" :value="__('Notes')" />
                                <x-input id="notes" class="block mt-1 w-full" type="text" name="notes" :value="old('notes', $break->notes)" />
                            </div>
                            <div class="my-3">
                                <div class="flex gap-4">
                                    <label for="rsvp_control" class="inline-flex relative items-center mb-4 cursor-pointer">
                                        <input type="checkbox" value="1" id="rsvp_control" name="rsvp_control" class="sr-only peer" @if(old('rsvp_control', $break->rsvp_control) == 1) checked @endif>
                                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        <span class="ml-3 text-sm font-medium text-gray-900">RSVP Lock</span>
                                    </label>
                                    <div class="flex-auto text-right">
                                        <x-input id="rsvp_timing" type="text" name="rsvp_timing" class="text-xs text-center" :value="old('rsvp_timing', $break->rsvp_timing)" /> Hours
                                    </div>
                                </div>
                                <p class="text-sm italic text-muted">Enabling will stop RSVPs from being accepted 24 hours before the Game Break.</p>
                            </div>
                            <div class="my-3">
                                <div class="flex gap-4">
                                    <label for="vote_control" class="inline-flex relative items-center mb-4 cursor-pointer">
                                        <input type="checkbox" value="1" name="vote_control" id="vote_control" class="sr-only peer" @if(old('vote_control', $break->vote_control) == 1) checked @endif>
                                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        <span class="ml-3 text-sm font-medium text-gray-900">Voting Lock</span>
                                    </label>
                                    <div class="flex-auto text-right">
                                        <x-input id="vote_timing" type="text" name="vote_timing" class="text-xs text-center" :value="old('vote_timing', $break->vote_timing)" /> Hours
                                    </div>
                                </div>
                                <p class="text-sm italic text-muted">Enabling will stop votes from being submitted 24 hours before the Game Break.</p>
                            </div>
                        </div>
                        <div class="p-6 bg-white border-b border-gray-200 w-full">
                            <div class="mb-3">
                                <p class="text-lg">Invitees</p>
                            </div>
                            @foreach($break->invitees()->get() as $invite)
                                <p>{{ ($invite->user) ? $invite->user->name : $invite->email }}</p>
                            @endforeach
                            <div class="my-3">
                                <x-label for="invitee_list" :value="__('List of email addresses seperated by commas')" />
                                <textarea name="invitee_list" id="invitee_list" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Email Addresses"></textarea>
                            </div>
                            <div class="my-3">
                                <label for="remind_rsvp" class="inline-flex relative items-center mb-4 cursor-pointer">
                                    <input type="checkbox" value="1" id="remind_rsvp" name="remind_rsvp" class="sr-only peer" @if(old('remind_rsvp', $break->remind_rsvp) == 1) checked @endif>
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900">Send RSVP Reminders</span>
                                </label>
                            </div>
                            <div class="my-3">
                                <label for="notify_vote" class="inline-flex relative items-center mb-4 cursor-pointer">
                                    <input type="checkbox" value="1" id="notify_vote" name="notify_vote" class="sr-only peer" @if(old('notify_vote', $break->notify_vote) == 1) checked @endif>
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900">Send Vote Winner Notification</span>
                                </label>
                            </div>
                            <div class="my-3">
                                <label for="remind_break" class="inline-flex relative items-center mb-4 cursor-pointer">
                                    <input type="checkbox" value="1" name="remind_break" id="remind_break" class="sr-only peer" @if(old('remind_break', $break->remind_break) == 1) checked @endif>
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900">Send Game Break Reminders</span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <h2 class="my-5 font-semibold text-xl text-gray-800 text-center">
                    Select Available Games
                </h2>
                <p class="my-3 text-center">The games selected from the list below will be offered as options to vote on for this Game Break.</p>
                <livewire:show-games :username="auth()->user()->bgg_user" :break="true"/>
            </div>
        </div>
    </form>
</x-app-layout>
