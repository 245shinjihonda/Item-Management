@extends('adminlte::page')

@section('title', '出入荷入力')

@section('content_header')
    <h1>出入荷入力 </h1>
@stop

@section('content')
    <br>
    <h2>商品詳細</h2>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
            <tr>
                <th>種別番号</th>
                <th>商品番号</th>
                <th>種別</th>
                <th>ブランド</th>   
                <th>商品名</th>
                <th>定価</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>001</td>
                <td>3772A</td>
                <td>ザック</td>
                <td>South Face</td>
                <td>富士</td>
                <td>{{number_format(25000)}}円</td>
            </tr>
            </tbody>
        </table>
    </div>

<br>
<br>

    <form method="POST">
    @csrf
    <div class="col-6">
        <h2>入荷</h2>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <tr>
                        <td>仕入単価</td>
                        <td><input type ="number", id ="ShiirePrice", value="0"></td>
                        <td>円</td>
                    </tr>
                    <tr>
                        <td>個数</td>
                        <td><input type ="number", id ="ShiireUnit", value ="0"></td>
                        <td>個</td>
                    </tr>
                    <tr>
                        <td>合計額</td>
                        <td><p id ="ShiireResult"></P></td>
                        <td>円</td>
                    </tr>
                </table>
            <div><input type ="button", id ="ShiireRun", value ="合計額">
<br>
<br>
<br>
        <h2>出荷</h3>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <tr>
                        <td>販売単価</td>
                        <td><input type ='number', id ='HanbaiPrice', value='0'></td>
                        <td>円</td>
                    </tr>
                    <tr>
                        <td>販売個数</td>
                        <td><input type = 'number', id ='HanbaiUnit', value ='0'></td>
                        <td>個</td>
                    </tr>
                    <tr>
                        <td>合計額</td>
                        <td><p id ='HanbaiResult'></p></td>
                        <td>円</td>
                    </tr>
                </table>
            <div><input type ='button', id ='HanbaiRun', value = '合計額'>
    </div>
<br>
<br>
        <div class="card-footer">
            <!-- <button type="submit" class="btn btn-primary">出入荷を入力する</button> -->
            <a href="{{ url('inventories/input') }}" class="btn btn-default">出入荷を入力する
        </div>
    </form>

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> 
    // 仕入合計額の計算
    function Calc(ShiirePrice, ShiireUnit){
            return ShiirePrice*ShiireUnit;
        }
        
        let ShiireRun = document.getElementById('ShiireRun');

        ShiireRun.addEventListener('click', function(){
            let Price = document.getElementById('ShiirePrice').value;
            let Unit  = document.getElementById('ShiireUnit').value;
            var Total = Calc(Price, Unit);
            let Result = document.getElementById('ShiireResult');
            
            console.log(Total);
            var Amount = new Intl.NumberFormat().format(Total);
            ShiireResult.innerHTML = Amount;
        });
    
        function Calc(HanbaiPrice, HanbaiUnit){
            return HanbaiPrice*HanbaiUnit;
        }
        
        let HanbaiRun = document.getElementById('HanbaiRun');

        HanbaiRun.addEventListener('click', function(){
            let Price = document.getElementById('HanbaiPrice').value;
            let Unit  = document.getElementById('HanbaiUnit').value;
            var Total = Calc(Price, Unit);
            let Result = document.getElementById('HanbaiResult');
            
            console.log(Total);
            var Amount = new Intl.NumberFormat().format(Total);
            HanbaiResult.innerHTML = Amount;
        });

    console.log('Hi!'); 
    </script>
@stop