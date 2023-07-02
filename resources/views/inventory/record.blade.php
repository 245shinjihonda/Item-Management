@extends('adminlte::page')

@section('title', '在庫状況')

@section('content_header')
    <h1>在庫状況 </h1>
@stop

@section('content')
<br>
    <h2>商品詳細</h2>
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
                <th>登録削除</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$item->item_code}}</td>
                <td>{{$item->item_number}}</td>
                <td>{{$item->category}}</td>
                <td>{{$item->brand}}</td>
                <td>{{$item->item_name}}</td>
                <td>{{number_format($item->list_price)}}円</td>
                <td><a href="/items/delete/{{$item->id}}" class="btn btn-default">削除する</a></td> 
            </tr>
            </tbody>
        </table>
    </div>

    <br>

    <h2>KPI</h2>
    <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
            <thead>
            <tr class="KPI-table-title">
                <th>売上累計額</th>
                <th>粗利益総額</th>
                <th>在庫数</th>
                <th>在庫評価額</th>
            </tr>
            </thead>     
            <tr class="KPI-table-index">
                <td>{{number_format(1000000)}}円</td>
                <td>{{number_format(200000)}}円</td>
                <td >{{number_format(1500)}}種類</td>
                <td >{{number_format(10000)}}円</td>
            </tr>
            </tbody>
            </table>
    
    <br>

    <h2>出入荷記録</h2>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
            <tr>
                <th rowspan="2">登録時刻</th>
                <th colspan="3">入荷</th>
                <th colspan="3">出荷</th>
                <th rowspan="2">登録者</th> 
            </tr>
            <tr>
                <th>入荷数</th>
                <th>単価</th>
                <th>合計額</th>
                <th>出荷数</th>
                <th>単価</th>
                <th>合計額</th>   
            </tr>
            </thead>
            <tbody>           
                @foreach($recordInventories as $recordInventory)
                <tr>
                    <td>{{$recordInventory->created_at}}</td>
                    <td>{{$recordInventory->in_quantity}}</td>
                    <td>{{$recordInventory->in_unit_price}}</td>
                    <td>{{$recordInventory->in_amount}}</td>
                    <td>{{$recordInventory->out_quantity}}</td>
                    <td>{{$recordInventory->out_unit_price}}</td>
                    <td>{{$recordInventory->out_amount}}</td>
                    <td>{{$recordInventory->user_id}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
