@extends('adminlte::page')
@include('common')

@section('title', '当期売上高及び利益')

@section('content_header')
@stop

@section('content')
    <br>
        <h2>当期売上高及び利益</h2>
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
                                <td class="table_number">{{number_format($totalCurrentProfitRatio, 2)}} %</td>
                            </tr>                
                    </tbody>
                </table>
            </div>  

        </div>
    </div>

    <a href="/finance/download" class="btn btn-default" id="download" download="revenue.csv" 
    onclick="handleDownload()" style="background:rgb(199, 241, 175)">CSVファイルにダウンロードする</a>

    <br>
    <br>

    <div class="col-auto">      
        <div class="card">

            <div class="card-header">    
                <div class="card-title"></div> 
                <h3>商品別</h3>
            </div>

            <div class="card-body table-responsive p-0">
                <table id="table1" class="table table-hover text-nowrap">
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
                                <td class="table_number">{{sprintf('%.2f' ,$currentProfitRatios[$item->id] ?? 0)}} %</td>
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
@stop

@section('js')

    <script>

        function handleDownload() {
            var bom = new Uint8Array([0xEF, 0xBB, 0xBF]);//文字コードをBOM付きUTF-8に指定
            var table = document.getElementById('table1');//id=table1という要素を取得
            var data_csv="";//ここに文字データとして値を格納していく

            for(var i = 0;  i < table.rows.length; i++){
                for(var j = 0; j < table.rows[i].cells.length; j++){
                    data_csv += '"'+table.rows[i].cells[j].innerText +'"';//HTML中の表のセル値をdata_csvに格納 (桁数の,を無視するために'"'を挿入)
                    if(j == table.rows[i].cells.length-1) data_csv += "\n";   //行終わりに改行コードを追加
                    else data_csv += ",";     //セル値の区切り文字として,を追加
                }
            }

            var blob = new Blob([ bom, data_csv], { "type" : "text/csv" });//data_csvのデータをcsvとしてダウンロードする関数
            if (window.navigator.msSaveBlob) { //IEの場合の処理
                window.navigator.msSaveBlob(blob, "revenue.csv"); 
                //window.navigator.msSaveOrOpenBlob(blob, "test.csv");// msSaveOrOpenBlobの場合はファイルを保存せずに開ける
            } else {
            document.getElementById("download").href = window.URL.createObjectURL(blob);
            }

            delete data_csv;//data_csvオブジェクトはもういらないので消去してメモリを開放
        }

    </script>

    <script> console.log('Hi!'); </script>

@stop