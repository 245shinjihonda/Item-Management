@extends('adminlte::page')
@include('common')

@section('title', '売上実績')

@section('content_header')

@stop

@section('content')
<br>
    <h2>当期売上高</h2>
<br>

 {{-- Date関数参照
    date("Y-01-01")." 00:00:00"
    date("Y-01-01", strtotime('-1 year'))
    date("Y-m-t", strtotime('-1 year'))  --}}

<div class="col-auto">       
    <div class="card">
        <div class="card-header">    
            <div class="card-title"></div>
            <h3>全商品</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>品目数</th>  
                        <th>{{date("n")}}月売上高</th>
                        <th>当期売上高</th>
                        <th>当期利益</th> 
                        <th>当期利益率</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>当期全商品売上高 </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="table_number">{{number_format($itemNumber)}} 品目</td>
                            <td class="table_number">{{number_format($totalMonthRevenue)}} 円</td>
                            <td class="table_number">{{number_format($totalCurrentRevenue)}} 円</td>
                            <td class="table_number">{{number_format($totalCurrentProfit)}} 円</td>
                            <td class="table_number">{{number_format($totalCurrentProfitRatio)}} %</td>
                        </tr>                
                </tbody>
            </table>
        </div>         
     </div>
</div>

<br>

<div class="col-auto">      
    <div class="card">
        <div class="card-header">    
            <div class="card-title"></div> 
            <h3>商品別</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>品目コード</th> 
                        <th>商品名</th>
                        <th>定価</th>
                        <th>{{date("n")}}月売上高</th>       
                        <th>当期売上高</th>
                        <th>当期利益</th> 
                        <th>当期利益率</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->item_code}}</td>
                            <td><a href="/inventories/{{$item->id}}">{{ $item->item_name }}</a></td>
                            <td class="table_number">{{number_format($item->list_price)}} 円</td>
                            <td class="table_number">{{number_format($monthRevenues[$item->id] ?? 0)}} 円</td>
                            <td class="table_number">{{number_format($currentRevenues[$item->id] ?? 0)}} 円</td>
                            <td class="table_number">{{number_format($currentProfits[$item->id] ?? 0)}} 円</td>
                            <td class="table_number">{{number_format($currentProfitRatios[$item->id] ?? 0)}} %</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> 
    </div>
</div>

<footer>
    {{-- <div>{{$items->appends(request()->query())->links('pagination::bootstrap-4')}} </div> --}}
</footer>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop