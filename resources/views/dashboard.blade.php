<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                    <p>
                    @php
                        echo Auth::user()->name;
                        echo ', ';
                        echo Auth::user()->email;
                        echo ', ';
                        echo Auth::user()->created_at;
                    @endphp
                        <br>
                        @if((auth()->user()->role_id == '1') )
                        <a href="{{route('theaterIndex')}}" class="underline">  Theaters  </a><br>
                        <a href="{{route('salonIndex')}}" class="underline">  Salons  </a><br>

                        @endif
                        <a href="#" class="underline">  Shows  </a><br>
                        <a href="#" class="underline">  MyTickets  </a><br>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
