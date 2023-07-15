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

            <div class="explanation">
            TOGEは、弊社が取り扱うアウトドア商品について、商品の登録データ、出入荷に関する在庫データ及び財務に関する売上・利益データ
            を連係してリアルタイムで提供する一括管理できるシステムです。商品販売に関するこれら３つのデータを効率的に提供することにより顧客の
            ニーズに適した商品選択と最適な在庫管理をサポートします。
            </div>

            <br>
        
            <div class="upper">
                <div class="top-circle">
                    <p class="circle-text">商品登録<br>データ</p>
                </div>  
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

            <br>

            <h4 class="yama-title">取扱商品の確認</h4>
                <div class="explanation">
                    商品情報画面では、商品情報の詳細を確認できます。
                    新商品については、商品登録画面で登録を行って下さい。登録にあたっては、設定された品目コードを利用して下さい。
                    品目コードは品目コード画面で確認できます。該当する品目コードがない場合は、新規に登録して下さい。
                </div>
            <br>

            <h4 class="yama-title">在庫状況の確認及び出入荷情報の入力</h4>
                <div class="explanation">
                    在庫情報画面では、在庫数などの在庫情報を一覧表で確認できます。商品の出入荷を記録する時は、該当する商品名をクリックして
                    商品毎の画面に遷移したのち、「出入荷情報を入力する」をクリックしてください。入力画面に遷移します。
                </div>

            <br>

            <h4 class="yama-title">売上高及び利益の確認</h4>
                <div class="explanation">
                    財務情報画面では、当期の売上高及び利益を商品毎に一覧表で確認できます。
                </div>
        <div>
    @stop 

</div>

@section('css')
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

