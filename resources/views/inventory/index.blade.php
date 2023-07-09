@extends('adminlte::page')
@include('common')

@section('title', '在庫一覧')

@section('content_header')
    
@stop

@section('content')
{{-- 全商品在庫情報 --}}
<br>
<h2>全商品在庫状況</h2>
<br>

<div class="col-auto">
    <div class="card">
        <div class="card-header">    
            <div class="card-title"></div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>仕入数</th>
                        <th>出荷数</th>
                        <th>在庫数</th>
                        <th>在庫回転率</th>         
                        <th>在庫評価額</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>全商品</td>
                        <td></a></td>
                        <td></td>
                        <td>{{number_format($totalThreeInQuantity)}}個</td>
                        <td>{{number_format($totalThreeOutQuantity)}}個</td>                     
                        <td>{{number_format($totalUpdatedBalance)}} 個</td>
                        <td>{{number_format($totalTurnoverInventory)}}%</td>                                             
                        <td>{{number_format($totalValuation)}}円</td>
                    </tr>           
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 商品別の在庫一覧表 --}}
<br>
<h2>商品別在庫状況</h2>
<br>

<div class="col-auto">
    <div class="card">
        <div class="card-header">    
            <div class="card-title"></div>   
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>種別コード</th>
                        <th>商品名</th>
                        <th>定価</th>
                        <th>仕入数</th>
                        <th>出荷数</th>
                        <th>在庫数</th>
                        <th>在庫回転率</th>         
                        <th>在庫評価額</th>
                    </tr>
                </thead>
                <tbody>
                                     
                <?php  $i=0; ?>
                 @foreach($items as $item)
                        <tr>
                            <td>{{$item->item_code}}</td>
                            <td><a href="/inventories/{{$item->id}}">{{$item->item_name}}</a></td>
                            <td>{{number_format($item->list_price)}}円</td>
                            <td>{{number_format($threeInQuantities[$item->id])}}個</td>
                            <td>{{number_format($threeOutQuantities[$item->id])}}個</td>                     
                            <td>{{number_format($updatedBalances[$item->id])}}個</td>
                            <td>{{number_format($turnoverInventories[$item->id])}}%</td>                                             
                            <td>{{number_format($valuations[$item->id])}}円</td>
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
