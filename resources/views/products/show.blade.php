@extends('layouts.app')

@section('content')
    {{--商品一覧 --}}
    <h1>商品詳細 </h1>

    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <td>{{ $product->id }}</td>
        </tr>
        <tr>
            <th>メッセージ</th>
            <td>{{ $product->name }}</td>
        </tr>
       <tr>
            <th>価格</th>
            <td>{{ $product->price }}</td>
        </tr>
       <tr>
            <th>ロット</th>
            <td>{{ $product->lot }}</td>
        </tr>
       <tr>
            <th>カテゴリ</th>
            <td>{{ $product->category->name }}</td>
        </tr> 
       <tr>
            <th>製造担当</th>
            <td>{{ $product->factory->name }}</td>
        </tr>
        <tr>
            <th>チェーン</th>
            @if (isset($product->store_chain))
            <td>{{ $product->store_chain->name }}</td>
            @else
            <td></td>
            @endif
        </tr>
    </table>

    
                   <div class="row justify-content-around my-5">
 
                    {!! link_to_route('products.edit', '編集', ['product' =>$product->id], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!}
                    {!! Form::button('戻る', ['class' => 'btn btn-outline-dark col-4', 'onClick' => 'history.back();']) !!}
                   </div>    
@endsection