@extends('rotas.base')
@section('title','Index')
@section('content')


<div id="controls-carousel" class="relative w-full mt-6" data-carousel="static">
    <!-- Carousel wrapper -->
    @if($stadium == Null)
    @else
    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
         <!-- Item 1 -->
        @if ($stadium->photo_1)
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('storage/'.$stadium->photo_1) }}" class="absolute block w-2/3 max-h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 mt-6  rounded-full" alt="...">
        </div>
        @endif
        @if ($stadium->photo_2)
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('storage/'.$stadium->photo_2) }}" class="absolute block w-2/3 h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 mt-6 rounded-full" alt="...">
        </div>
        @endif
        @if ($stadium->photo_3)
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('storage/'.$stadium->photo_3) }}" class="absolute block w-2/3 max-h-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 mt-6 rounded-full" alt="...">
        </div>
        @endif
    </div>
    <!-- Slider controls -->
    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
@endif
</div>

@endsection
