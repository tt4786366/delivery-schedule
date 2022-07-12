@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>新規ユーザー追加</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => 'signup.post']) !!}
                <div class="form-group">
                    {!! Form::label('name', '氏名（スペースなし）') !!}
                    {!! Form::text('name', null, ['class' => 'form-control','inputmode' => 'kana']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', null, ['class' => 'form-control','inputmode' => 'email']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'パスワード') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password_confirmation', 'パスワード確認') !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>
                

                <div class="form-group">
                    {!! Form::label('team_id', 'チーム') !!}
                        <select name="team_id" id="team_id" class="form-control">
                            <option value="">-- 選択してください --</option>
                            @foreach (App\Team::get() as $team)
                            <option value="{{ $team->id }}" @if (old('team_id') == $team->id) selected @endif>{{ $team->name }}</option>
                            @endforeach
                        </select>
                </div>

                <div class="form-group">
                    {!! Form::label('authorization', '権限') !!}
                        <select name="authorization" id="authorization" class="form-control">
                            <option value="">-- 選択してください --</option>
                            <option value="1">管理者</option>
                            <option value="2">ドライバー</option>
                            <option value="3">内勤</option>
                        </select>
                </div>
                

                {!! Form::submit('Sign up', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection