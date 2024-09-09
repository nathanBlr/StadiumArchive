@extends('rotas.base')
@section('title','Stadium')
@section('content')
    @if($stadium == Null)
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center justify-items-center bg-[#041932] p-8 rounded-t">
        <div class="col-span-2 md:col-span-3 text-center">
            <h1 class="text-white text-4xl md:text-7xl font-extrabold">
                {{ $stadium->name }}
            </h1>
        </div>
    </div>
    
    <div class="flex justify-center bg-[#041932] p-8 ">
        <div class="max-w-4xl w-full">
            <img class="w-full h-auto rounded-lg" src="{{ asset('storage/'.$stadium->photo_1) }}" alt="Stadium Image">
        </div>
    </div>
    
    <div class="flex flex-col md:flex-row  justify-center">
    <a href="#" class="block max-w-sm p-6 bg-white shadow  hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <div class="text-center">
            <h2 class="text-[#041932] text-2xl md:text-4xl font-bold">
                Informações do Estádio
            </h2>
            <div class="text-[#041932] text-lg md:text-xl font-extrabold mt-4">
                <ul class="space-y-2">
                    <li>Stadium Name: {{ $stadium->name }}</li>
                    <li>Stadium Full Name: {{ $stadium->full_name }}</li>
                    <li>Stadium Capacity: {{ $stadium->capacity }}</li>
                </ul>
            </div>
        </div>
    </a>
    <a href="#" class="block max-w-sm p-6 bg-white shadow  hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <div class="text-center">
            <h2 class="text-[#041932] text-2xl md:text-4xl font-bold">
                Informações do Estádio
            </h2>
            <div class="text-[#041932] text-lg md:text-xl font-extrabold mt-4">
                <ul class="space-y-2">
                    <li>Stadium Tenants: {{ $stadium->tenants }}</li>
                    @if ($stadium->sport_id)
                        <li>Stadium Full Name: {{ $stadium->sport_id->name }}</li>
                    @endif
                    
                    <li>Stadium Capacity: {{ $stadium->capacity }}</li>
                </ul>
            </div>
        </div>
    </a>
    @if ($stadium->email || $stadium->phone_number || $stadium->website)   
        <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center justify-items-center bg-white p-8">
                <div class="col-span-2 md:col-span-3 text-center">
                    <h2 class="text-[#041932] text-3xl md:text-7xl font-bold">
                        Contacts
                    </h2>
                    <h3 class="text-[#041932] text-2xl md:text-3xl font-extrabold">
                    @if ($stadium->email)
                    Contact Email:  {{ $stadium->email }}
                    @endif
                    @if ($stadium->phone_number)
                    Phone number:  {{ $stadium->phone_number }}
                    @endif  
                    @if ($stadium->website )
                    Website:  {{ $stadium->website }}
                    @endif    
                    </h3>
                </div>
            </div>
        </a>
    @endif
    </div>
    

@endif

@endsection
