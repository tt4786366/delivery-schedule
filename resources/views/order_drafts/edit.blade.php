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

                     {{ Form::open(['method' => 'put', 'route' => ['orderdrafts.update', $store->id]]) }}  
                    {{Form::hidden('start',$start) }} 
                    {{Form::hidden('end',$end) }}                      
                    <table class="table caption-top table-responsive-sm">
                        <caption>{{ $store->name }}</caption>
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
                    <tbody>
                        {{Form::hidden('date',$date) }}    
                                            
                    @foreach($products as $product)
                        <tr>
                        <td>{{ $product->category->name }}</td>    
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->lot }}</td>
                        <td>


                        @if($product->order_drafts->isEmpty()==False)

                        {{--{{Form::number($product->id,  $product->order_drafts->quantity , ['class' => 'form-control'])}} --}}  
{{ Form::hidden('products[' . $loop->index . '][id]', $product->id, ['class' => 'form-control']) }}
{{ Form::number('products[' . $loop->index . '][quantity]', $product->order_drafts[0]->quantity, ['class' => 'form-control', 'min' => '0']) }}                        
                        @else

{{ Form::hidden('products[' . $loop->index . '][id]', $product->id, ['class' => 'form-control']) }}
{{ Form::number('products[' . $loop->index . '][quantity]', '', ['class' => 'form-control', 'min' => '0']) }}                           
                        {{-- {{Form::number($product->id,'', ['class' => 'form-control', 'min' => '0'])}} --}}
                        @endif
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table> 
                     {!! Form::submit('登録', ['class' => 'btn btn-outline-dark']) !!}
                    
                    {!! Form::close() !!}
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