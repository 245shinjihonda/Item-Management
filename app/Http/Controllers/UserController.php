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
    public function UserDeleteList()
    {
        // 利用者一覧取得
        $items = Item
            ::where('items.status', 'active')
            ->select()
            ->get();

            return view('user.delete', compact('items'));
    }

    public function UserDelete(Request $request)

    {
        // dd($request->id);
        // exit;

            // 対象の利用者を削除する関数
           
            Item::where('id', '=',$request->id)->delete();
            // $item->status = 'delete';
            // $item->save();
            // $items = Item::where('items.status', 'active')
            // ->select()
            // ->get();
            // $item = Item::find($id);
            // $item->status = 'delete';
            // $item->save();
            // return view('user.list', compact('items'));
            return redirect('/users');
    }

}
