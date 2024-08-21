@extends('rotas.base')
@section('title','Search')
@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4 text-center pt-6 pb-6 ">Search Results</h1>

    @if($stadiums->isEmpty())
        <p class="text-center">No stadiums found.</p>
    @else   
        <div class="flex justify-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($stadiums as $stadium)
                    <div class="bg-white rounded-lg shadow p-4 dark:bg-gray-800 dark:text-white">
                        <a href="{{ route('details', [$stadium->id]) }}" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                            <img class="object-cover w-24 rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="{{ asset('storage/'.$stadium->photo_1) }}" alt="">
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $stadium->name }}</h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $stadium->country }} | {{ $stadium->city }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@endsection