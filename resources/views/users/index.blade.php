@extends('layouts.app')

@section('content')
    {{-- ユーザ一覧 --}}
    @include('users.users')
    
                    {!! link_to_route('signup.get', '新規作成', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!}
    
@endsection