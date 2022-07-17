<?php
namespace App\Http\Controllers;

use App\Order;
use App\User;
use App\Product;
use App\OrderDraft;
trait OrderTrait{    


    //計画作成期間分の日付を配列にする。
    public function setDates($date, $end, &$date_count){
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
        if (\Auth::user()->authorization==1){
            if ($quantity != 0 && $quantity!=null){
    
                Order::updateOrCreate(
                    ['store_id' => $store_id, 'product_id' => $product_id, 'deliver_date'=> $deliver_date],
                    ['quantity' => $quantity]
                );
            }else{
                Order::where('store_id', $store_id)-> where('product_id', $product_id) -> where('deliver_date', $deliver_date)->delete();
            }
        }else{
            if ($quantity != 0 && $quantity!=null){
    
                OrderDraft::updateOrCreate(
                    ['store_id' => $store_id, 'product_id' => $product_id, 'deliver_date'=> $deliver_date],
                    ['quantity' => $quantity]
                );
            }else{
                OrderDraft::where('store_id', $store_id)-> where('product_id', $product_id) -> where('deliver_date', $deliver_date)->delete();
            }
        }


            return;             
    }    
    
    function ifOrderExists($dates, $store_id){
        $order_exists=[];
        foreach($dates as $date){
            if (\Auth::user()->authorization==2){
                $order_exists[$date->format('Y-m-d')]=Order::where('store_id', $store_id)
                ->where('deliver_date', $date)->exists();
            }else{
                $order_exists[$date->format('Y-m-d')]=OrderDraft::where('store_id', $store_id)
                ->where('deliver_date', $date)->exists();
                
            }
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
            if (\Auth::user()->authorization==2){
            $order_drafts = OrderDraft::select(['store_id', 'product_id', 'deliver_date', 'quantity'])
           // ->with('product:id')
            ->where('store_id', $store_id)
            ->whereBetween('deliver_date', [$start, $end]);
            }
            //order_draftテーブルのデータを取得
            $orders = Order::select(['store_id', 'product_id', 'deliver_date', 'quantity'])
            //->with('product:id')
            ->where('store_id', $store_id)
            ->whereBetween('deliver_date', [$start, $end]);
            
        }else{
            if(\Auth::user()->authorization==2){
            $order_drafts = OrderDraft::select(['store_id', 'product_id', 'deliver_date', 'quantity'])
            //->with('product:id')
            ->where('store_id', $store_id)
            ->where('product_id', $product_id)
            ->whereBetween('deliver_date', [$start, $end]);
            }
            //order_draftテーブルのデータを取得
            $orders = Order::select(['store_id', 'product_id', 'deliver_date', 'quantity'])
            //->with('product:id')
            ->where('store_id', $store_id)
            ->where('product_id', $product_id)
            ->whereBetween('deliver_date', [$start, $end]);
            
        }    
        //両方のデータを結合
        if(\Auth::user()->authorization==2){
            $union = $order_drafts->unionAll($orders)->get();
        }else{
            $union = $orders->get();
        }
        return $union;        
    }   
    

    function getProduct($product_id){
        return Product::findOrFail($product_id);     
    }
}