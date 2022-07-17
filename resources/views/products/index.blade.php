@extends('layouts.app')

@section('content')
    {{--商品一覧 --}}
@if (count($products) > 0)
 <div class="mx-auto">
<?php $prev = '' ?>
<table class='table'>
        @foreach ($products as $product)
<tr>
            @if($prev == $product->category->name)
            <td class="col-3"></td>
            @else
            <td class="col-3">{{$product->category->name}}</td>
            @endif
<?php $prev = $product->category->name; ?>            
                <td class="col-3">
                        {{-- 商品詳細ページへのリンク --}}
                        {!! link_to_route('products.show',  $product->name , ['product' => $product->id]) !!} 
                </td>
                <td class="col-3">
                        {!!   $product->price  !!} 
                </td>
                <td class="col-3">
                        {!!   $product->lot  !!} 
                </td>                
</tr>
        @endforeach
</table>
</div>
@endif


    
    
                   <div class="row justify-content-around my-5">
 
                    {!! link_to_route('products.create', '新規作成', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!}
                    {!! Form::button('戻る', ['class' => 'btn btn-outline-dark col-4', 'onClick' => 'history.back();']) !!}
                   </div>    
@endsection