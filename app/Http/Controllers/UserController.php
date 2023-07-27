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
                    // 利用者及び管理者一覧取得
        $admiusers = $query->where('users.is_admi', '1')
                    ->where('status', 'active')
                    ->orderBy('users.email')
                    ->select()
                    ->get();

        $users = User::where('users.is_admi', '0')
                    ->where('status', 'active')
                    ->select()
                    ->orderBy('users.email')
                    ->get();

        return view('user.list', compact('admiusers', 'users', 'keyword'));
    }

    // 利用者登録画面を表示する。
    public function UserAddForm()
    {
        return view('user.add');
    }

    // 管理者登録画面を表示する。
    public function UserAdmiAddForm()
    {
        return view('user.admiadd');
    }

    // 管理者が許可した者を利用者として登録する
    public function UserAdd(Request $request)
    {
        // バリデーションの設定
        $this->validate($request, [
        'name' => 'required|max:255',
        'email' => 'required|min:5|email|unique:users',
        'password' => 'required|max:255|',
        ]);

        // 利用者アカウント作成
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_admi' => '0',
            //パスワードを暗号化してデータベースに保存
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);

        return redirect('/users');
    }

    // 管理者が許可した者を管理者として登録する
    public function UserAdmiAdd(Request $request)
    {
        // バリデーションの設定
        $this->validate($request, [
        'name' => 'required|max:255',
        'email' => 'required|min:5|email|unique:users',
        'password' => 'required|max:255|',
        ]);

        // 管理者アカウント作成
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_admi' => '1',
            //パスワードを暗号化してデータベースに保存
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);
        
        return redirect('/users');
    }
    
    // 利用者削除画面を表示する。
    public function UserDeleteList()
    {
        // 利用者一覧取得
        $users = User::where('users.is_admi', '0')
                        ->where('status', 'active')
                        ->select()
                        ->orderBY('users.email')
                        ->get();

        foreach($users as $user){
            if($user->status == 'active'){
                $user->status = '登録中';
            }
            else{
            $user->status = '登録削除済';
            }
        }

        return view('user.delete', compact('users'));
    }

    // 管理者削除画面を表示する。
    public function UserAdmiDeleteList()
    {
        // 管理者一覧取得
        $administrators = User::where('users.is_admi', '1')
                        ->select()
                        ->orderBY('users.email')
                        ->get();

        foreach($administrators as $administrator){
            if($administrator->status == 'active'){
                $administrator->status = '登録中';
            }
            else{
            $administrator->status = '登録削除済';
            }          
        }
        return view('user.admidelete', compact('administrators'));
    }

    // 利用者を削除する。
    public function UserDelete(Request $request, $id)
    {      
        $user = User::find($id);

        if($user->status == 'delete'){

            return redirect('users/delete-list')->with('flashmessage', '既に削除済です。');
            }

        $user->status = 'delete';
        $user->save();
        return redirect('/users');
    }

    // 管理者を削除する。
    public function UserAdmiDelete(Request $request, $id)
    {      
        
        $user = User::find($id);

        if($user->status == 'delete'){

            return redirect('users/admi/delete-list')->with('flashmessage', '既に削除済です。');
            }

        $user->status = 'delete';
        $user->save();
        return redirect('/users');
    }

}
