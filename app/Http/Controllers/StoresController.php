<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\StoreChain;
use App\User;
class StoresController extends Controller
{
      public function index()
    {
        // 店舗一覧を取得
        $stores = Store::with('store_chain')
        ->orderBy('chain_id')
        ->get();

        // 店舗一覧ビューでそれを表示
        return view('stores.index', [
            'stores' => $stores,
        ]);
    }
    
    public function create()
    {
        $chains = StoreChain::all();
        $users = User::where('authorization',2)
        ->orderBy('team_id')
        ->get();
        
        return view('stores.create', [
            'chains' => $chains,
            'users' => $users,
        ]);
    }    
    
    public function store(Request $request)
    {
        
        $request->validate([
            'chain_id'  => 'required',
            'name' => 'required|max:255',
            'store_number' => 'max:40',
            'user_id' => 'required',            
            'valid_from' => 'required',
            
        ]);

        Store::create([
            'name' => $request->name,
            'chain_id' => $request->chain_id,
            'store_number' => $request->store_number,
            'user_id' => $request->user_id,
            'valid_from'=>$request->valid_from,
            'valid_until'  => $request->valid_until,
        ]);
       // return redirect()->route('stores.index');
       return back();
    }
    
}
