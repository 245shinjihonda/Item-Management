<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    // 利用者一覧を表示する。
    public function UserList()
    {
        // 利用者一覧取得
        $items = Item
            ::where('items.status', 'active')
            ->select()
            ->get();

        return view('user.list', compact('items'));
    }

    // 利用者登録画面を表示する。
    public function UserAdd()
    {
        // 利用者一覧取得
        // $items = Item
        //     ::where('items.status', 'active')
        //     ->select()
        //     ->get();

        return view('user.add');
    }

    // 利用者削除画面を表示する。
    public function UserDelete()
    {
        // 利用者一覧取得
        $items = Item
            ::where('items.status', 'active')
            ->select()
            ->get();

            return view('user.delete', compact('items'));
    }



}
