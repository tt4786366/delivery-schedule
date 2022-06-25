<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Product;
use Carbon\Carbon;

class OrderDraftsController extends Controller
{
     public function index(Request $request)
    {

        $data = [];
        
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            if ($request->has('start')){
                $start = $request->start;
                $end = $request->end;
                $stores = Store::findOrFail($request->store);
                $order_drafts=$stores->order_drafts()
                ->whereBetween('deliver_date', [$start, $end])->get();
                $products = Product::with('category')->where('valid_from', '<=', $end) 
                -> where('valid_until', '>=', $start)
            //    ->join('categories','products.category_id','=','categories.id')
                -> orderBy('category_id')
                -> orderBy('price')->get();
 //               $categories = Category::All();
                
            

            $data = [
                'stores' => $stores,
                'products' => $products,
 //               'categories' => $categories,
                'start'=> Carbon::createFromFormat('Y-m-d',$start),
                'end'=> Carbon::createFromFormat('Y-m-d',$end),
            ];

            }else{
                $user = \Auth::user();

            // ユーザの担当店舗を取得

                $stores = $user->stores()->orderBy('id')->get();
                $data = [
                    'stores' => $stores,  
                    'start'=>""
                ];

            }


        }

        // indexビューでそれらを表示
        return view('order_drafts.index', $data);





    }
    
    
    public function edit(Request $request, $id)
    {
        $data=[];
        if($request->has('product')){
            
        }else{
            $store = Store::findOrFail($id);
            $date=$request->date;
            $products=Product::with(['order_drafts' => function($query) use($date, $id){
                return $query-> where('deliver_date', $date) -> where('store_id', $id);}])
                -> orderBy('category_id')
                -> orderBy('price')->get();

                $data = [
                    'store' => $store, 
                    'date' => $date,
                    'products'=>$products
                ];            

        }
return view('order_drafts.edit', $data);
    }
    
    
    
}
