<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>


    <!-- Validation Errors -->
    <x-app-success-messages class="mx-auto sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg mb-4" :successes="$successes" />
    <form method="POST" action="{{ route('profile',['user' => $user->id]) }}">
        @csrf
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <p class="my-3">{{ $user->name  }} Profile</p>
                        <div class="my-3">
                            <x-label for="bgg_user" :value="__('BGG Profile')" />

                            <x-input id="bgg_user" class="block mt-1 w-full" type="text" name="bgg_user" :value="old('bgg_user', $user->bgg_user)" required autofocus />
                        </div>
                        <x-button>
                            {{ __('Update') }}
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
