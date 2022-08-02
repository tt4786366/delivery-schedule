<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Order;
use Carbon\Carbon;
use App\Store;
use App\Product;
use App\Factory;
require_once 'OrderTrait.php';

class OrdersController extends Controller
{
    use OrderTrait;
     public function index(Request $request)
    {

        $data = [];
        
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $authorization = \Auth::user()->authorization;

            if ($request->has('start')){
                if ($request->has('user')){
                    $user=$request->user;
                }else {
                    $store = Store::findOrFail($request->store);
                    $user=$store->user->id;
                }

                $start=Carbon::createFromFormat('!Y-m-d',$request->start);
                $end=Carbon::createFromFormat('!Y-m-d',$request->end);
                $date=Carbon::createFromFormat('!Y-m-d',$request->start);                
                $date_count = 0;
                $stores = Store::where('user_id', $user)
                ->orderBy('chain_id', 'asc')
                ->orderBy('id')->get();
                switch ($authorization){
                    case 1:
                    if (isset($store)==false){
                        $store = $stores[0];
                    }
    
                    break;
                    case 2:
                        $store = Store::findOrFail($request->store);

                        break;
                    case 3:
                        break;
                    default:
                }

                //期間中の日付をdate型の配列にする。
                $dates=$this->setDates($date, $end, $date_count);
                //指定期間の各日が提出済みか確認                
                $order_exists = $this->ifOrderExists($dates, $store->id);
                //現在有効な商品を取得
                $products = $this->getProducts($start, $end);
                //order_drafts, ordersテーブルのデータを取得
                $orders = $this->getOrders($store->id, $request->start, $request->end);
                //発注データを、productidとdeliverdateをキーにした配列に入れる
                $quantity=[];
                $sum=[]; 
                $total['quantity'] = 0;
                $total['price'] = 0;
                
                list($sum, $quantity) = $this->setQuantityToDate($orders);
                //各商品の金額合計と、期間中の全商品の総合計
                foreach ($products as $product){
                    if(isset($sum[$product->id]['quantity'])){
                        $sum[$product->id]['price']=$sum[$product->id]['quantity'] * $product->lot * $product->price;
                        $total['quantity']+= $sum[$product->id]['quantity'];
                        $total['price']+=$sum[$product->id]['price'];
                    }    
                }                


                $data = [
//                    'user' => $user,
                    'store' => $store,                  //店舗データ
                    'stores' => $stores,
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
                $factories=[];
                switch ($authorization){
                    case 1:
                        $users = User::where('authorization',2)->orderBy('team_id')->get();

                    break;
                    case 2:
//                        $stores = \Auth::user()->stores;
                        $factories = Factory::All();

                        break;
                    case 3:
                        break;
                    default:
                }
                // ユーザの担当店舗を取得
                $users = User::where('authorization',2)->orderBy('team_id')->get();
                //$stores = $user->stores()->orderBy('id')->get();
                $data = [
                    'users' => $users,  
                    'factories'=>$factories,
                ];
            }

        }

        // indexビューでそれらを表示
        return view('orders.index', $data);

    }
    
    
    public function edit(Request $request, $id)
    {
        $data=[];
            $store = Store::findOrFail($id);
        //商品が選択されている場合は、日付ごとの入力
        if($request->has('product')){
            $product = Product::findOrFail($request->product);
            //order_drafts, ordersテーブルのデータを取得
            $orders = $this->getOrders($store->id, $request->start, $request->end, $product->id);

            $start=Carbon::createFromFormat('!Y-m-d',$request->start);
            $end=Carbon::createFromFormat('!Y-m-d',$request->end);
            $date=Carbon::createFromFormat('!Y-m-d',$request->start);                
            $date_count = 0;
            $dates=$this->setDates($date, $end, $date_count);
            $order_exists = $this->ifOrderExists($dates, $id);
            $sum = 0;
            $quantity=[];
            list($sum, $quantity)=$this->setQuantityToDate($orders);
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
            $products=Product::with(['orders' => function($query) use($date, $id){
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
        return view('orders.edit', $data);
    }



    public function store(Request $request){
    Order::where('store_id', $request->id)
        ->whereBetween('deliver_date', [$request->start, $request->end])
          ->update(['approved_by' =>\Auth::user()->id ]);
    
        return redirect()->route('orders.index',  ['start'=>$request->start, 'end' =>$request->end, 'store'=> $request->id, 'user' =>$request->user]);

    }
    
    Public function update(Request $request, $id)
    {
        if ($request->has('date')){
            $deliver_date = $request->date;
            $products = $request->products; 
            foreach ($products as $product) {
                  $this->upsertOrDelete($id, $product['id'],$deliver_date,$product['quantity']);
            }    
        }else{
            $deliver_dates=$request->dates;
            $quantity= $request->quantity;
            $product=$request->product;
            $index=0;
            foreach ($deliver_dates as $deliver_date) {
                  $this->upsertOrDelete($id, $request->product,$deliver_date,$quantity[$index]);
                  $index++;
            }    

        }
        return redirect()->route('orders.index',  ['start'=>$request->start, 'end' =>$request->end, 'store'=> $id]);
    }
}
    //

