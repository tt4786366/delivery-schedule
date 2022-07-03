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
                @if (isset($start))


                    <table class="table caption-top table-sm">
                        <caption>{{ $store->name }}</caption>
                        
                        <thead class="thead">
                        <tr>
                            <th>カテゴリ</th>
                            <th>商品名</th>
                            <th><div class="text-right">価格</div></th>
                            <th><div class="text-right">ロット</div></th>

                    @for($i = 0; $i<$date_count;$i++)
                        <th>
                            <div class="text-right">                       
                        @if ($order_exists[$dates[$i]->format('Y-m-d')])    
                            {{$dates[$i]->format('m/d')}}

                        @else
                        {{ Form::open(['method'=>'get', 'route' => ['orderdrafts.edit', $store->id]]) }}    
                        {{Form::hidden('date',$dates[$i]->format('Y/m/d')) }}
                        {{Form::hidden('start',$start->format('Y-m-d')) }} 
                        {{Form::hidden('end',$end->format('Y-m-d')) }} 
                         {!! Form::submit($dates[$i]->format('m/d'), ['class' => 'btn btn-sm btn-outline-dark']) !!}
                        {!! Form::close() !!}
                        
                        @endif
                            </div>
                        </th>

                    @endfor
                    <th>計</th>
                    <th>金額</th>
                    </tr>
                    </thead>
                        
                    @foreach($products as $product)
                        <tr>
                        <td>{{ $product->category->name }}</td>    
                        <td>{{ Form::open(['method'=>'get', 'route' => ['orderdrafts.edit', $store->id]]) }}    
                        {{Form::hidden('start',$start->format('Y-m-d')) }}
                        {{Form::hidden('end',$end->format('Y-m-d')) }}
                        {{Form::hidden('product',$product->id) }}
                         {!! Form::submit($product->name, ['class' => 'btn btn-sm btn-outline-dark']) !!}
                        {!! Form::close() !!}
                        </td>
                        <td><div class="text-right">{{ $product->price }}</div></td>
                        <td><div class="text-right">{{ $product->lot }}</div></td>
                        @for ($i = 0; $i < $date_count; $i++)
                            @if (isset($quantity[$product->id][$dates[$i]->format('Y-m-d')]))
                            <td class="pr-3"><div class="text-right">{{ $quantity[$product->id][$dates[$i]->format('Y-m-d')] }}</div></td>
                            @else
                            <td></td>
                            @endif
                        @endfor
                        @if (isset($sum[$product->id]['quantity']))
                        <td><div class="text-right">{{$sum[$product->id]['quantity']}}</div></td>
                        <td><div class="text-right">{{$sum[$product->id]['price']}}</div></td>
                        @else
                        <td></td>
                        <td></td>
                        @endif


                    @endforeach
                    </tr>
                        <tr>
                            <th>合計</th>
                            <th></th>
                            <th></th>
                            <th></th>

                    @for($i = 0; $i<$date_count;$i++)
                        <td>
                        </td>

                    @endfor
                    <td><div class="text-right">{{$total['quantity']}}</div></td>
                    <td><div class="text-right">{{$total['price']}}</div></td>
                    </tr>
                    </table>    
                   <div class="">
                {{Form::open(['method' => 'post', 'route' => ['orderdrafts.store'], 'class' => 'row justify-content-around  my-5']) }}  

                     {!! Form::submit('確定して提出', ['class' => 'btn btn-outline-dark col-4']) !!}
                    {{Form::hidden('start',$start->format('Y-m-d')) }}
                    {{Form::hidden('end',$end->format('Y-m-d')) }}
                    {{Form::hidden('id',$store->id) }}                      
                    {!! Form::button('戻る', ['class' => 'btn btn-outline-dark col-4', 'onClick' => 'history.back();']) !!}

                    {!! Form::close() !!}

                    </div>                    
                @else
                    @include('order_drafts.search')

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