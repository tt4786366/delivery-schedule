<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Product;

class OrderDraftsController extends Controller
{
     public function index(Request $request)
    {

        $data = [];
        
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();

            // ユーザの担当店舗を取得
            if ($request->has('start')){
                $start = $request->start;
                $end = $request->end;
                $stores = Store::findOrFail($request->store);
                $order_drafts=$stores->order_drafts()
                ->whereBetween('deliver_date', [$start, $end])->get();
                $products = Product::All()->where('valid_from', '<=', $end) 
                -> where('valid_until', '>=', $start);                
            $data = [
                'stores' => $stores,
                'products' => $products,
                'start'=> $start,
                'end'=> $end,
            ];
            }else{
                $stores = $user->stores()->orderBy('id')->get();
                $data = [
                    'stores' => $stores,  

                ];

            }


        }

        // indexビューでそれらを表示
        return view('order_drafts.index', $data);





    }
    //
}
