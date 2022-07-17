@extends('layouts.app')

@section('content')
    {{--商品一覧 --}}
    <h1>商品編集 </h1>


    <div class="row">
        <div class="col-sm-7 offset-sm-3">
            {!! Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'put']) !!}

                <div class="form-group">
                    {!! Form::label('name', '商品名') !!}
                    {!! Form::text('name',  $product->name  , ['class' => 'form-control', 'inputmode' => 'kana']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('price', '価格') !!}
                    {!! Form::number('price',  $product->price , ['class' => 'form-control text-right', 'min' => '0']) !!}

                </div>

                <div class="form-group">
                    {!! Form::label('lot', 'ロット') !!}
                    {!! Form::number('lot', $product->lot, ['class' => 'form-control text-right',  'min' => '0']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('category_id', 'カテゴリ') !!}
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">-- 選択してください --</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if ($product->category->id == $category->id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                </div>

                <div class="form-group">
                    {!! Form::label('factory_id', '製造担当') !!}
                        <select name="factory_id" id="factory_id" class="form-control">
                            <option value="">-- 選択してください --</option>
                            @foreach ($factories as $factory)
                            <option value="{{ $factory->id }}" @if ($product->factory->id == $factory->id) selected @endif>{{ $factory->name }}</option>
                            @endforeach
                        </select>
                </div>


                <div class="form-group">
                    {!! Form::label('store_chain_id', 'チェーン(専用商品のみ)') !!}
                        <select name="store_chain_id" id="store_chain_id" class="form-control">
                            <option value="">-- 選択してください --</option>
                            @foreach ($store_chains as $store_chain)
                                <option value="{{ $store_chain->id }}" @if (isset($product->store_chain) && $product->store_chain->id == $store_chain->id) selected @endif>{{ $store_chain->name }}</option>
                            
                            @endforeach
                        </select>
                </div>




                <div class="form-group">
                    {!! Form::label('valid_from', '有効期間（開始のみ必須）') !!}
                    {{Form::date('valid_from', $product->validufrom, ['class'=>'date'])}}～
                    {{Form::date('valid_until',$product->valid_until , ['class'=>'date'])}}
                </div>
                


                
<div class="row justify-content-around my-5">
                {!! Form::submit('更新', ['class' => 'btn btn-outline-dark col-4']) !!}
                {!! Form::button('戻る', ['class' => 'btn btn-outline-dark col-4', 'onClick' => 'history.back();']) !!}
</div>
            {!! Form::close() !!}
        </div>





    
    
@endsection