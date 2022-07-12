@extends('layouts.app')

@section('content')
    {{--店舗一覧 --}}
@if (count($stores) > 0)
 <div class="mx-auto">
<?php $prev = '' ?>
        @foreach ($stores as $store)
            <div class="row">
            @if($prev == $store->store_chain->name)
            <div class="col-3"></div>
            @else
            <div class="col">{{$store->store_chain->name}}</div>
            @endif
<?php $prev = $store->store_chain->name; ?>            
                <div class="col-9">
                        {{-- ユーザ詳細ページへのリンク --}}
                        <li class="list-inline-item col-2">{!! link_to_route('stores.show',  $store->name , ['store' => $store->id]) !!}</li> 
                </div>
            </div>
        @endforeach
    </ul>
</div>
@endif


    
    
                   <div class="row justify-content-around my-5">
 
                    {!! link_to_route('stores.create', '新規作成', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!}
                    {!! Form::button('戻る', ['class' => 'btn btn-outline-dark col-4', 'onClick' => 'history.back();']) !!}
                   </div>    
@endsection