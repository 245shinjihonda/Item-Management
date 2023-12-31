<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
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
          
        $codes = Code::where('status','active')
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
                    'in_quantity' => '0',
                    'in_unit_price' => '0',
                    'in_amount' => '0',
                    'out_quantity' => '0',
                    'out_unit_price' => '0',
                    'out_amount' => '0',
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

    // 商品情報更新画面を表示する

    public function ItemEdit(Request $request, $id)
        {
            $codes = Code::where('status','active')
                            ->get(); 
        
            $item = Item::where('id', '=' ,$request->id)
                            ->first();
            
            return view('item.edit', compact('codes', 'item'));
        }  

    // 商品情報を更新を表示する

    public function ItemUpdate(Request $request, $id)
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
            
            $item = Item::where('id', '=' ,$request->id)
                            ->first();

            $codes = Code::where('status','active')
                            ->get(); 

            // 商品コードと商品番号が変更されていない場合
            if(($item->item_code == $request->item_code) && ($item->item_number == $request->item_number))
                {
                    $item->category = $request->category;
                    $item->brand = $request->brand;
                    $item->item_name = $request->item_name;
                    $item->list_price = $request->list_price;
        
                $item->save();
                return redirect('/inventories/'.$request->id);

                }

        // 商品コード又は商品番号が変更されている場合
        elseif(!Item::where('item_code', '=' ,$request->item_code)
                        ->where('item_number', '=' ,$request->item_number)
                        ->exists())
            {                  
                    $item->item_code = $request->item_code;
                    $item->item_number = $request->item_number;
                    $item->category = $request->category;
                    $item->brand = $request->brand;
                    $item->item_name = $request->item_name;
                    $item->list_price = $request->list_price;
                    $item->update();
                    
            return redirect('/inventories/'.$request->id);
            } 

        // 変更された商品コードと商品番号の組み合わせが既存のものと一致していた場合                      
        else{
            $error_existingItem = 'その商品コードと商品番号の組み合わせはすでに登録されています。';
            return view('item.edit', compact('error_existingItem', 'item', 'codes'));
        }
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

        $items= $query->when($code, function($query) use ($code){
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

        foreach($items as $item){
            if($item->status == 'active'){
                $item->status = '商品取扱中';
            }
            else{
            $item->status = '取扱終了';
            }
        }

        return view('item.index',$items,compact('items', 'codes'));
    }

    public function ItemDownload(){

        $items = Item::all();

        //ストリームを書き込みモードで開く
        $stream = fopen('php://temp', 'w');   

        //CSVファイルのカラム（列）名の指定
        $arr = array('status', 'item_code', 'item_number', 'category',
                        'brand', 'item_name', 'list_price', 'created_at', 'updated_at');           

       //1行目にカラム（列）名のみを書き込む（繰り返し処理には入れない）
        fputcsv($stream, $arr);  

        foreach ($items as $item) {
            
            $arrInfo = array(
                'status' => $item->status,
                'item_code' => $item->item_code,
                'item_number' => $item->item_number,
                'category' => $item->category,
                'brand' => $item->brand,
                'item_name' => $item->item_name,
                'list_price' => $item->list_price,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                );
            fputcsv($stream, $arrInfo);       //DBの値を繰り返し書き込む
        }

        //ファイルポインタを先頭に戻す
        rewind($stream);  

        //ストリームを変数に格納
        $csv = stream_get_contents($stream);  

        //文字コードを変換
        $csv = mb_convert_encoding($csv, 'sjis-win', 'UTF-8');   

        //ストリームを閉じる
        fclose($stream);                      

        //ヘッダー情報を指定する
        $headers = array(                     
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=item_list.csv'
        );

        //ファイルをダウンロードする
        return Response::make($csv, 200, $headers);   

    }

}

