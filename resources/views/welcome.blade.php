@extends('layouts.app')

@section('content')
     @if (Auth::check())

        @switch (Auth::user()->authorization)
    
            @case (1)
                <div class="text-center">
                    <h1>管理者処理選択</h1>
                </div>
                <div class="row">
                </div>
                管理者の処理選択
                @break
            @case (2)
                <div class="text-center">
                    <h1>配送担当処理選択</h1>
                </div>
                <div class="row justify-content-around my-5">
                    {!! link_to_route('orderdrafts.index', '計画作成', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!}
                    {!! link_to_route('orders.index', '承認済み計画表示', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!}
                </div>
            
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