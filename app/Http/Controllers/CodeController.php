<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Inventory;
use App\Models\Code;

class CodeController extends Controller
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
    
    public function CodeIndex()
    {
        // 商品一覧取得
        $codes = Code::latest()
                        ->get();

        foreach($codes as $code){

            if($code->status == 'active'){
                $code->status = '商品取扱中';
            }
            else{
            $code->status = '取扱終了';
            }
        }
                        
        return view('code.index', compact('codes'));
    }

    //  Code登録
     
    public function CodeAdd(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post'))
        {
            // バリデーション
            $this->validate($request, [
                'item_code' => 'required|size:3',
                'code_name' => 'required',
                ]);

            // 同一コードがなれけば商品登録
            if (!Code::where('item_code', '=' ,$request->item_code)
                        ->exists())
                {   
                    Code::create([
                    'user_id' => Auth::user()->id,
                    'item_code' => $request->item_code,
                    'code_name' => $request->code_name,
                    ]);

                    // dd($inventory->in_quantity);
                    // exit;
    
                return redirect('/codes');
                }

                // そうでなければ登録済をエラーとして返す
            else{
                $error_existingItem = 'この種別コードはすでに登録されています。';
                return view('code.add', compact('error_existingItem'));
            }    
        }

    return view('code.add');

    }

    // 利用者削除画面を表示する。
    public function CodeDeleteList()
    {
        // 利用者一覧取得
        $codes = Code::where('status', 'active')
        ->paginate(20);

        return view('code.delete', compact('codes'));
    }
   
    // 商品削除

    public function CodeDelete(Request $request, $id)
    {
        // コード削除
          $item = Code::find($id);
          $item->status = 'delete';
          $item->save();
          return redirect('/codes');
    }

    // 検索機能
    public function CodeSearch(Request $request)
    {
        // キーワード検索を入れる
        $keyword = $request->input('keyword');

        $query = Code::query();
        if(!empty($keyword)) 
        {
            $code = $query->where('code_name', 'LIKE', "%{$keyword}%")
                    ->get();

        }

        $codes = $query->get();
    
        foreach($codes as $code)
        {
            if($code->status == 'active'){
                $code->status = '商品取扱中';
            }
            else{
            $code->status = '取扱終了';
            }
        }
        return view('code.index', compact('codes', 'keyword'));
    }
}

