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

    // 3. 第1期(2022)の売上を計算  
        
            // システム導入初期日
            $initialDate = date("2022-01-01"). " 00:00:00";

            // 第1期を取得
            $priorYearStart = date("2022-01-01"). " 00:00:00";
            $priorYearEnd = date("2022-12-31"). " 23:59:59";;

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
     
    //   4. 前期(Year1)の利益を計算  
     
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
           
            // 前期売上から前期売上原価を控除して前期利益を計算     
            $priorProfits=[];
            foreach ($priorRevenues as $key => $value) {
                     $priorProfits[$key] = $value - $priorCostOfSales[$key];
                }

            // 前期売上高 （全商品）                                
            $totalPriorProfit = array_sum($priorProfits);
                
    //  5. 当期(Year2)の利益を計算  

            // 前期末在庫数
            $historicalYears = [$initialDate, $priorYearEnd];
        
            $tempEndBalances = Inventory::where('inventories.status', 'active')
                                        ->whereBetween('created_at', $historicalYears)
                                        ->select('item_id')
                                        ->selectRaw('SUM(in_quantity) - SUM(out_quantity) AS endBalances')
                                        ->groupBY('item_id') 
                                        ->get();

            $endBalances = [];
            foreach ($tempEndBalances as $b){
                $endBalances[$b->item_id]=$b->endBalances;
            }                       
            
            // 前期末単価
            $tempEndUnitPrices = Inventory::where('inventories.status', 'active')
                                        ->whereBetween('created_at', $historicalYears)
                                        ->select('item_id')
                                        ->selectRaw('SUM(in_amount)/SUM(in_quantity) AS endUnitPrices')
                                        ->groupBY('item_id') 
                                        ->get();

            $endUnitPrices = [];
            foreach ($tempEndUnitPrices as $up){
                $endUnitPrices[$up->item_id]=$up->endUnitPrices;
                }                       

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
                                        ->selectRaw('SUM(in_amount - out_amount) AS inQuantities')
                                        ->groupBY('item_id') 
                                        ->get();

            $inQuantities = [];
            foreach ($tempInQuantities as $iq){
            $inQuantities[$iq->item_id]=$iq->inQuantities;
            }          

            // 前期末在庫評価額の計算     
            $priorValuations=[];
            foreach ($endBalances as $key => $value) {
                    $priorValuations[$key] = $value*$endUnitPrices[$key];
            }
        

            // 当期の在庫評価額 = 前期末在庫評価額+当期仕入額     
            $currentValuations=[];
            foreach ($priorValuations as $key => $value) {
                    $currentValuations[$key] = $value + $inAmounts[$key];
            }

            // 当期の在庫数 = 前期末在庫数+当期仕入数   
            $currentQuantities=[];
            foreach ($endBalances as $key => $value) {
                    $currentQuantities[$key] = $value + $inQuantities[$key];
            }

             // 当期の売上原価   
             $currentCostOfSales=[];
             foreach ($currentValuations as $key => $value) {
                     $currentCostOfSales[$key] = $value/$currentQuantities[$key];
             }

            // 当期の利益   
            $currentProfits=[];
            foreach ($currentRevenues as $key => $value) {
                    $currentProfits[$key] = $value - $currentCostOfSales[$key];
            }

            $totalCurrentProfit = array_sum($currentProfits);

            // dd($totalCurrentProfit); 

 //  6. 当月の前年同月比を計算する
 
         // 前年同月を取得
         $priorMonthStart = date("Y-m-01", strtotime('-1 year', strtotime('-1 month'))). " 00:00:00";
         $priorMonthEnd = date("Y-m-t", strtotime('-1 year', strtotime('-1 month'))). " 23:59:59";
         $priorMonth = [$priorMonthStart, $priorMonthEnd];

         // 前年同月売上高(DBより取得)
         $totalPriorMonthRevenue = Inventory::where('inventories.status', 'active')
                                         ->whereBetween('created_at', $priorMonth)
                                         ->sum('out_amount');
    
        if(!($totalPriorMonthRevenue == 0)){
           $yoyMonthRevenue = ($totalMonthRevenue - $totalPriorMonthRevenue)/$totalPriorMonthRevenue*100;
            }
        else{
            $yoyMonthRevenue = '-';
        }

    // 7. 当期売上と前期売上の比率を比較（達成率）
 
    if(!($totalCurrentRevenue == 0)){
        $yoyCurrentRevenue = ($totalCurrentRevenue - $totalPriorRevenue)/$totalPriorRevenue*100;
         }
     else{
         $yoyCurrentRevenue = '-';
     }

    // 8. 当期利益と前期利益の比率を比較（達成率）
 
    if(!($totalCurrentProfit == 0)){
        $yoyCurrentProfit = ($totalCurrentProfit - $totalPriorProfit)/$totalPriorProfit*100;
         }
     else{
         $yoyCurrentProfit = '-';
     }

    //  dd($yoyCurrentProfit);

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
                'currentProfits',
                'totalCurrentProfit',
                'yoyMonthRevenue',
                'yoyCurrentRevenue',
                'yoyCurrentProfit',
            ));
    }

}
