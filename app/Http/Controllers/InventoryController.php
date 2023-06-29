<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    // 在庫記録を表示する
    public function InventoryRecord()
    {
        // 利用者一覧取得
        // $items = Item
        //     ::where('items.status', 'active')
        //     ->select()
        //     ->get();

        return view('inventory.record');
    }

    public function InventoryUpdate()
    {
        // 利用者一覧取得
        // $items = Item
        //     ::where('items.status', 'active')
        //     ->select()
        //     ->get();

        return view('inventory.update');
    }

    public function InventoryInput()
    {
        // 利用者一覧取得
        // $items = Item
        //     ::where('items.status', 'active')
        //     ->select()
        //     ->get();

        return view('inventory.record');
    }


    //
}
