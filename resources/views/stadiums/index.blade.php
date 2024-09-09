@extends('rotas.base')
@section('title','Index')
@section('content')


<div id="controls-carousel" class="relative w-full mt-6"  data-carousel="static">
    <!-- Carousel wrapper -->
    @if($stadium == Null)
    @else
    <div class="relative h-56 overflow-hidden rounded-lg md:h-96 focus:outline-none focus:ring-blue-300 drop-shadow-lg">
         <!-- Item 1 -->
        @if ($stadium->photo_1)
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('storage/'.$stadium->photo_1) }}" 
                 class="absolute drop-shadow-lg block w-2/3 max-h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 mt-6 rounded-full" 
                 alt="{{ $stadium->name }}, {{ $stadium->city }}">
        
            <!-- Label for the stadium name and city -->
            <a href="{{ route('details', [$stadium->slug]) }}">
            <div class="absolute text-white bg-[#041932] bg-opacity-75 px-4 py-2 rounded-md 
                        bottom-8 left-1/2 transform -translate-x-1/2 text-center">
                <span>{{ $stadium->name }}, {{ $stadium->city }}</span>
            </div>
            </a>
        </div>
        
        @elseif ($stadium->photo_2)
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('storage/'.$stadium->photo_2) }}" class="absolute drop-shadow-lg block w-2/3 h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 mt-6 rounded-full" alt="...">
        </div>
        @elseif ($stadium->photo_3)
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('storage/'.$stadium->photo_3) }}" class="absolute drop-shadow-lg block w-2/3 max-h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 mt-6 rounded-full" alt="...">
        </div>
        @endif
    </div>
    
@endif
</div>

@endsection
