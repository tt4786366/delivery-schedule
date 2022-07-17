                {!! Form::open(['route' => 'orders.index', 'method'=>'get']) !!}
                <div class="form-group">
                    <div class="row justify-content-center  my-5">
                        <div class="col-3"><P>納品日：</P></div>
                        <div class="col-6">
                            {{Form::date('start', \Carbon\Carbon::tomorrow(), ['class'=>'date'])}}～
                            {{Form::date('end', \Carbon\Carbon::tomorrow(), ['class'=>'date'])}}
                        </div>
                    </div>
                    <div class="row justify-content-center  my-5">
                        <div class="col-3"><P>店舗：</P></div>
                        <div class="col-6">
                            @php
                            $checked = 'checked';
                            @endphp
                            @foreach ($users as $user)
                            {{Form::radio('user', $user->id, false, ['class'=>'circle', $checked])}}
                            {{Form::label('user', $user->name, ['class' => 'col-4'])}}<br>
                            @php
                            $checked = '';
                            @endphp
                            @endforeach
                        </div>
                    </div>                    
                   <div class="row justify-content-around  my-5">
                        {!! Form::submit('作成', ['class' => 'btn btn-outline-dark col-4']) !!}
                        {!! Form::button('戻る', ['class' => 'btn btn-outline-dark col-4', 'onClick' => 'history.back();']) !!}
                    </div>
                </div>
                {!! Form::close() !!}