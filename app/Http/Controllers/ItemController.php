<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Code;
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
        $items = item::orderBY('status','asc','item_code')
                        ->get();
    
            foreach($items as $item){
                if($item->status == 'active'){
                    $item->status = '商品取扱中';
                }
                else{
                $item->status = '取扱終了';
                }
            }
          
        $codes = code::where('status','active')
                        ->get(); 

        return view('item.index', compact('items', 'codes'));
    }

    //  商品登録
    
    public function ItemAdd(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post'))
        {
            // バリデーション
            $this->validate($request, [
                'item_code' => 'required|regex:/^[A-Z]{3}+$/',
                'item_number' => 'required|regex:/^[0-9]{4}+$/',
                'category' =>'required|max:100',
                'brand' =>'required|max:100',
                'item_name' =>'required|max:100',
                'list_price' => 'required|integer|min:1',
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
                    'in_unit_price' => '1',
                    'in_amount' => '1',
                    'out_quantity' => '1',
                    'out_unit_price' => '1',
                    'out_amount' => '1',
                    ]);

                return redirect('/items');
                }

                // そうでなければ登録済をエラーとして返す
            else{
                $error_existingItem = 'この商品はすでに登録されています。';
                return view('item.add', compact('error_existingItem'));
            }
            
        }

        // 商品のコードを取得する
        $query = Code::query();

        $codes = $query->where('status', 'active')
                        ->get();

    return view('item.add', compact('codes'));
       
    }

    // 商品削除

    public function ItemDelete(Request $request, $id)
    {
        // 商品削除
          $item = Item::find($id);

          if($item->status == 'delete'){

            return redirect('inventories/' .$item->id)->with('flashmessage', '既に取扱中止です。');
            }

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

        $codes = Code::where('status', 'active')
                        ->get();

        return view('item.index',$items,compact('items', 'codes'));
    }
}

