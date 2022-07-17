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
                test
                
                管理者の処理選択
                @break
            @case (2)
                <div class="text-center">
                    <h1>計画作成</h1>
                </div>
                @if (isset($start))

                @include('order_drafts.table')                    
                @else
                    @include('order_drafts.search')

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