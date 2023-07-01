<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

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

    /**
     * 商品一覧
     */
    public function ItemIndex()
    {
        // 商品一覧取得
        $items = Item
            ::where('items.status', 'active')
            ->select()
            ->get();

        return view('item.index', compact('items'));
    }

    /**
     * 商品登録
     */
    public function ItemAdd(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション

            // dd($itemcode);
            // exit;

            $this->validate($request, [
                'item_code' => 'required|size:3',
                'item_number' => 'required|size:4',
            ]);

            // if // 検索を入れる
            // $error = 既に登録すみです。

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'item_code' => $request->item_code,
                'item_number' => $request->item_number,
                'category' => $request->category,
                'brand' => $request->brand,
                'item_name' => $request->item_name,
                'list_price' => $request->list_price,
            ]);

            return redirect('/items');
        }

        return view('item.add');
        // ->with($error);
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

}
