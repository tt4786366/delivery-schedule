@extends('layouts.app')

@section('content')
    {{-- ユーザ一覧 --}}
    @include('users.users')
    
    
                   <div class="row justify-content-around my-5">
 
                    {!! link_to_route('signup.get', '新規作成', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!}
                    {!! Form::button('戻る', ['class' => 'btn btn-outline-dark col-4', 'onClick' => 'history.back();']) !!}
                   </div>    
@endsection