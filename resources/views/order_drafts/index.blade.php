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
                    <h1>計画作成</h1>
                </div>
                {!! Form::open(['route' => 'orderdrafts.index', 'method'=>'get']) !!}
                <div class="form-group">
                    <div class="row justify-content-center  my-5">
                        <div class="col-3"><P>納品日：</P></div>
                        <div class="col-6">
                            {{Form::date('start', \Carbon\Carbon::tomorrow(), ['class'=>'date'])}}～
                            {{Form::date('end', \Carbon\Carbon::tomorrow(), ['class'=>'date'])}}
                        </div>
                    </div>
                    <div class="row justify-content-center  my-5">
                        <div class="col-3"><P>店舗：</P></div>
                        <div class="col-6">
                            @foreach ($stores as $store)
                            {{Form::radio('store', $store->id, false, ['class'=>'circle'])}}
                            {{Form::label('store', $store->name, ['class' => 'col-4'])}}<br>
                            @endforeach
                        </div>
                    </div>                    
                   <div class="row justify-content-around  my-5">
                        {!! Form::submit('作成', ['class' => 'btn btn-outline-dark col-4']) !!}
                        {!! Form::button('戻る', ['class' => 'btn btn-outline-dark col-4', 'onClick' => 'history.back();']) !!}
                    </div>
                </div>
                {!! Form::close() !!}

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