                <div class="text-center">
                    <h1>配送担当処理選択</h1>
                </div>
                <div class="row justify-content-around my-5">
                    {!! link_to_route('orderdrafts.index', '計画作成', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!}
{{--本物                    {!! link_to_route('orders.index', '承認済み計画表示', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button', 'disabled']) !!} --}}
                    {!! Form::button('承認済計画表示', ['class' => 'btn btn-outline-dark col-4', 'disabled']) !!}


                </div>
