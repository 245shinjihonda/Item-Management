<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
        // dd($id);
        // exit;
        $item = Item::where('id', '=' ,$request->id)
                        ->first();

        $recordInventories = Inventory::
                            where('status', 'active')->
                            where('item_id', $request->id)->
                            get();

        return view('inventory.record', compact('item', 'recordInventories'));
    }

    // 出入荷を登録するフォームを表示する
    public function InventoryUpdate(Request $request, $id)
    {
        $item = Item::where('id', '=' ,$request->id)->first();

        return view('inventory.update', compact('item'));
    }

    // 出入荷記録を登録する
    public function InventoryInput(Request $request)
    {
         Inventory::create([
            'user_id' => Auth::user()->id,
            'item_id' => $request->item_id,
            'in_quantity' => $request->in_quantity,
            'in_unit_price' => $request->in_unit_price,
            'in_amount' => $request->in_amount,
            'out_quantity' => $request->out_quantity,
            'out_unit_price' => $request->out_unit_price,
            'out_amount' => $request->out_amount,
        ]);

    // dd("/inventories/$request->item_id");
    // exit;

        return redirect('/inventories/'.$request->item_id);
    }

}
