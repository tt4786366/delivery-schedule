@extends('layouts.app')

@section('content')
    {{--商品一覧 --}}
@if (count($products) > 0)
 <div class="mx-auto">
<?php $prev = '' ?>
        @foreach ($products as $product)
            <div class="row">
            @if($prev == $product->category->name)
            <div class="col-3"></div>
            @else
            <div class="col-3">{{$product->category->name}}</div>
            @endif
<?php $prev = $product->category->name; ?>            
                <div class="col-3">
                        {{-- 商品詳細ページへのリンク --}}
                        {!! link_to_route('products.show',  $product->name , ['product' => $product->id]) !!} 
                </div>
                <div class="col-3">
                        {{-- 商品詳細ページへのリンク --}}
                        {!!   $product->price  !!} 
                </div>
                
            </div>
        @endforeach

</div>
@endif


    
    
                   <div class="row justify-content-around my-5">
 
                    {!! link_to_route('products.create', '新規作成', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!}
                    {!! Form::button('戻る', ['class' => 'btn btn-outline-dark col-4', 'onClick' => 'history.back();']) !!}
                   </div>    
@endsection