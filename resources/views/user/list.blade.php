@extends('adminlte::page')

@section('title', '利用者一覧')

@section('content_header')
    <h1>利用者一覧</h1>
@stop

@section('content')

<div>
<!-- <a href="{{ route('register')}}" class="btn btn-default">利用者登録</a> -->
<a href="{{ url('users/add-form') }}" class="btn btn-default">利用者登録</a>
<a href="{{ url('users/delete-list') }}" class="btn btn-default">利用者削除</a>

</div>
<br>
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">管理者一覧</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>氏名</th>
                                <th>メールアドレス</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admiusers as $admiuser)
                                <tr>
                                    <td>{{$admiuser->name}}</td>
                                    <td>{{$admiuser->email}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

     <!-- 検索機能 -->
    <div>利用者検索</div> 
    <div class="search-form">
        <form class="row g-2" action="{{ url('users') }}" method="GET">
            @csrf
            <div class="col-auto">
            <input class="form-control" type="text" name="keyword" value="{{$keyword}}">
            </div>
            <div class="col-auto">
            <input class="btn btn-success" type="submit" value="検索">
            </div>
        </form>
    </div>
    <br>

    <!-- 一覧表示・検索結果表示 -->
    <div class="list-form">
        <div>
        <?php $url = $_SERVER['REQUEST_URI']; ?>
        @if (strstr($url, 'keyword'))
            検索結果表示  <a href="{{ url('users') }}">全件表示に戻る</a>
            @else
            全件表示
        @endif
    
    <br>
    <br>

    <div class="row">
        <div class="col-8">
            <div class="card">    
                <div class="card-header">
                    <h3 class="card-title">利用者一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <!-- <a href="{{ url('users/add') }}" class="btn btn-default">利用者登録</a>
                                <a href="{{ url('users/delete') }}" class="btn btn-default">利用者削除</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>氏名</th>
                                <th>メールアドレス</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
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
