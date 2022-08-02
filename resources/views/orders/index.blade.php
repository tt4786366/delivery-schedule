@extends('layouts.app')

@section('content')
     @if (Auth::check())

        @switch (Auth::user()->authorization)
    
            @case (1)
                <div class="text-center">
                    <h1>管理者処理選択</h1>
                </div>
                @if (isset($start))
                    @include('orders.navtabs')         
                    @include('orders.table');
                @else
                    @include('orders.adminsearch')
                @endif
                @break
            @case (2)
                <div class="text-center">
                    <h1>承認済み計画検索</h1>
                </div>
                @if (isset($start))
                    @include('orders.navtabs')         
                    @include('orders.table');
                @else
                    @include('orders.driversearch')
                @endif
            
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