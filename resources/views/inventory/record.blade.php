@extends('adminlte::page')
@include('common')

@section('title', '在庫状況')

@section('content_header')
    <h1>在庫状況 </h1>

<br>

    <form class="row g-2" Method="GET" action="/inventories/{{$item->id}}/search">
        <div>
            <label for="">出入荷記録を検索して確認する。</label>
            <input type="date" name="from" placeholder="from_date" value="">
            <input type="date" name="until" placeholder="until_date" value="">
            <button type="submit">検索</button>
        </div>
    </form>

    <div>
        <a href="/inventories/update/{{$item->id}}" class="btn btn-default">出入荷記録を入力する</a>
        <a href="/items/delete/{{$item->id}}" class="btn btn-default">この商品の登録を削除する</a>
    </div>
@stop

@section('content')
<br>
    <h2>商品詳細</h2>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>品目コード</th>
                    <th>商品番号</th>
                    <th>品目名</th>
                    <th>ブランド</th>   
                    <th>商品名</th>
                    <th>定価</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$item->item_code}}</td>
                    <td>{{$item->item_number}}</td>
                    <td>{{$item->category}}</td>
                    <td>{{$item->brand}}</td>
                    <td>{{$item->item_name}}</td>
                    <td class="table_number">{{number_format($item->list_price)}} 円</td>  
                </tr>
                </tbody>
            </table>
        </div>

<br>
    
    @isset ($currentRevenue)
        <h2>KPI</h2>
        <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
                <thead>
                <tr class="KPI-table-title">
                    <th>当月売上高 </th>
                    <th>当月利益</th>
                    <th>現在の在庫数</th>
                    <th>現在の在庫単価</th>
                    <th>現在の在庫評価額</th>
                </tr>
                </thead>     
                
                <tr class="KPI-table-index">
                    <td class="table_number">{{number_format($currentRevenue)}} 円</td>
                    <td class="table_number">{{number_format($currentProfit)}} 円</td>
                    <td class="table_number">{{number_format($currentQuantity)}} 個</td>
                    <td class="table_number">{{number_format($currentUnitPrice)}} 円</td>
                    <td class="table_number">{{number_format($currentValuation)}} 円</td>  
                </tr>
                </tbody>
                </table>
    @endisset
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
                        <td class="table_number">{{number_format($recordInventory->in_quantity)}} 個</td>
                        <td class="table_number">{{number_format($recordInventory->in_unit_price)}} 円</td>
                        <td class="table_number">{{number_format($recordInventory->in_amount)}} 円</td>
                        <td class="table_number">{{number_format($recordInventory->out_quantity)}} 個</td>
                        <td class="table_number">{{number_format($recordInventory->out_unit_price)}} 円</td>
                        <td class="table_number">{{number_format($recordInventory->out_amount)}} 円</td>
                        <td>{{$recordInventory->name}}</td>
                    </tr>
                    @endforeach
                </tbody>
        </table>
    </div>

    <footer>
    <div>{{$recordInventories->appends(request()->query())->links('pagination::bootstrap-4')}} </div>
    </footer>


@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
