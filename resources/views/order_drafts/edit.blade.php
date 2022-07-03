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
                {{Form::open(['method' => 'put', 'route' => ['orderdrafts.update', $store->id]]) }}  

                @if (isset($date))
                <div class="text-center">
                    <h1>日別計画作成</h1>
                </div>
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

                            {{ Form::hidden('products[' . $loop->index . '][id]', $product->id, ['class' => 'form-control']) }}
                            {{ Form::number('products[' . $loop->index . '][quantity]', $product->order_drafts[0]->quantity, ['class' => 'form-control text-right', 'min' => '0']) }}                        
                        @else

                            {{ Form::hidden('products[' . $loop->index . '][id]', $product->id, ['class' => 'form-control']) }}
                            {{ Form::number('products[' . $loop->index . '][quantity]', '', ['class' => 'form-control text-right', 'min' => '0']) }}                           
                        @endif
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table> 
                @else
                <div class="text-center">
                    <h1>商品別計画作成</h1>
                </div>

                    {{Form::hidden('start',$start) }} 
                    {{Form::hidden('end',$end) }}                      
                    {{Form::hidden('product', $product->id)}}
                    <table class="table caption-top table-responsive-sm ">
                        <caption>{{ $store->name }}　商品名：{{$product->name}} 価格：{{$product->price}}ロット：{{$product->lot}}</caption>
                    <tbody>
                                            
                    @foreach($dates as $date)
                        <tr>
                        <td>{{$date->format('m/d')}}</td>    
                        <td><div class="text-right">


                        @if(isset($quantity[$product->id][$date->format('Y-m-d')]))
                        
                            @if($order_exists[$date->format('Y-m-d')])
                                {{ Form::number('', '', ['class' => 'form-control text-right', 'min' => '0', 'placeholder' => $quantity[$product->id][$date->format('Y-m-d')], 'disabled']) }}                        

                            @else
                                {{Form::hidden('dates[' . $loop->index . ']',$date->format('Y-m-d')) }}
                                {{ Form::number('quantity[' . $loop->index . ']', $quantity[$product->id][$date->format('Y-m-d')], ['class' => 'form-control text-right', 'min' => '0']) }}                        
                            @endif
                        @else
                            @if($order_exists[$date->format('Y-m-d')])
                                {{ Form::number('', '', ['class' => 'form-control text-right', 'min' => '0', 'disabled']) }}                        

                            @else
                                {{Form::hidden('dates[' . $loop->index . ']',$date->format('Y-m-d')) }}
                                {{ Form::number('quantity[' . $loop->index . ']', '', ['class' => 'form-control', 'min' => '0']) }}                        
                            @endif    
                        @endif
                        </div></td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                    

                @endif
                   <div class="row justify-content-left">
                     {!! Form::submit('登録', ['class' => 'btn btn-outline-dark']) !!}

                    {!! Form::button('戻る', ['class' => 'btn btn-outline-dark', 'onClick' => 'history.back();']) !!}
                    {!! Form::close() !!}

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