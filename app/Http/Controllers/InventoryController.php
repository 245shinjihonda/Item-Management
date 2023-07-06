<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    // 画面遷移後に在庫記録を全体を表示する
    public function InventoryRecord(Request $request, $id)
    {
       
        $item = Item::where('id', '=' ,$request->id)
                ->first();
                
        $itemInventory = Inventory::where('item_id', '=' ,$request->id)
                ->first();

        // dd($itemInventory->item_id);

        if(isset($itemInventory->item_id)){

            // 全出入荷記録
            $recordInventories = Inventory::   
                                where('item_id', $itemInventory->item_id)                             
                                ->latest()->paginate(10);

            // 当月を取得
            $currentStart = date("Y-m-01"). " 00:00:00";
            $currentEnd = date("Y-m-t"). " 23:59:59";
            $currentMonth = [$currentStart, $currentEnd];

            // dd($currentMonth);

            // 現在の在庫の単価を取得
            $totalInAmount = Inventory::   
                                    where('item_id', $request->id)                      
                                    ->sum('in_amount');
            $totalInQuantity = Inventory::   
                                    where('item_id', $request->id)                      
                                    ->sum('in_quantity');
            $totalOutQuantity = Inventory::   
                                    where('item_id', $request->id)                      
                                    ->sum('out_quantity');
            
            // 現在の在庫数
            $currentQuantity  = ($totalOutQuantity - $totalInQuantity);

            // 現在の在庫単価
            $currentUnitPrice= $totalInAmount/$totalInQuantity;

            // 当月の出荷数
            $currentOutQuantity = Inventory::
                            where('item_id', $request->id)
                            ->whereBetween('created_at', $currentMonth)
                            ->sum('out_quantity');
        
            // 当月の売上原価
            $currentCostOfSale = $currentUnitPrice*$currentOutQuantity;

            // 現在の在庫評価額
            $currentValuation =$currentUnitPrice*$currentQuantity;
        
            // dd($currentCostOfSale);

            // 当月売上高
            $currentRevenue = Inventory::
                        where('item_id', $request->id)
                        ->whereBetween('created_at', $currentMonth)
                        ->sum('out_amount');

            // 当月利益         
            $currentProfit = ($currentRevenue - $currentCostOfSale);

            // $profit = DB::table('inventories')
            // ->select(DB::raw('sum(out_amount - in_amount) as value'))
            // ->get()->first();
            // SELECT sum(out_amount - in_amount) FROM inventories
            // bladeでの記載方法{{number_format($profit->value)}}

            // dd($currentProfit);
            // exit;

            return view('inventory.record', compact('item', 'recordInventories', 'currentRevenue', 'currentProfit',
            'currentQuantity', 'currentUnitPrice', 'currentValuation'));
        }

        return redirect('items/')->with('flashmessage', '在庫記録はありません。');
    }

    // 検索ボタンをクリック後に検索期間を対象として在庫記録を表示する

    public function InventorySearch(Request $request, $id)
    {
        // dd($id);
        // exit;
        $item = Item::where('id', '=' ,$request->id)
                        ->first();

        $from = $request->input('from');
        $until = $request->input('until');
        $period = [$from, $until];
        $query = Inventory::query();

        $recordInventories = $query->where('item_id', $request->id)                      
                                    ->whereBetween('created_at', $period)
                                   ->latest()->paginate(20);
  
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

        return redirect('/inventories/'.$request->item_id);
    }

}
