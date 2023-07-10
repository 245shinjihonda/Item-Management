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
    
   // 画面遷移後に在庫一覧を表示する
   
   public function InventoryIndex()
   {
        // 商品一覧取得
        $items = Item::where('items.status', 'active')
                        ->select()
                        ->orderBy('id')
                        ->get();

        // $tempCategories =[];
        // foreach ($items as $i){
        // $tempCategories[$i->id]=$i->category;
        // }

        //  1. 在庫数を計算する   

        // 各商品の現在在庫数
        $tempUpdatedBalances = Inventory::where('inventories.status', 'active')
                                ->select('item_id')
                                ->selectRaw('SUM(in_quantity) - SUM(out_quantity) AS updatedBalances')
                                ->groupBY('item_id') 
                                ->orderBY('item_id')
                                ->get();

                                 
        // 各商品の現在の在庫数の配列
        $updatedBalances = [];
        foreach ($tempUpdatedBalances as $UB){
            $updatedBalances[$UB->item_id]=$UB->updatedBalances;
            }
       
        // 全商品の在庫数の合計
        $totalUpdatedBalance = array_sum($updatedBalances);
      
        // 2. 当期取得

        $startDate = date('Y-01-01'). " 00:00:00";
        $endDate = date('Y-m-d'). " 23:59:59";
        $currentPeriod =[$startDate, $endDate];

        // 3. 当期仕入数
        $tempCurrentInQuantities = Inventory::where('inventories.status', 'active')
                                            ->where('created_at', '>=', date ('Y-01-01 00:00:00')) 
                                            ->select('item_id')
                                            ->selectRaw('SUM(in_quantity) AS currentInQuantities')
                                            ->groupBY('item_id') 
                                            ->orderBY('item_id')
                                            ->get();

        // 商品別の仕入数の配列
        $currentInQuantities = [];
            foreach ($tempCurrentInQuantities as $CIQ){
                $currentInQuantities[$CIQ->item_id]=$CIQ->currentInQuantities;
            }

        //  全商品の仕入合計数
        $totalCurrentInQuantity = array_sum($currentInQuantities);

     // 4. 当期の出荷数  
        $tempCurrentOutQuantities = Inventory::where('inventories.status', 'active')
                                            ->where('created_at', '>=', date ('Y-01-01 00:00:00')) 
                                            ->select('item_id')
                                            ->selectRaw('SUM(out_quantity) AS currentOutQuantities')
                                            ->groupBY('item_id') 
                                            ->orderBY('item_id')
                                            ->get();
        
        // 商品別の出荷数の配列
        $currentOutQuantities = [];
            foreach ($tempCurrentOutQuantities as $COQ){
            $currentOutQuantities[$COQ->item_id]=$COQ->currentOutQuantities;
            }

        //  全商品の出荷合計数
        $totalCurrentOutQuantity = array_sum($currentOutQuantities);

    //  5. 各商品の単価を計算する                           
  
        $tempUnitPrices = Inventory::where('inventories.status', 'active')
                                ->select('item_id')
                                ->selectRaw('SUM(in_amount)/SUM(in_quantity) AS unitPrices')
                                ->groupBY('item_id')
                                ->orderBY('item_id')
                                ->get();

        $unitPrices =[];
            foreach ($tempUnitPrices as $u){
            $unitPrices[$u->item_id]=$u->unitPrices;
            }

    // 6.在庫評価額の計算
        $tempValuations = Inventory::where('inventories.status', 'active')
                            ->select('item_id')
                            ->selectRaw('(SUM(in_quantity) - SUM(out_quantity))*SUM(in_amount)/SUM(in_quantity) AS valuations')
                            ->groupBY('item_id') 
                            ->orderBY('item_id') 
                            ->get();

        // $valuationsから各商品の在庫評価額を配列として取り出す
        // $vはどのようなものでも構わない
        $valuations = [];
            foreach ($tempValuations as $v){
            $valuations[$v->item_id]=$v->valuations;
            }

        // 各商品の在庫評価額の合計額
        $totalValuation = array_sum($valuations);

        return view('inventory.index', 
            compact(
                'items', 
                'updatedBalances',
                'totalUpdatedBalance',
                'currentInQuantities',
                'totalCurrentInQuantity',
                'currentOutQuantities',
                'totalCurrentOutQuantity',
                'unitPrices',
                'valuations',
                'totalValuation'
            ));
    }
       
        // 別の実装方法
        //  where id = 1
        // ↓
        // $items = Item::select('id')// 1,2,3
        
        // foreach ( $items as $item)
        //   where id = $item->id
        // endforeach （編集済み） 
         
        // $items = Item::select('id')
        // foreach ( $items as $item)
        //   where id = $item->
        // endforeach


 // inventory,recordに遷移後に個別商品の売上高、在庫数、単価、評価額を表示する
    public function InventoryRecord(Request $request, $id)
    {
         $item = Item::where('id', '=' ,$request->id)
         ->first();
         
         $itemInventory = Inventory::where('item_id', '=' ,$request->id)
             ->first();

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
            $currentQuantity  = ($totalInQuantity - $totalOutQuantity);

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
        
            // 当月売上高
            $currentRevenue = Inventory::
                        where('item_id', $request->id)
                        ->whereBetween('created_at', $currentMonth)
                        ->sum('out_amount');

            // 当月利益         
            $currentProfit = ($currentRevenue - $currentCostOfSale);

            return view('inventory.record', compact('item', 'recordInventories', 'currentRevenue', 'currentProfit',
            'currentQuantity', 'currentUnitPrice', 'currentValuation'));
            }  

        return redirect('items/')->with('flashmessage', '在庫記録はありません。');
    }

// inventory.record における操作
    // 検索ボタンをクリック後に検索期間を対象として在庫記録を表示する

    public function InventorySearch(Request $request, $id)
    {
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

    // inventory.updateにおける操作
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

