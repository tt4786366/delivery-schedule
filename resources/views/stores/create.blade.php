@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>店舗登録</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => 'stores.store']) !!}
                <div class="form-group">
                    {!! Form::label('chain_id', 'チェーン') !!}
                        <select name="chain_id" id="chain_id" class="form-control">
                            <option value="">-- 選択してください --</option>
                            @foreach ($chains as $chain)
                            <option value="{{ $chain->id }}" @if (old('chain_id') == $chain->id) selected @endif>{{ $chain->name }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                    {!! Form::label('name', '店名') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'inputmode' => 'kana']) !!}
                </div>



                <div class="form-group">
                    {!! Form::label('store_number', 'チェーン店番') !!}
                    {!! Form::text('store_number', null, ['class' => 'form-control', 'inputmode' => 'numeric']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('user_id', '担当者') !!}
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">-- 選択してください --</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if (old('user_id') == $user->id) selected @endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                </div>

                <div class="form-group">
                    {!! Form::label('valid_from', '有効期間（開始のみ必須）') !!}
                    {{Form::date('valid_from', \Carbon\Carbon::today(), ['class'=>'date'])}}～
                    {{Form::date('valid_until',null , ['class'=>'date'])}}
                </div>
                


                

                {!! Form::submit('登録', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection