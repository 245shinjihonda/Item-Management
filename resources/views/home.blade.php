@extends('adminlte::page')
@include('common')

@section('title', 'Toge')

<div class="home_body">

    @section('content_header')
        <h2 class="toge">アウトドア商品管理システム - TOGE - </h2>
    @stop

    @section('content')
    <div class="yama">  
    <br>
        {{-- <img style="width:100px" src="../img/yufuin.JPG"> --}}
    <div class="explanation">
       TOGEは、弊社が取り扱うアウトドア商品に関する、商品の登録データ、出入荷に関する在庫データ及び財務に関する売上・利益データ
       を連係して一括管理できるシステムです。商品販売に関するこれら３つのデータをリアルタイムで提供することにより顧客の
       ニーズに適した商品選択と最適な在庫管理を実現します。
    </div>

    <br>
        
        <div class="upper">
            {{-- <div class="left-line"> 
            </div> 
         --}}
            <div class="top-circle">
                <p class="circle-text">商品登録<br>データ</p>
            </div>

            {{-- <div class="right-line"> 
            </div>  --}}
        </div>

    <div class="middle-circles">
        <div class="middle-left-line"></div>
        <div class="middle-space"> </div>
        <div class="middle-right-line"></div>
    </div>

        <div class="bottom-circles">
            <div class="bottom-left-circle">
                <p class="circle-text">在庫・出入荷<br>データ</p>
            </div>

            <div class="bottom-center-circle">
                <div class="bottom-line"></div>
            </div>

            <div class="bottom-right-circle">
                <p class="circle-text">売上・利益<br>データ</p>
            </div>
        </div>

    <h4 class="yama-title">商品登録</h4>
        <div class="explanation">
            商品の販売開始が決定したら、商品情報画面から商品登録を行って下さい。登録にあたっては、設定された品目コードを利用して下さい。
            該当する品目コードがない場合は、品目コード画面から新規に品目コードを登録して下さい。
        </div>
    <br>
     <h4 class="yama-title">出入荷記録の入力</h4>
        <div class="explanation">
            在庫情報画面では、在庫数などの在庫情報を一覧表で確認できます。商品の出入荷を記録する時は、該当する商品名をクリックして
            商品毎の画面に遷移したのち、「出入荷記録を入力する」をクリックしてください。入力画面に遷移します。
        </div>
    <br>
     <h4 class="yama-title">出入荷記録の入力</h4>
        <div class="explanation">
            財務情報画面では、当期の売上高及び利益を商品毎に一覧表で確認できます。
        </div>

</div>
    @stop    

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

