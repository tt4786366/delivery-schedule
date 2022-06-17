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
                    <h1>配送担当処理選択</h1>
                </div>
                <div class="row justify-content-around my-5">
                    <a class="btn btn-outline-dark col-4" href="#" role="button">計画作成</a>
                    <a class="btn btn-outline-dark col-4" href="#" role="button">承認済み計画表示</a>
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
        <div class="center jumbotron">
            <div class="text-center">
                <h1>納品計画管理</h1>
                {{--ログインページへのリンク --}}
            </div>
         </div>
    <div class="text-center">
        <h1>Log in</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => 'login.post']) !!}
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Password') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('Log in', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}

        </div>
    </div>
    @endif    
    
@endsection