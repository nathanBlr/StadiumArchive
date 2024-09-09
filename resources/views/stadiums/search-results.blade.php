@extends('rotas.base')
@section('title','Search')
@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4 text-center pt-6 pb-6 text-white ">Search Results</h1>

    @if($stadiums->isEmpty())
        <p class="text-center text-white">No stadiums found.</p>
    @else   
        <div class="flex justify-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($stadiums as $stadium)
                    <div class="bg-[#041932] rounded-lg shadow p-4 hover:shadow  text-white hover:text-[#041932] border-gray-200 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <a href="{{ route('details', [$stadium->slug]) }}" class="flex flex-col items-center bg-inherit md:flex-row md:max-w-xl ">
                            <img class="object-cover w-24 rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="{{ asset('storage/'.$stadium->photo_1) }}" alt="">
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight  text-inherit">{{ $stadium->name }}</h5>
                                <p class="mb-3 font-normal text-inherit hover:text-inherit">{{ $stadium->country }} | {{ $stadium->city }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@endsection