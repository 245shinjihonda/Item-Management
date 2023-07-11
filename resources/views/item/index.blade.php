@extends('adminlte::page')
@include('common')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')

<div>
<a href="{{ url('items/add') }}" class="btn btn-default">商品を登録する</a>
</div>

<br>

<div class="search-form">
    <form class="row g-2" action="{{ url('items/search') }}" method="GET">
        @csrf

        <div class="col-auto">
           <input class="btn btn-success" type="submit" value="検索">   
        </div>

        <div class="col-auto">
            <label for="item_code">商品コード
                <select name="item_code" data-toggle="select">
                    <option value="">全て</option>
                    @foreach ($items as $item)
                        <option value="{{$item->item_code}}">{{$item->item_code}}</option>
                    @endforeach
                </select>
            </label>  
        <div>

        <div class="col-auto">
            <label for="list_price">定価
                <select name="list_price" data-toggle="select">
                    <option value="">全て</option> 
                    <option value="10000">10,000円未満</option>
                    <option value="20000">10,000円以上20,000円未満</option>
                    <option value="30000">20,000円以上30,000円未満</option>
                    <option value="30001">30,000円以上</option>
                </select>
            </label> 
        </div> 

    </form>
</div>

<br>
        <?php $url = $_SERVER['REQUEST_URI']; ?>
        @if (strstr($url, 'item_code'))
            検索結果表示 
        @endif

       <?php   
        $noitem = $items->isEmpty();
        ?>
        @if($noitem)
        <div class="alert alert-danger">
        <p>該当する商品はありません。</p>
        </div>
        @endif
      
       @if (session('flashmessage'))
            <div class="flash_message">
                {{ session('flashmessage') }}
            </div>
        @endif

<div class="col-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">商品一覧</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm">
                    <div class="input-group-append">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>品目コード</th>
                        <th>商品番号</th>
                        <th>品目名</th>
                        <th>ブランド</th>   
                        <th>商品名</th>
                        <th>定価</th>
                        <th>取扱状況</th>
                        <th>商品登録日</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{$item->item_code}}</td>
                            <td>{{$item->item_number}}</td>
                            <td>{{$item->category}}</td>
                            <td>{{$item->brand}}</td>
                            <td><a href="/inventories/{{$item->id}}">{{$item->item_name}}</td>
                            <td class="table_number">{{number_format($item->list_price) }} 円</td>
                            <td>{{$item->status}}</td>
                            <td>{{$item->created_at->format('Y/m/d')}}</td>
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
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
@stop
