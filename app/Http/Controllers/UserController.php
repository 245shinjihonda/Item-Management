<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    } 
    
    // 利用者一覧を表示する。
    public function UserList(Request $request)
    {
        //    検索の設定
        // input()は<form>で送付された<input>のname属性
        
        $keyword = $request->input('keyword');
        $query = User::query();

        // $keywordが存在すれば、$queryにif文の中の条件が設定される
        if(!empty($keyword)) {
            $query->where('email', 'LIKE', "%{$keyword}%")
            ->select()     
            ->get();
        }
                    // 利用者一覧取得
        $admiusers = User::where('users.is_admi', '1')
            ->select()
            ->get();

        $users = $query->where('users.is_admi', '0')
            ->select()
            ->get();

        return view('user.list', compact('admiusers', 'users', 'keyword'));
    }

    // 利用者登録画面を表示する。
    public function UserAddForm()
    {
        return view('user.add');
    }

    // 管理者が許可した利用者を登録する
    public function UserAdd(Request $request)
    {
        // バリデーションの設定
        // $this->validate($request, [
        // 'name' => 'required|max:255',
        // 'email' => 'required|min:5|email|unique:users',
        // 'password' => 'required|max:255|',
        // ]);

        // アカウント作成
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            //パスワードを暗号化してデータベースに保存
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);
        return redirect('/users');
    }

// dd($request->id);
        // exit;

    // 利用者がパスワードを更新する際、名前とメールアドレスを入力するフォームを表示する  
    public function UserPassword(Request $request)
    {                 
        return view('user.password');
    }

    // 利用者がパスワードを更新する際、名前とメールアドレスを入力する  
    public function UserPasswordForm(Request $request)
    {                 
         // 利用者のメールアドレスで利用者を特定する
         $passwordUser = User::where('email', '=',$request->email)->first();

         return view('user.passwordupdate', compact('passwordUser'));
    }

    // 利用者がパスワードを更新する  
    public function UserPasswordUpdate(Request $request, $id)
    {                 
        User::where('id', '=',$request->id)
            ->update(['password' => password_hash($request->password, PASSWORD_DEFAULT)]);
           
            return redirect('/users');
    }

    // 利用者削除画面を表示する。
    public function UserDeleteList()
    {
        // 利用者一覧取得
        $users = User::where('users.is_admi', '0')
        ->select()
        ->get();

        return view('user.delete', compact('users'));
    }

    // 利用者を削除する。
    public function UserDelete(Request $request, $id)
    {      
            // 対象の利用者を削除する関数       
            User::where('id', '=',$request->id)->delete();
           
            return redirect('/users');
    }

}
