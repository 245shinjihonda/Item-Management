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
            $this->validate($request, [
                'cat_number' => 'required|size:3',
                'item_number' => 'required|size:5',
            ]);

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'cat_number' => $request->cat_number,
                'item_number' => $request->item_number,
                'category' => $request->category,
                'brand' => $request->brand,
                'item_name' => $request->item_name,
                'list_price' => $request->list_price,
            ]);

            return redirect('/items');
        }

        return view('item.add');
    }

    // 商品削除

    public function ItemDelete(Request $request)
    {
        // 商品削除
        //   $item = Item::find($id);
        //   $item->status = 'delete';
        //   $item->save();
          return redirect('/items');
        
    }

}
