                <div class="text-center">
                    <h1>管理者処理選択</h1>
                </div>

                <div class="row justify-content-around my-5">
                    {!! link_to_route('orders.index', '納品計画', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!}
                    {!! link_to_route('users.index', 'ユーザー管理', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!} 
                </div>
                
                <div class="row justify-content-around my-5">
                {!! link_to_route('stores.index', '店舗管理', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!} 
                {!! link_to_route('products.index', '商品管理', [], ['class' => 'btn btn-outline-dark col-4', 'role'=>'button']) !!} 

                </div>
                
                
                

