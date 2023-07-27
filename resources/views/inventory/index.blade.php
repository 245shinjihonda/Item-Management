@extends('adminlte::page')
@include('common')

@section('title', '在庫一覧')

@section('content_header')   
@stop

@section('content')
    <br>
    <h2>在庫一覧</h2>
    <br>

    <a href="/inventories/download" class="btn btn-default" style="background:rgb(199, 241, 175)">CSVファイルにダウンロードする</a>

    <br>
    <br>
    
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
                            <th>当期仕入数</th>
                            <th>当期出荷数</th>
                            <th>現在の在庫数</th>
                            <th>在庫評価額</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>全商品</td>
                            <td></a></td>
                            <td></td>
                            <td class="table_number">{{number_format($totalCurrentInQuantity)}} 個</td>
                            <td class="table_number">{{number_format($totalCurrentOutQuantity)}} 個</td>                     
                            <td class="table_number">{{number_format($totalUpdatedBalance)}} 個</td>                                 
                            <td class="table_number">{{number_format($totalValuation)}} 円</td>
                        </tr>           
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 商品別の在庫一覧表 --}}
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
                            <th>当期仕入数</th>
                            <th>当期出荷数</th>
                            <th>現在の在庫数</th>
                            <th>在庫評価額</th>
                        </tr>
                    </thead>

                    <tbody>                     
                        <?php  $i=0; ?>
                        @foreach($items as $item)
                                <tr>
                                    <td>{{$item->item_code}}</td>
                                    <td><a href="/inventories/{{$item->id}}">{{$item->item_name}}</a></td>
                                    <td class="table_number">{{number_format($item->list_price)}} 円</td>
                                    <td class="table_number">{{number_format($currentInQuantities[$item->id] ?? 0)}} 個</td>
                                    <td class="table_number">{{number_format($currentOutQuantities[$item->id] ?? 0)}} 個</td>                     
                                    <td class="table_number">{{number_format($updatedBalances[$item->id] ?? 0)}} 個</td>                                        
                                    <td class="table_number">{{number_format($valuations[$item->id] ?? 0)}} 円</td>
                                </tr>
                        <?php $i++ ?>
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
@stop

@section('js')
@stop
