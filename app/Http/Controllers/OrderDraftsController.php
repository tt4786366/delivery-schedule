<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Product;
use App\OrderDraft;
use Carbon\Carbon;

class OrderDraftsController extends Controller
{
     public function index(Request $request)
    {

        $data = [];
        
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            if ($request->has('start')){
                $store = Store::findOrFail($request->store);
                $start=Carbon::createFromFormat('!Y-m-d',$request->start);
                $end=Carbon::createFromFormat('!Y-m-d',$request->end);
                $date=Carbon::createFromFormat('!Y-m-d',$request->start);                

                $date_count = 0;
                $dates=array();
                while($date->lte($end)){
                    $dates[]=clone $date;
                    $date->addDay();
                    $date_count++;
                }

                //$order_drafts=$store->order_drafts()
                //->whereBetween('deliver_date', [$start, $end])->get();
                $products = Product::with(['order_drafts' => function($query) use($start, $end, $store){
                return $query-> whereBetween('deliver_date',[$start, $end]) -> where('store_id', $store->id)-> orderBy('deliver_date');}])
                ->where('valid_from', '<=', $end) 
                -> where('valid_until', '>=', $start)
                -> orderBy('category_id')
                -> orderBy('price')
                ->get();

 $index = 0;
 $quantity=[];
 
foreach($products as $product){
    foreach($product->order_drafts as $order_draft){
        $quantity[$index][$order_draft->deliver_date] = $order_draft->quantity;
    }
    $index++;
    
}

                

/*                $products = Product::where('valid_from', '<=', $end) 
                -> where('valid_until', '>=', $start)
                -> orderBy('category_id')
                -> orderBy('price')->get();
*/


            $data = [
                'store' => $store,
                'products' => $products,
                'quantity' => $quantity,
                'start'=> $start,
                'end'=> $end,
                'dates' => $dates,
                'date_count' => $date_count,
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
                    'products'=>$products,
                    'start'=> $request->start,
                    'end' => $request->end
                ];            

        }
return view('order_drafts.edit', $data);
    }
    
    Public function update(Request $request, $id)
    {
        $deliver_date = $request->date;
        $products = $request->products; // 配列で取得できるはず
        foreach ($products as $product) {
 //           $productId = $product['id']; // 個別の値を取得できるはず
 //           $quantity = $product['quantity']; // (同上)
            if ($product['quantity'] != 0 && $product['quantity']!=null){
                OrderDraft::updateOrCreate(
                    ['store_id' => $id, 'product_id' => $product['id'], 'deliver_date'=> $deliver_date],
                    ['quantity' => $product['quantity']]
                );
            }else{
                OrderDraft::where('store_id', $id)-> where('product_id', $product['id']) -> where('deliver_date', $deliver_date)->delete();
                
            }
            
            
        }    

/*        $input = $request->all();
        dd($input);
        foreach($input as $key => $value){
            if (is_int($key)){
                //登録処理
            }
        }
*/        
        return redirect()->route('orderdrafts.index',  ['start'=>$request->start, 'end' =>$request->end, 'store'=> $id]);
       // return redirect()->route('redirect_to', ['user_name' => 'taro', 'age' => 30]);
    }
}