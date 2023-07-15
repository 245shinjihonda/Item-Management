<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Inventory;

class FinanceController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    public function RevenueIndex()
    {
    
        $items = Item::where('items.status', 'active')
                        ->select()
                        ->get();

        // 品目数
        $itemNumber = Item::where('items.status', 'active')
                            ->count();

        // 1. 当月売上を計算  

            // 当月を取得
            $currentMonthStart = date("Y-m-01"). " 00:00:00";
            $currentMonthEnd = date("Y-m-t"). " 23:59:59";
            $currentMonth = [$currentMonthStart, $currentMonthEnd];

            $tempMonthRevenues =  Inventory::where('inventories.status', 'active')
                                            ->whereBetween('created_at', $currentMonth)
                                            ->select('item_id')                
                                            ->selectRaw('SUM(out_amount) AS monthRevenues')
                                            ->groupBY('item_id')
                                            ->get();

            // 当月売上高(DBで取得した情報を商品毎に配列に格納)
            $monthRevenues = [];
                foreach ($tempMonthRevenues as $MR){
                    $monthRevenues[$MR->item_id]=$MR->monthRevenues;
                }

            // 当月売上高 （全商品）                                
            $totalMonthRevenue = array_sum($monthRevenues);

        // 2. 当期売上を計算する

            // 当期を取得
            $currentYearStart = date("Y-01-01"). " 00:00:00";
            $currentYearEnd = date("Y-12-31"). " 23:59:59";
            $currentYear = [$currentYearStart, $currentYearEnd];

            // 当期売上高(DBより取得)
                $tempCurrentRevenues = Inventory::where('inventories.status', 'active')
                                            ->whereBetween('created_at', $currentYear)
                                            ->select('item_id')                
                                            ->selectRaw('SUM(out_amount) AS currentRevenues')
                                            ->groupBY('item_id')
                                            ->get();
        
            // 当期売上高(DBで取得した情報を商品毎に配列に格納)                              
            $currentRevenues = [];
            foreach ($tempCurrentRevenues as $CR){
                $currentRevenues[$CR->item_id]=$CR->currentRevenues;
            }

            // 当期売上高 （全商品）                                
            $totalCurrentRevenue = array_sum($currentRevenues);

        //  3. 当期の利益を計算  
     
            // 当期仕入高
                $tempInAmounts = Inventory::where('inventories.status', 'active')
                                            ->whereBetween('created_at', $currentYear)
                                            ->select('item_id')
                                            ->selectRaw('SUM(in_amount) AS inAmounts')
                                            ->groupBY('item_id') 
                                            ->get();

            $inAmounts = [];
            foreach ($tempInAmounts as $ia){
            $inAmounts[$ia->item_id]=$ia->inAmounts;
            }  

            // 当期仕入数
                $tempInQuantities = Inventory::where('inventories.status', 'active')
                                            ->whereBetween('created_at', $currentYear)
                                            ->select('item_id')
                                            ->selectRaw('SUM(in_quantity) AS inQuantities')
                                            ->groupBY('item_id') 
                                            ->get();

            $inQuantities = [];
            foreach ($tempInQuantities as $iq){
            $inQuantities[$iq->item_id]=$iq->inQuantities;
            }        

            // 当期出荷数
                $tempOutQuantities = Inventory::where('inventories.status', 'active')
                ->whereBetween('created_at', $currentYear)
                ->select('item_id')
                ->selectRaw('SUM(out_quantity) AS outQuantities')
                ->groupBY('item_id') 
                ->get();

            $outQuantities = [];
            foreach ($tempOutQuantities as $oq){
            $outQuantities[$oq->item_id]=$oq->outQuantities;
            }        
            
            // 当期の平均仕入単価
            $currentUnitPrices=[];
            foreach ($inAmounts as $key => $value) {
                    $currentUnitPrices[$key] = $value/$inQuantities[$key];
            }

            // 当期の売上原価
            $currentCostOfSales=[];
            foreach ($outQuantities as $key => $value) {
                    $currentCostOfSales[$key] = $value*$currentUnitPrices[$key];
            }

            // 当期利益(商品毎)
            $currentProfits=[];
            foreach ($currentRevenues as $key => $value) {
                    $currentProfits[$key] = $value - $currentCostOfSales[$key];
            }
            
            // 当期利益（全商品）
            $totalCurrentProfit = array_sum($currentProfits);

        //  4. 当期の利益率を計算  
      
            // 当期利益率（各商品）
            $currentProfitRatios=[];
            foreach ($currentProfits as $key => $value) {
                    $currentProfitRatios[$key] = $value/$currentRevenues[$key]*100;
            }

            // 当期利益率（全商品）
            $totalCurrentProfitRatio = $totalCurrentProfit/$totalCurrentRevenue*100;

        // 5. 計算結果をbladeに返す。
        
        return view('finance.revenue', 
        compact(
            'items',
            'itemNumber',
            'monthRevenues',
            'totalMonthRevenue',
            'currentRevenues',
            'totalCurrentRevenue', 
            'currentProfits',
            'totalCurrentProfit',
            'currentProfitRatios',
            'totalCurrentProfitRatio'
        ));

    }

}

