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
                <td>{{$updateInventory->item_code}}</td>
                <td>{{$updateInventory->item_number}}</td>
                <td>{{$updateInventory->category}}</td>
                <td>{{$updateInventory->brand}}</td>
                <td>{{$updateInventory->item_name}}</td>
                <td>{{number_format($updateInventory->list_price)}}円</td>
            </tr>
            </tbody>
        </table>
    </div>

<br>
<br>

    <form method="POST" action="{{url('inventories/input')}}" enctype="multipart/form-data">
        @csrf
        <div class="col-6">
        <h2>入荷</h2>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <tr>
                        <td>仕入個数</td>
                        <td><input type="number", id="in_quantity", value ="0"></td>
                        <td>個</td>
                    </tr>
                    <tr>
                        <td>仕入単価</td>
                        <td><input type="number", id ="in_unit_price", value="0"></td>
                        <td>円</td>
                    </tr>
                    <tr>
                        <td>合計額</td>
                        <td><p id="in_amount"><input type="number", name="in_amount" value="0"><P></td>
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
                        <td>販売個数</td>
                        <td><input type = 'number', id ='out_quantity', value ='0'></td>
                        <td>個</td>
                    </tr>
                    <tr>
                    <td>販売単価</td>
                        <td><input type ='number', id ='out_unit_price', value='0'></td>
                        <td>円</td>
                    </tr>
                    <tr>
                        <td>合計額</td>
                        <td><p id ='out_amount'><input type="number", name="out_amount" value="0"></p></td>
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
    function Calc(in_quantity, in_unit_price){
            return in_quantity*in_unit_price;
        }
        
        let ShiireRun = document.getElementById('ShiireRun');

        ShiireRun.addEventListener('click', function(){
            let Price = document.getElementById('in_quantity').value;
            let Unit  = document.getElementById('in_unit_price').value;
            var Total = Calc(Price, Unit);
            let Result = document.getElementById('in_amount');
            
            console.log(Total);
            var Amount = new Intl.NumberFormat().format(Total);
            in_amount.innerHTML = Amount;
        });
    
        function Calc(out_quantity, out_unit_price){
            return out_quantity*out_unit_price;
        }
        
        let HanbaiRun = document.getElementById('HanbaiRun');

        HanbaiRun.addEventListener('click', function(){
            let Price = document.getElementById('out_quantity').value;
            let Unit  = document.getElementById('out_unit_price').value;
            var Total = Calc(Price, Unit);
            let Result = document.getElementById('out_amount');
            
            console.log(Total);
            var Amount = new Intl.NumberFormat().format(Total);
            out_amount.innerHTML = Amount;
        });

    console.log('Hi!'); 
    </script>
@stop