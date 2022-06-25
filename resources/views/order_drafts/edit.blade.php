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
                    <h1>日別計画作成</h1>
                </div>

                @if (isset($date))


                    <table class="table caption-top table-responsive-sm">
                        
                        <thead class="thead">
                        <tr>
                            <th>カテゴリ</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>ロット</th>

                        <th>
                            {{$date}}
                        </th>
                    </tr>
                    </thead>
                        
                    @foreach($products as $product)
                        <tr>
                        <td>{{ $product->category->name }}</td>    
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->lot }}</td>
                        <td>

                        @if($product->order_drafts->has('quantity'))
                        {{ $product->order_drafts->quantity}}
                        {{Form::number($product->id,  $product->order_drafts->quantity , ['class' => 'form-control'])}}    
                        @else
                        {{Form::number($product->id,'', ['class' => 'form-control', 'min' => '0'])}}
                        @endif
                        </td>

                    @endforeach
                    </tr>
                    </table>    
                @else


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