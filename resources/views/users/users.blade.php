@if (count($teams) > 0)
 <div class="mx-auto">
    <ul class="list-unstyled">
        @foreach ($teams as $team)
            <div class="row">
            <div class="col-2"></div>
            <li class="list-item col-10" >
                {{$team->name}}
                <ul class="list-unstyled">
                <div class="">
                    <ul class="list-inline row mx-auto">    
                        {{-- ユーザ詳細ページへのリンク --}}
                        @foreach ($team->users as $user)
                        <li class="list-inline-item col-2">{!! link_to_route('users.show',  $user->name , ['user' => $user->id]) !!}</li> 
                        @endforeach
                    </ul>    
                </div>
            </ul>
            </li>
            </div>
        @endforeach
    </ul>
</div>
@endif