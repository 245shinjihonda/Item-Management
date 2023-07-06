@extends('adminlte::page')
@include('common')

@section('title', '売上実績')

@section('content_header')
    <h1>売上実績</h1>

    <?php echo date("Y-01-01")." 00:00:00"?>
    <?php echo date("Y-01-01", strtotime('-1 year'))?>
    <?php echo date("Y-m-t", strtotime('-1 year'))?>

    <!-- <form class="row g-2" Method="GET" action="/inventories//search">
        <div>
            <label for="">出入荷記録を検索して確認する。</label>
            <input type="date" name="from" placeholder="from_date" value="">
            <input type="date" name="until" placeholder="until_date" value="">
            <button type="submit">検索</button>
        </div>
    </form> -->

@stop

@section('content')
<br>
    <h2>実績データ</h2>
    
    <div class="col-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>種別コード</th>
                        <th>商品番号</th>
                        <th>商品名</th>
                        <th>当月売上高</th>   
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
                            <td>{{ $item->item_number }}</td>
                            <td><a href="/inventories/{{$item->id}}">{{ $item->item_name }}</a></td>
                            <td>円</td>
                            <td>円</td>
                            <td>円}</a></td>
                            <td>円</td>
                            <td>円</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


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
                </tbody>
        </table>
    </div>

    <footer>
    
    </footer>


@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop