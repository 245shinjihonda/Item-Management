<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Inventory;


class FinanceController extends Controller
{
 
    public function RevenueRecord(){

        // 商品一覧取得
        $items = Item ::where('items.status', 'active')
        ->select()
        ->get();

    return view('finance.revenue', compact('items'));

    }
  
// 画面遷移後に在庫記録を全体を表示する
    // public function RevenueCal(Request $request, $id)
    // {
    
    //     $item = Item::where('id', '=' ,$request->id)
    //             ->first();
                
    //     $itemInventory = Inventory::where('item_id', '=' ,$request->id)
    //             ->first();

    //     // dd($itemInventory->item_id);

    //     if(isset($itemInventory->item_id)){

    //         // 全出入荷記録
    //         $recordInventories = Inventory::   
    //                             where('item_id', $itemInventory->item_id)                             
    //                             ->latest()->paginate(10);

    //         // 当月を取得
    //         $currentStart = date("Y-m-01"). " 00:00:00";
    //         $currentEnd = date("Y-m-t"). " 23:59:59";
    //         $currentMonth = [$currentStart, $currentEnd];

    //         // dd($currentMonth);

    //         // 現在の在庫の単価を取得
    //         $totalInAmount = Inventory::   
    //                                 where('item_id', $request->id)                      
    //                                 ->sum('in_amount');
    //         $totalInQuantity = Inventory::   
    //                                 where('item_id', $request->id)                      
    //                                 ->sum('in_quantity');
    //         $totalOutQuantity = Inventory::   
    //                                 where('item_id', $request->id)                      
    //                                 ->sum('out_quantity');
            
    //         // 現在の在庫数
    //         $currentQuantity  = ($totalOutQuantity - $totalInQuantity);

    //         // 現在の在庫単価
    //         $currentUnitPrice= $totalInAmount/$totalInQuantity;

    //         // 当月の出荷数
    //         $currentOutQuantity = Inventory::
    //                         where('item_id', $request->id)
    //                         ->whereBetween('created_at', $currentMonth)
    //                         ->sum('out_quantity');
        
    //         // 当月の売上原価
    //         $currentCostOfSale = $currentUnitPrice*$currentOutQuantity;

    //         // 現在の在庫評価額
    //         $currentValuation =$currentUnitPrice*$currentQuantity;
        
    //         // dd($currentCostOfSale);

    //         // 当月売上高
    //         $currentRevenue = Inventory::
    //                     where('item_id', $request->id)
    //                     ->whereBetween('created_at', $currentMonth)
    //                     ->sum('out_amount');

    //         // 当月利益         
    //         $currentProfit = ($currentRevenue - $currentCostOfSale);

    //         // $profit = DB::table('inventories')
    //         // ->select(DB::raw('sum(out_amount - in_amount) as value'))
    //         // ->get()->first();
    //         // SELECT sum(out_amount - in_amount) FROM inventories
    //         // bladeでの記載方法{{number_format($profit->value)}}

    //         // dd($currentProfit);
    //         // exit;

    //         return view('inventory.record', compact('item', 'recordInventories', 'currentRevenue', 'currentProfit',
    //         'currentQuantity', 'currentUnitPrice', 'currentValuation'));
    //     }

    //     return redirect('items/')->with('flashmessage', '在庫記録はありません。');
    // }

}
