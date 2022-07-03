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
                //期間中の日付をdate型の配列にする。
                $dates=setDates($date, $end, $date_count);
                //指定期間の各日が提出済みか確認                
                $order_exists = ifOrderExists($dates, $store->id);
/*                foreach($dates as $date){
                    $order_exists[$date->format('Y-m-d')]=Order::where('store_id', $store->id)
                    ->where('deliver_date', $date)->exists();
                }
 */               
                //現在有効な商品を取得
                $products = getProducts($start, $end);
                //order_drafts, ordersテーブルのデータを取得
                $orders = getOrders($store->id, $request->start, $request->end);
                //発注データを、productidとdeliverdateをキーにした配列に入れる
                $quantity=[];
                $sum=[]; 
                $total['quantity'] = 0;
                $total['price'] = 0;
                
                list($sum, $quantity) = setQuantityToDate($orders);
                //各商品の金額合計と、期間中の全商品の総合計
                foreach ($products as $product){
                    if(isset($sum[$product->id]['quantity'])){
                        $sum[$product->id]['price']=$sum[$product->id]['quantity'] * $product->lot * $product->price;
                        $total['quantity']+= $sum[$product->id]['quantity'];
                        $total['price']+=$sum[$product->id]['price'];
                    }    
                }                


                $data = [
                    'store' => $store,                  //店舗データ
                    'products' => $products,            //商品データ
                    'order_exists' => $order_exists,    //各日付の申請済みデータの有無
                    'quantity' => $quantity,            //発注数の配列
                    'sum' => $sum,                      //商品ごとの発注数と金額の合計の配列
                    'total' => $total,                  //全体の合計の配列
                    'start'=> $start,                   //date型の計画開始日
                    'end'=> $end,                       //date型の計画終了日
                    'dates' => $dates,                  //開始日から終了日までのdate型の配列
                    'date_count' => $date_count,        //日数
                ];

            }else{
                //期間が選択されていない場合は、期間、店舗の選択画面を表示する

                // ユーザの担当店舗を取得
                $user = \Auth::user();
                $stores = $user->stores()->orderBy('id')->get();
                $data = [
                    'stores' => $stores,  
//                    'start'=>""
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
        //商品が選択されている場合は、日付ごとの入力
        if($request->has('product')){
            $product = Product::findOrFail($request->product);
            //order_drafts, ordersテーブルのデータを取得
            $orders = getOrders($store->id, $request->start, $request->end, $product->id);

            $start=Carbon::createFromFormat('!Y-m-d',$request->start);
            $end=Carbon::createFromFormat('!Y-m-d',$request->end);
            $date=Carbon::createFromFormat('!Y-m-d',$request->start);                
            $date_count = 0;
            $dates=setDates($date, $end, $date_count);
            $order_exists = ifOrderExists($dates, $id);
            $sum = 0;
            $quantity=[];
            list($sum, $quantity)=setQuantityToDate($orders);
            $data = [
                'store' => $store,
                'product' => $product,
                'quantity' => $quantity,
                'dates'=>$dates,
                'order_exists' => $order_exists,    //各日付の申請済みデータの有無
                'start'=> $request->start,
                'end' => $request->end
            ];            
        //日付が選択されている場合は、商品ごとの入力
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
function setQuantityToDate($orders){
    $sum = [];
    $quantity = [];
    foreach($orders as $order){
        $quantity[$order->product->id][$order->deliver_date] = $order->quantity;
        if (isset($sum[$order->product->id])){
        $sum[$order->product->id]['quantity']+=$order->quantity;
        }else{
        $sum[$order->product->id]['quantity']=$order->quantity;
        }
    }
    return [$sum, $quantity];
}

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

function ifOrderExists($dates, $store_id){
    $order_exists=[];
    foreach($dates as $date){
    $order_exists[$date->format('Y-m-d')]=Order::where('store_id', $store_id)
    ->where('deliver_date', $date)->exists();
    }
    return $order_exists;

}

function getProducts($start, $end){
        //現在有効な商品を取得
    $products = Product::where('valid_from', '<=', $end) 
    -> where('valid_until', '>=', $start)
    -> orderBy('category_id')
    -> orderBy('price')
    ->get();

    return $products;
    
}

function getOrders($store_id, $start, $end, $product_id = null){
    //order_draftテーブルのデータを取得
    if($product_id == null){
        $order_drafts = OrderDraft::select(['store_id', 'product_id', 'deliver_date', 'quantity'])
        ->with('product:id')
        ->where('store_id', $store_id)
        ->whereBetween('deliver_date', [$start, $end]);
        //order_draftテーブルのデータを取得
        $orders = Order::select(['store_id', 'product_id', 'deliver_date', 'quantity'])
        ->with('product:id')
        ->where('store_id', $store_id)
        ->whereBetween('deliver_date', [$start, $end]);
    }else{
        $order_drafts = OrderDraft::select(['store_id', 'product_id', 'deliver_date', 'quantity'])
        ->with('product:id')
        ->where('store_id', $store_id)
        ->where('product_id', $product_id)
        ->whereBetween('deliver_date', [$start, $end]);
        //order_draftテーブルのデータを取得
        $orders = Order::select(['store_id', 'product_id', 'deliver_date', 'quantity'])
        ->with('product:id')
        ->where('store_id', $store_id)
        ->where('product_id', $product_id)
        ->whereBetween('deliver_date', [$start, $end]);
        
    }    
    //両方のデータを結合          
    $union = $order_drafts->unionAll($orders)->get();

    return $union;        
}   