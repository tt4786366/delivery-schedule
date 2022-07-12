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
                    <h1>承認済み計画検索</h1>
                </div>
                <div class="row justify-content-around my-5">
                    <a class="btn btn-outline-dark col-4" href="#" role="button">計画作成</a>
                    <a class="btn btn-outline-dark col-4" href="#" role="button">承認済み計画表示</a>
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