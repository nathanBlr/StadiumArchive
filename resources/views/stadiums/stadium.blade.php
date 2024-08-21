@extends('rotas.base')
@section('title','Stadium')
@section('content')

    <!-- Carousel wrapper -->
    @if($stadium == Null)
    @else
   

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 bg-white p-8 margin-8 rounded justify-center place-items-center">
        <div class="">
            <img class="max-h-52 max-w-full rounded-lg" src="{{ asset('storage/'.$stadium->photo_1) }}" alt="">
        </div>
        <div>
            <img class="max-h-52 max-w-256  rounded-lg" src="{{ asset('storage/'.$stadium->photo_2) }}" alt="">
        </div>
        <div>
            <img class="max-h-52 max-w-256 rounded-lg" src="{{ asset('storage/'.$stadium->photo_3) }}" alt="">
        </div>
    </div>
@endif

@endsection
