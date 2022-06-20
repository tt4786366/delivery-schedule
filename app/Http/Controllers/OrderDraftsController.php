<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderDraftsController extends Controller
{
     public function index(Request $request)
    {

        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの担当店舗を取得
            $stores = $user->stores()->orderBy('id')->get();

            $data = [
                'stores' => $stores,  
            ];
        }

        // indexビューでそれらを表示
        return view('order_drafts.index', $data);





    }
    //
}
