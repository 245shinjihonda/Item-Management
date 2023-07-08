<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Inventory;


class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 商品一覧
    
    public function ItemIndex()
    {
        // 商品一覧取得
    

        $items = item::latest()
                        ->paginate(10);

        return view('item.index', compact('items'));
    }


    
    //  商品登録
     
    public function ItemAdd(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post'))
        {
            // バリデーション
            $this->validate($request, [
                'item_code' => 'required|size:3',
                'item_number' => 'required|size:4',
                ]);

            // 同一番号がなれけば商品登録
            if (!Item::where('item_code', '=' ,$request->item_code)
                        ->where('item_number', '=' ,$request->item_number)
                        ->exists())
                {   
                    Item::create([
                    'user_id' => Auth::user()->id,
                    'item_code' => $request->item_code,
                    'item_number' => $request->item_number,
                    'category' => $request->category,
                    'brand' => $request->brand,
                    'item_name' => $request->item_name,
                    'list_price' => $request->list_price,
                    ]);

                    $query = Item::query();

                    $inventory_insert = $query->where('item_code', '=' ,$request->item_code)
                                                ->where('item_number', '=' ,$request->item_number)
                                        ->first();

                    Inventory:: create([

                    'user_id' => Auth::user()->id,
                    'item_id' => $inventory_insert->id,
                    'in_quantity' => '1',
                    'in_unit_price' => '0',
                    'in_amount' => '0',
                    'out_quantity' => '0',
                    'out_unit_price' => '0',
                    'out_amount' => '0',
                    ]);

                    // dd($inventory->in_quantity);
                    // exit;
    
                return redirect('/items');
                }

                // そうでなければ登録済をエラーとして返す
            else{
                $error_existingItem = 'この商品はすでに登録されています。';
                return view('item.add', compact('error_existingItem'));
            }
            
                    // 別の実装方法
                    // $item_code = $request->item_code;
                    // $item_number = $request->item_number;
        
                    // $query = Item::query();
                    // $query->where('item_code', '=' ,$item_code);
                    // $query->where('item_number', '=' ,$item_number);
                    // $existingItem = $query->first();
        
                    // if ($existingItem)
                    //     {
                    //         $error_existingItem = 'この商品はすでに登録されています。';
        
                    //         return view('item.add', compact('error_existingItem'));
        
                    //         // return view('item.add')->with('error_existingItem', $error_existingItem);
                    //     }
        }

    return view('item.add');
       
    }

    // 商品削除

    public function ItemDelete(Request $request, $id)
    {
        // 商品削除
          $item = Item::find($id);
          $item->status = 'delete';
          $item->save();
          return redirect('/items');
    }

    // 検索機能
    public function ItemSearch(Request $request)
    {
        $code = $request->input('item_code');
        $price = $request->input('list_price');

        $query = Item::query();

        $items= $query->where('status','active')
                ->when($code, function($query) use ($code){
                    $query->where('item_code', $code);
                })
                ->when($price, function($query) use ($price){
                    if($price == '10000'){
                        $query->where('list_price', '<' , 10000);
                    }
                    elseif ($price == '20000') {
                        $query->where('list_price', '>=' , 10000);
                        $query->where('list_price', '<' , 20000);
                    }
                    elseif ($price == '30000') {
                        $query->where('list_price', '>=' , 20000);
                        $query->where('list_price', '<' , 30000);
                    }
                    else{
                        $query->where('list_price', '>=' , 30000);
                    }
                })
                ->get();
                
        return view('item.index',$items,compact('items'));
    }
}

    // $items = Item
        //     ::where('items.status', 'active')
        //     ->select()
        //     ->latest()
        //     ->paginate(10);
