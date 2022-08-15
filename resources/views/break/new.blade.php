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
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="my-3">
                            <p class="text-lg">Event Details</p>
                        </div>
                        <div class="my-3">
                            <x-label for="event_datetime" :value="__('Date and Time')" />

                            <x-input id="event_datetime" class="block mt-1 w-full" type="datetime-local" name="event_datetime" :value="old('event_datetime')" required autofocus />
                        </div>
                        <div class="my-3">
                            <x-label for="location" :value="__('Location')" />
                            <x-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                        </div>
                        <div class="my-3">
                            <x-label for="notes" :value="__('Notes')" />
                            <x-input id="notes" class="block mt-1 w-full" type="text" name="notes" :value="old('notes')" />
                        </div>
                        <x-button>
                            {{ __('Schedule') }}
                        </x-button>
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