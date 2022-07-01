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
                @if ($start)
                    <?php 
                        //$date=$start; 
                        //$date_count = 0;
                    ?>

                    <table class="table caption-top">
                        <caption>{{ $store->name }}</caption>
                        
                        <thead class="thead">
                        <tr>
                            <th>カテゴリ</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>ロット</th>

                    @for($i = 0; $i<$date_count;$i++)
                        <th>
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
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->lot }}</td>
                        @for ($i = 0; $i < $date_count; $i++)
                            @if (isset($quantity[$loop->iteration-1][$dates[$i]->format('Y-m-d')]))
                            <td>{{ $quantity[$loop->iteration-1][$dates[$i]->format('Y-m-d')] }}</td>
                            @else
                            <td></td>
                            @endif
                        @endfor
                        <td>{{$sum[$loop->iteration-1]['quantity']}}</td>
                        <td>{{$sum[$loop->iteration-1]['price']}}</td>
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
                    <td>{{$total['quantity']}}</td>
                    <td>{{$total['price']}}</td>
                    </tr>
                    </table>    
                   <div class="row justify-content-around  my-5">
                {{Form::open(['method' => 'post', 'route' => ['orderdrafts.store']]) }}  

                     {!! Form::submit('確定して提出', ['class' => 'btn btn-outline-dark']) !!}
                    {{Form::hidden('start',$start->format('Y-m-d')) }}
                    {{Form::hidden('end',$end->format('Y-m-d')) }}
                    {{Form::hidden('id',$store->id) }}                      

                        {{--{!! link_to_route('orderdrafts.index', '戻る','',  ['class' => 'btn btn-outline-dark col-4']) !!}--}}
                    {!! Form::close() !!}

                        {!! Form::button('戻る', ['class' => 'btn btn-outline-dark col-4', 'onClick' => 'history.back();']) !!}
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