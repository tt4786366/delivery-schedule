<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; 
use App\Team;

class UsersController extends Controller
{
    public function index()
    {
        // ユーザ一覧をidの降順で取得
        $teams = Team::with(['users' => function($query){
        $query->orderBy('id','asc');
        }])->orderBy('id', 'asc')->get();


        // ユーザ一覧ビューでそれを表示
        return view('users.index', [
            'teams' => $teams,
        ]);
    }
}
