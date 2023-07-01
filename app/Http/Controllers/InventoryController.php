<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    // 在庫記録を表示する
    public function InventoryRecord(Request $request, $id)
    {
        $itemInventory = Item::where('id', '=' ,$request->id)->first();

        return view('inventory.record', compact('itemInventory'));
    }

    public function InventoryUpdate(Request $request, $id)
    {
        $updateInventory = Item::where('id', '=' ,$request->id)->first();

        return view('inventory.update', compact('updateInventory'));
    }

    public function InventoryInput(Request $request)
    {
        // 利用者一覧取得
        // $items = Item
        //     ::where('items.status', 'active')
        //     ->select()
        //     ->get();

        return view('inventory.record');
    }

}
