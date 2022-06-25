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
                        $date=$start; 
                        $date_count = 0;
                    ?>

                    <table class="table caption-top">
                        <caption>{{ $stores->name }}</caption>
                        
                        <thead class="thead">
                        <tr>
                            <th>カテゴリ</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>ロット</th>

                    @while($date->lte($end))
                        <th>
                        {{ Form::open(['method'=>'get', 'route' => ['orderdrafts.edit', $stores->id]]) }}    
                        {{Form::hidden('date',$date->format('Y/m/d')) }}
                         {!! Form::submit($date->format('m/d'), ['class' => 'btn btn-outline-dark']) !!}
                        {!! Form::close() !!}
                        <?php 
                        $date = $date->addDay();
                        $date_count++;
                        ?>
                        </th>
                    @endwhile
                    </tr>
                    </thead>
                        
                    @foreach($products as $product)
                        <tr>
                        <td>{{ $product->category->name }}</td>    
                        <td>{{ Form::open(['method'=>'get', 'route' => ['orderdrafts.edit', $stores->id]]) }}    
                        {{Form::hidden('start',$start->format('Y/m/d')) }}
                        {{Form::hidden('end',$end->format('Y/m/d')) }}
                        {{Form::hidden('product',$product->id) }}
                         {!! Form::submit($product->name, ['class' => 'btn btn-outline-dark']) !!}
                        {!! Form::close() !!}
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->lot }}</td>
                        @for ($i = 0; $i < $date_count; $i++)
                            <td></td>
                        @endfor
 
                    @endforeach
                    </tr>
                    </table>    
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