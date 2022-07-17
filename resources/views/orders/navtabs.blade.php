<ul class="nav nav-tabs nav-justified mb-3">
    {{-- ユーザ詳細タブ --}}

    @foreach($stores as $storelist)
    <li class="nav-item">
        <a href="{{ route('orders.index', ['store' => $storelist->id, 'start' =>$start->format('Y-m-d'), 'end' => $end->format('Y-m-d')]) }}" class="nav-link {{ $store->id == $storelist->id ? 'active' : '' }}">
            {{$storelist->name}}
            
        </a>
    </li>
    @endforeach
    {{-- フォロー一覧タブ --}}
    
</ul>