@extends('adminlte::page')
@include('common')

@section('title', '在庫一覧')

@section('content_header')
    <h2>在庫一覧</h2>
@stop

@section('content')

<!-- 在庫一覧表 -->
<div class="col-auto">
    <div class="card">
        <div class="card-header">    
            <div class="card-title">在庫総数 {{number_format($totalBalance->totalBalance)}} 個</div>   
            <div class="card-title">合計在庫評価額 {{number_format($totalValuations)}} 個 </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>種別コード</th>
                        <th>商品名</th>
                        <th>平均仕入数</th>
                        <th>平均仕入単価</th>   
                        <th>平均出荷数</th>
                        <th>平均出荷単価</th>
                        <th>定価</th>
                        <th>在庫数</th>
                        <th>在庫回転率</th>
                    </tr>
                </thead>
                <tbody>
                   
                <?php  $i=0; ?>
                 @foreach($items as $item)
                        <tr>
                            <td>{{$item->item_code}}</td>
                            <td><a href="/inventories/{{$item->id}}">{{$item->item_name}}</a></td>
                            <td>{{$item->item_number}}</td>
                            <td>{{$item->category}}</td>
                            <td>{{$item->brand}}</td>                     
                            <td>{{number_format($item->list_price)}}円</td>
                            <td>{{number_format($balances[$i]->balances)}}個</td>
                            <td>{{number_format($tempUnitPrices[$item->id])}}円</td>
                            <td>{{number_format($tempValuations[$item->id])}}円</td>
                        </tr>
                <?php $i++ ?>
                  @endforeach             
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer>
    <div>{{$items->appends(request()->query())->links('pagination::bootstrap-4')}} </div>
</footer>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
