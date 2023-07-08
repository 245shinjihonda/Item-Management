@extends('adminlte::page')
@include('common')

@section('title', '売上実績')

@section('content_header')

@stop

@section('content')
<br>
    <h2>全商品売上実績</h2>
<br>

 {{-- Date関数参照
    date("Y-01-01")." 00:00:00"
    date("Y-01-01", strtotime('-1 year'))
    date("Y-m-t", strtotime('-1 year'))  --}}

<div class="col-auto">       
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th rowspan="2"></th> 
                        <th rowspan="2"></th>
                        <th rowspan="2"></th>
                        <th rowspan="2">{{date("n", strtotime('-1 month'))}}月売上高</th>
                        <th colspan="2">{{date("Y")}}</th>
                        <th colspan="2">{{date("Y", strtotime('-1 year'))}}</th>
                    </tr>
                    <tr>        
                        <th>当期売上高</th>
                        <th>当期利益</th> 
                        <th>前期売上高</th>
                        <th>前期利益</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>全商品売上高 (円）</td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($totalMonthRevenue)}}円</td>
                            <td>{{number_format($totalCurrentRevenue)}}円</td>
                            <td>円</a></td>
                            <td>{{number_format($totalPriorRevenue)}}円</td>
                            <td>{{number_format($totalPriorProfit)}}円</td>
                        </tr>
                        <tr>
                            <td>前期比 (%)</td>
                            <td></td>
                            <td></td>
                            <td>円</td>
                            <td>円</td>
                            <td>円</a></td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                </tbody>
            </table>
        </div>         
     </div>
</div>

<br>
    <h2>商品別売上実績</h2>
<br>

<div class="col-auto">      
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th rowspan="2">種別コード</th> 
                        {{-- <th rowspan="2">商品番号</th> --}}
                        <th rowspan="2">商品名</th>
                        <th rowspan="2">{{date("n", strtotime('-1 month'))}}月売上高</th>
                        <th colspan="2">{{date("Y")}}</th>
                        <th colspan="2">{{date("Y", strtotime('-1 year'))}}</th>
                    </tr>
                    <tr>        
                        <th>当期売上高</th>
                        <th>当期利益</th> 
                        <th>前期売上高</th>
                        <th>前期利益</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->item_code}}</td>
                            {{-- <td>{{ $item->item_number }}</td> --}}
                            <td><a href="/inventories/{{$item->id}}">{{ $item->item_name }}</a></td>
                            <td>{{number_format($monthRevenues[$item->id])}}円</td>
                            <td>{{number_format($currentRevenues[$item->id])}}円</td>
                            <td>円</td>
                            <td>{{number_format($priorRevenues[$item->id])}}円</td>
                            <td>{{number_format($priorProfits[$item->id])}}円</td>
                        </tr>
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
    <script> console.log('Hi!'); </script>
@stop