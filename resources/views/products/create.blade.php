@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>商品登録</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => 'products.store']) !!}
                <div class="form-group">
                    {!! Form::label('name', '商品名') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'inputmode' => 'kana']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('price', '価格') !!}
                    {!! Form::number('price', null, ['class' => 'form-control text-right', 'min' => '0']) !!}

                </div>

                <div class="form-group">
                    {!! Form::label('lot', 'ロット') !!}
                    {!! Form::number('lot', null, ['class' => 'form-control text-right',  'min' => '0']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('category_id', 'カテゴリ') !!}
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">-- 選択してください --</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                </div>

                <div class="form-group">
                    {!! Form::label('factory_id', '製造担当') !!}
                        <select name="factory_id" id="factory_id" class="form-control">
                            <option value="">-- 選択してください --</option>
                            @foreach ($factories as $factory)
                            <option value="{{ $factory->id }}" @if (old('factory_id') == $factory->id) selected @endif>{{ $factory->name }}</option>
                            @endforeach
                        </select>
                </div>


                <div class="form-group">
                    {!! Form::label('store_chain_id', 'チェーン(専用商品のみ)') !!}
                        <select name="store_chain_id" id="store_chain_id" class="form-control">
                            <option value="">-- 選択してください --</option>
                            @foreach ($store_chains as $store_chain)
                            <option value="{{ $store_chain->id }}" @if (old('store_chain_id') == $store_chain->id) selected @endif>{{ $store_chain->name }}</option>
                            @endforeach
                        </select>
                </div>




                <div class="form-group">
                    {!! Form::label('valid_from', '有効期間（開始のみ必須）') !!}
                    {{Form::date('valid_from', \Carbon\Carbon::today(), ['class'=>'date'])}}～
                    {{Form::date('valid_until',null , ['class'=>'date'])}}
                </div>
                


                

                {!! Form::submit('登録', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection