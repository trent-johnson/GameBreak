<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="font-medium text-lg">{{ $username }} - Game Collection</p>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-4 gap-4">
                @foreach($collection['item'] as $game)
                    <div class="border-solid border-2 border-slate-200 px-2 py-4">
                        <img class="mx-auto rounded-full shadow-xl object-contain h-32 w-32" src="{{ $game['image'] }}" />
                        <p class="text-center text-ellipsis object-contain">{{$game['name']}}</p>
                        <div class="flex space-x-4 my-3">
                            <div class="bg-slate-300 rounded text-gray-500 font-bold px-2 text-sm">Plays: {{$game['numplays']}}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>
