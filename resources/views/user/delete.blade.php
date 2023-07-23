@extends('adminlte::page')
@include('common')

@section('title', '利用者削除')

@section('content_header')
    <h1>利用者削除</h1>
@stop

@section('content')

    <br>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">利用者一覧</h3>
                </div>

                @if (session('flashmessage'))
                <div style ="font-size: 20px; color:red;" class="flash_message">
                    {{ session('flashmessage') }}
                </div>
                @endif

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>氏名</th>
                                <th>メールアドレス</th>
                                <th>登録状況</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->status}}</td>
                                    <td><button type="sumbit" class="btn btn-default" onclick="return confirm('入力内容を削除しても良いですか？');"><a href="/users/delete/{{$user->id}}">削除</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>

@stop

@section('css')
@stop

@section('js')
@stop