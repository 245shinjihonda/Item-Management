@extends('adminlte::page')
@include('commom')

@section('title', '取扱商品一覧')

@section('content_header')
    <h1>取扱商品一覧</h1>
@stop

@section('content')

<div class="search-form">
    <form class="row g-2" action="{{ url('items/search') }}" method="GET">
    @csrf

    <div class="col-auto">
        <input class="btn btn-success" type="submit" value="検索">
    </div>

    <div class="col-auto">
        <label for="item_code">商品コード
        <select name="item_code" data-toggle="select">
        <option value="">全て</option>
        @foreach ($items as $item)
        <option value="{{$item->item_code}}">{{$item->item_code}}</option>
        @endforeach
        </select>
        </label>  
    <div>

    <div class="col-auto">
        <label for="list_price">定価
        <select name="list_price" data-toggle="select">
        <option value="">全て</option> 
        <option value="10000">10,000円未満</option>
        <option value="20000">10,000円以上20,000円未満</option>
        <option value="30000">20,000円以上30,000円未満</option>
        <option value="30001">30,000円以上</option>
        </select>
        </label> 
    </div> 

    </form>
</div>

<br>
        <?php $url = $_SERVER['REQUEST_URI']; ?>
        @if (strstr($url, 'item_code'))
            検索結果表示 
             <!-- <a href="{{ url('items') }}">全件表示に戻る</a> -->
            @else
            全件表示
        @endif

       <?php   
        $noitem = $items->isEmpty();
        ?>
        @if($noitem)
        <div class="alert alert-danger">
        <p>該当する商品はありません。</p>
        </div>
        @endif
        <!-- if($noitem)はif($items->isEmpty())でも可 -->

<div class="col-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">取扱商品一覧</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm">
                    <div class="input-group-append">
                        <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>種別コード</th>
                        <th>商品番号</th>
                        <th>種別名</th>
                        <th>ブランド</th>   
                        <th>商品名</th>
                        <th>定価</th>
                        <th>在庫記録</th>
                        <th>出入荷入力</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->item_code}}</td>
                            <td>{{ $item->item_number }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->brand }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ number_format($item->list_price) }}円</td>
                            <td><a href="/inventories/{{$item->id}}" class="btn btn-default">確認する</a></td>
                            <td><a href="/inventories/update/{{$item->id}}" class="btn btn-default">入力する</a></td> 
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@stop

@section('css')
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
@stop
