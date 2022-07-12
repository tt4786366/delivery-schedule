@extends('layouts.app')

@section('content')
     @if (Auth::check())

        @switch (Auth::user()->authorization)
    
            @case (1)
            
                {{-- ユーザ一覧 --}}
                @include('menu.administrator')
            
                @break
            @case (2)
                @include('menu.driver')
                @break
            @case (3)
        <div class="text-center">
            <h1>製造トップ</h1>
        </div>
        <div class="row">
        </div>
                
                @break
            @default
        @endswitch

    @else

    @endif    
    
@endsection