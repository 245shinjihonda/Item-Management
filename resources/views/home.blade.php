@extends('adminlte::page')
@include('common')

@section('title', 'Toge')

@section('content_header')
    <h1>アウトドア商品管理システム - TOGE - </h1>
@stop

@section('content')

<br>
<br>
<img style="width:300px" src="../img/yufuin.JPG">

<div class="col-12">
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
</div>

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

