@extends('adminlte::page')
@include('common')

@section('title', 'Toge')

<div class="home_body">

    @section('content_header')
        <h2>アウトドア商品管理システム - TOGE - </h2>
    @stop

    @section('content')
    <div class="yama">
        
            <br>
        {{-- <img style="width:100px" src="../img/yufuin.JPG"> --}}



       <h3 class="yama-title">利用案内</h3>


        <div class="top-circle">
            <p class="top-circle-text">商品管理データ</p>
        </div>

       <div class="right-line"> </div>

       <div class="left-line"> </div>
        
        <div class='bottom-circle'>
            <div class="top-circle">
            <p class="top-circle-text">在庫管理データ</p>
            </div>

            <div class="top-circle">
            <p class="top-circle-text">売上データ</p>
            </div>
            </div>

    </div>  
    @stop    
        {{-- <div class="col-12">
            <table class="table table-hover text-nowrap">
                    <tr>
                        <td align="center" colspan="2">累積売上高</td>
                        <td align="center" colspan="2">累積利益</td>
                    </tr>
                    <tr>
                        <td align="right">{{number_format(100)}}</td>
                        <td>億円</td>
                        <td align="right">{{number_format(20)}}</td>
                        <td>億円</td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">在庫評価額</td>
                        <td align="center" colspan="2">取扱商品数</td>
                    </tr>
                    <tr>
                        <td align="right"> {{number_format(1000)}}</td>
                        <td>億円</td>
                        <td align="right"> {{number_format(10000)}}</td>
                        <td>個</td>

                    
                
                    </tr>
                </table>
        </div> --}}

   



@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

