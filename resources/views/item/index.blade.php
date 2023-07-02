@extends('adminlte::page')

@section('title', '取扱商品一覧')

@section('content_header')
    <h1>取扱商品一覧</h1>
@stop

@section('content')

<div>商品検索</div>

{{-- 
    <label for="">カテゴリー
<div>
<select name="category" data-toggle="select">
<option value="">全て</option>
@foreach ($categories_list as $categories_item)
<option value="{{ $categories_item->getCategory() }}" @if($category=='{{ $categories_item->getCategory() }}') selected @endif>{{ $categories_item->getCategory() }}</option>
@endforeach
</select>
/div>
</label>  
--}}


<br>

    <div class="row">
        <div class="col-12">
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
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
