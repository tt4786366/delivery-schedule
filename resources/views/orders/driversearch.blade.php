
<script type="text/javascript">
$(function(){
    $('.form-check-input').click(function() {
        if ($("input[name=option]:checked").val() == 1) {
            $("#start").prop("disabled", false);
            $("#end").prop("disabled", false);
            $("#list").find('input').prop("disabled",true);
        }else{
            $("#start").prop("disabled", true);
            $("#end").prop("disabled", true);
            $("#list").find('input').prop("disabled",false);
        }
    });
});
</script>

                {!! Form::open(['route' => 'orders.index', 'method'=>'get']) !!}
                <div class="form-group">
            
                    <div class="row justify-content-center  my-4">
                        <div class="col-1"></div>
                        <div class="col-4">
                            {{Form::radio('option', 1, false, ['class'=>'form-check-input', 'checked'])}}
                            {{Form::label('option', '計画確認', ['class' => 'col-4'])}}<br>
                        </div>
                        <div class="col-7"></div>
                        <div class="col-2"></div>
                        <div class="col-2"><P>納品日：</P></div>
                        <div class="col-8">
                            {{Form::date('start', \Carbon\Carbon::tomorrow(), ['class'=>'date', 'id'=>'start'])}}～
                            {{Form::date('end', \Carbon\Carbon::tomorrow(), ['class'=>'date', 'id' => 'end'])}}
                        </div>
                        <div class="col-1"></div>
                        <div class="col-5">
                    
                        {{Form::radio('option', 2, false, ['class'=>'form-check-input', ''])}}
                        {{Form::label('option', '納品リスト', ['class' => 'col-4'])}}<br>    
                        </div>
                        <div class="col-6"></div>

                    </div>
                    <div class="row justify-content-center  my-4" id="list">
                        <div class="col-2"></div>
            
                        <div class="col-2"><P>納品日：</P></div>
                        <div class="col-8">
                            {{Form::date('start', \Carbon\Carbon::tomorrow(), ['class'=>'date', 'id'=>'start', 'disabled'])}}
                        </div>
                        <br>
                        <div class="col-2"></div>
                        <div class="col-2"><P>店舗：</P></div>
                        <div class="col-8" >

                            @foreach (\Auth::user()->stores as $store)

                            <div class="form-check form-check-inline">                            
                                {{Form::checkbox('store', $store->id, false, ['class'=>'form-check-input', 'disabled'])}}
                                {{Form::label('store', $store->name, ['class' => 'form-check-label' ])}}
                            </div>
                            @endforeach
                            <div class="col-3"></div>

                            @foreach  (\Auth::user()->team->users as $user)
                                @if($user->id != \Auth::user()->id)
                                @foreach ($user->stores as $store)
    
                                <div class="form-check form-check-inline">                            
                                    {{Form::checkbox('store', $store->id, false, ['class'=>'form-check-input','disabled'])}}
                                    {{Form::label('store', $store->name, ['class' => 'form-check-label' ])}}
                                </div>
                                @php
                                $checked = '';
                                @endphp
                                @endforeach
                                <br>
                                @endif
                            
                            @endforeach
                        </div>
                        <div class="col-2"></div>
                        <div class="col-2 mt-3" ><P>積載場所：</P></div>
                        <div class="col-8 mt-3">
                            @foreach ($factories as $factory)

                            <div class="form-check form-check-inline">                            
                                {{Form::checkbox('factory', $factory->id, false, ['class'=>'form-check-input', 'disabled'])}}
                                {{Form::label('factory', $factory->name, ['class' => 'form-check-label' ])}}
                            </div>
                            @endforeach                            
                        </div>
                        <div class="col-3"></div>

                    </div>

                   <div class="row justify-content-around  my-5">
                        {!! Form::submit('表示', ['class' => 'btn btn-outline-dark col-4']) !!}
                        {!! Form::button('戻る', ['class' => 'btn btn-outline-dark col-4', 'onClick' => 'history.back();']) !!}
                    </div>
                </div>
                {!! Form::close() !!}