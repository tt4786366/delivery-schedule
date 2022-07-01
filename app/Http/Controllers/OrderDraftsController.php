<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Product;
use App\OrderDraft;
use App\Order;
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
                $dates=setDates($date, $end, $date_count);
                
                $order_exists=[];
                foreach($dates as $date){
//                    dd($date->format('Y-m-d'));
                    $order_exists[$date->format('Y-m-d')]=Order::where('store_id', $store->id)
                    ->where('deliver_date', $date)->exists();
    
                }

                
                $products = Product::with(['order_drafts' => function($query) use($start, $end, $store){
                return $query-> whereBetween('deliver_date',[$start, $end]) -> where('store_id', $store->id)-> orderBy('deliver_date');}])
                ->where('valid_from', '<=', $end) 
                -> where('valid_until', '>=', $start)
                -> orderBy('category_id')
                -> orderBy('price')
                ->get();

                $index = 0;
                $quantity=[];
                $sum=[]; 
                $total['quantity'] = 0;
                $total['price'] = 0;
                
                foreach($products as $product){
                    $sum[$index]['quantity']=0;
                    $quantity[$index]=[];
                    setQuantityToDate($product->order_drafts,$sum[$index]['quantity'],$quantity[$index]);

//                    list($quantity[$index],$sum[$index]['quantity'])=setQuantityToDate($product->order_drafts);
                    $sum[$index]['price']=$sum[$index]['quantity'] * $product->lot * $product->price;
                    $total['quantity']+= $sum[$index]['quantity'];
                    $total['price']+=$sum[$index]['price'];
                    $index++;
    
                }



            $data = [
                'store' => $store,
                'products' => $products,
                'order_exists' => $order_exists,
                'quantity' => $quantity,
                'sum' => $sum,
                'total' => $total,
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
            $store = Store::findOrFail($id);

        if($request->has('product')){
            $product = Product::findOrFail($request->product);
            $order_drafts=OrderDraft::where('product_id', $product->id)
            ->where('store_id', $id)
            ->whereBetween('deliver_date', [$request->start, $request->end])
            ->orderBy('deliver_date')
            ->get();
            $start=Carbon::createFromFormat('!Y-m-d',$request->start);
            $end=Carbon::createFromFormat('!Y-m-d',$request->end);
            $date=Carbon::createFromFormat('!Y-m-d',$request->start);                
            $date_count = 0;
            $dates=setDates($date, $end, $date_count);
            $sum = 0;
            $quantity=[];
            setQuantityToDate($order_drafts, $sum, $quantity);
            //list($quantity,$sum)=setQuantityToDate($order_drafts);
            
            $data = [
                'store' => $store,
                'product' => $product,
                'quantity' => $quantity,
                'dates'=>$dates,
                //'order_drafts'=>$order_drafts,
                'start'=> $request->start,
                'end' => $request->end
            ];            

        }else{
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

    public function store(Request $request){
    $order_drafts=OrderDraft::where('store_id', $request->id)
    ->whereBetween('deliver_date', [$request->start, $request->end])
    ->orderBy('deliver_date')
    ->get();

        foreach($order_drafts as $order_draft){    

            Order::Create(
                ['store_id' => $order_draft->store_id, 
                'product_id' => $order_draft->product_id, 
                'deliver_date'=> $order_draft->deliver_date, 
                'quantity' => $order_draft->quantity]
            );
        }
    OrderDraft::where('store_id', $request->id)
    ->whereBetween('deliver_date', [$request->start, $request->end])
    ->orderBy('deliver_date')
    ->delete();    
        return redirect()->route('orderdrafts.index',  ['start'=>$request->start, 'end' =>$request->end, 'store'=> $request->id]);

    }
    
    Public function update(Request $request, $id)
    {
        if ($request->has('date')){
            $deliver_date = $request->date;
            $products = $request->products; // 配列で取得できるはず
            foreach ($products as $product) {
                  upsertOrDelete($id, $product['id'],$deliver_date,$product['quantity']);
            }    
        }else{
            $deliver_dates=$request->dates;
            $quantity= $request->quantity;
            $product=$request->product;
            $index=0;
            foreach ($deliver_dates as $deliver_date) {
                  upsertOrDelete($id, $request->product,$deliver_date,$quantity[$index]);
                  $index++;
            }    

        }
        return redirect()->route('orderdrafts.index',  ['start'=>$request->start, 'end' =>$request->end, 'store'=> $id]);
       // return redirect()->route('redirect_to', ['user_name' => 'taro', 'age' => 30]);
    }
}

//計画作成期間分の日付を配列にする。
function setDates($date, $end, &$date_count){
//    $date=Carbon::createFromFormat('!Y-m-d',$start);                
    $dates=array();
    while($date->lte($end)){
        $dates[]=clone $date;
        $date->addDay();
        $date_count++;
    }
    return $dates;

}

//日付をキーとする連想配列に、発注数をセットし、配列と合計を返す

function setQuantityToDate($orders, &$sum, &$quantity){

    foreach($orders as $order){
        $quantity[$order->deliver_date] = $order->quantity;
        $sum+=$order->quantity;
    }
    return;
}
/*
function setQuantityToDate($order_drafts){
    $sum = 0;
    $quantity=[];
    foreach($order_drafts as $order_draft){
        $quantity[$order_draft->deliver_date] = $order_draft->quantity;
        $sum+=$order_draft->quantity;
    }
    return [$quantity, $sum];
}
*/
//データが入力されていれば、データを追加または更新。空白又は0ならデータを削除する。
function upsertOrDelete($store_id,$product_id,$deliver_date,$quantity){
        if ($quantity != 0 && $quantity!=null){

            OrderDraft::updateOrCreate(
                ['store_id' => $store_id, 'product_id' => $product_id, 'deliver_date'=> $deliver_date],
                ['quantity' => $quantity]
            );
        }else{
            OrderDraft::where('store_id', $store_id)-> where('product_id', $product_id) -> where('deliver_date', $deliver_date)->delete();
        }
        return;             
}    
