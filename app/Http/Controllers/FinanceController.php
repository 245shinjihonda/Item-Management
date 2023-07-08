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
    
// 画面遷移後に在庫記録を全体を表示する
    public function RevenueIndex()
    {
    
    $items = Item::where('items.status', 'active')
                    ->select()
                    ->paginate(10);
      
    // dd($items);

    // 1. 当月の売上を計算  

            // 当月を取得
            $currentMonthStart = date("Y-m-01"). " 00:00:00";
            $currentMonthEnd = date("Y-m-t"). " 23:59:59";
            $currentMonth = [$currentMonthStart, $currentMonthEnd];

            // 当月売上高(DBより取得)
            $tempMonthRevenues = Inventory::where('inventories.status', 'active')
                                            ->whereBetween('created_at', $currentMonth)
                                            ->select('item_id')                
                                            ->selectRaw('SUM(out_amount) AS monthRevenues')
                                            ->groupBY('item_id')
                                            ->paginate(20);
       
         // 当月売上高(DBで取得した情報を商品毎に配列に格納)
        $monthRevenues = [];
            foreach ($tempMonthRevenues as $MR){
                $monthRevenues[$MR->item_id]=$MR->monthRevenues;
            }

         // 当月売上高 （全商品）                                
        $totalMonthRevenue = array_sum($monthRevenues);

    // 2. 当期の売上を計算  

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
                                        ->paginate(20);
        
        // 当期売上高(DBで取得した情報を商品毎に配列に格納)                              
        $currentRevenues = [];
        foreach ($tempCurrentRevenues as $CR){
            $currentRevenues[$CR->item_id]=$CR->currentRevenues;
        }

        // 当月売上高 （全商品）                                
        $totalCurrentRevenue = array_sum($currentRevenues);

    // 3. 前期(Year 0)の売上を計算  
        
            // 前期を取得
            $priorYearStart = date("Y-01-01", strtotime('-1 year')). " 00:00:00";
            $priorYearEnd = date("Y-12-31", strtotime('-1 year') ). " 23:59:59";
            $priorYear = [$priorYearStart, $priorYearEnd];

          // 前期売上高(DBより取得)
            $tempPriorRevenues = Inventory::where('inventories.status', 'active')
                                        ->whereBetween('created_at', $priorYear)
                                        ->select('item_id')                
                                        ->selectRaw('SUM(out_amount) AS priorRevenues')
                                        ->groupBY('item_id')
                                        ->paginate(20);

        // 前期売上高(DBで取得した情報を商品毎に配列に格納)                              
        $priorRevenues = [];
        foreach ($tempPriorRevenues as $PR){
            $priorRevenues[$PR->item_id]=$PR->priorRevenues;
        }

        // dd($priorRevenues);

        // 前期売上高 （全商品）                                
        $totalPriorRevenue = array_sum($priorRevenues);
     
    //   4. 前期(Year=0)の利益を計算  
     
            // 前期売上原価
            $tempPriorCostOfSales = Inventory::where('inventories.status', 'active')
                                        ->whereBetween('created_at', $priorYear)
                                        ->select('item_id')                
                                        ->selectRaw('SUM(in_amount)/SUM(in_quantity)*SUM(out_quantity) AS priorCostOfSales')
                                        ->groupBY('item_id')
                                        ->paginate(20);
       
            // dd($tempPriorCostOfSales);

            // 前期売上原価(DBで取得した情報を商品毎に配列に格納)                              
            $priorCostOfSales = [];
            foreach ($tempPriorCostOfSales as $PCOS){
                $priorCostOfSales[$PCOS->item_id]=$PCOS->priorCostOfSales;
            }
           
            $priorProfits=[];
            foreach ($priorRevenues as $key => $value) {
                     $priorProfits[$key] = $value - $priorCostOfSales[$key];
                }
            // 前期売上高 （全商品）                                
            $totalPriorProfit = array_sum($priorProfits);
                

            // dd($priorProfits) ; 
               


            //  dd($priorRevenues[$PR->item_id]=$PR->priorRevenues);


        //     // 現在の在庫の単価を取得
        //     $totalInAmount = Inventory::   
        //                             where('item_id', $request->id)                      
        //                             ->sum('in_amount');
        //     $totalInQuantity = Inventory::   
        //                             where('item_id', $request->id)                      
        //                             ->sum('in_quantity');
        //     $totalOutQuantity = Inventory::   
        //                             where('item_id', $request->id)                      
        //                             ->sum('out_quantity');
            
        //     // 現在の在庫数
        //     $currentQuantity  = ($totalOutQuantity - $totalInQuantity);

        //     // 現在の在庫単価
        //     $currentUnitPrice= $totalInAmount/$totalInQuantity;

        //     // 当月の出荷数
        //     $currentOutQuantity = Inventory::
        //                     where('item_id', $request->id)
        //                     ->whereBetween('created_at', $currentMonth)
        //                     ->sum('out_quantity');
        
        //     // 当月の売上原価
        //     $currentCostOfSale = $currentUnitPrice*$currentOutQuantity;

        //     // 現在の在庫評価額
        //     $currentValuation =$currentUnitPrice*$currentQuantity;
        
        //     // dd($currentCostOfSale);

        //     // 当月利益         
        //     $currentProfit = ($currentRevenue - $currentCostOfSale);

        //     // dd($currentProfit);
        //     // exit;

            return view('finance.revenue', 
            compact(
                'items',
                'monthRevenues',
                'totalMonthRevenue',
                'currentRevenues',
                'totalCurrentRevenue', 
                'priorRevenues',
                'totalPriorRevenue',
                'priorProfits',
                'totalPriorProfit',
              
            
    
            
            ));

            // return view('finance.revenue', compact('items', 'currentRevenues', 'recordInventories', 'currentProfit',
            // 'currentQuantity', 'currentUnitPrice', 'currentValuation'));
      
    }

}
