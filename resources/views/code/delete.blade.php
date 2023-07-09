@extends('adminlte::page')
@include('common')

@section('title', '種別コード削除')

@section('content_header')
    <h1>種別コード削除</h1>
@stop

@section('content')

<div class="search-form">
    <form class="row g-2" action="{{ url('codes/search') }}" method="GET">
        @csrf

        {{-- <div class="col-auto">
            <input class="btn btn-success" type="submit" value="検索">
        </div>

        <div class="col-auto">
            <label for="item_code">商品コード
            <select name="item_code" data-toggle="select">
            <option value="">全て</option>
            @foreach ($items as $item)
            <option value="{{$code->item_code}}">{{$item->item_code}}</option>
            @endforeach
            </select>
            </label>  
        <div> --}}

    </form>
</div>

<br>
        {{-- <?php $url = $_SERVER['REQUEST_URI']; ?>
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
        @endif --}}
       
       @if (session('flashmessage'))
            <div class="flash_message">
                {{ session('flashmessage') }}
            </div>
        @endif


<div class="col-auto">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">種別コード一覧</h3>
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
                        <th>種別コード</th>
                        <th>対象となる商品のタイプ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($codes as $code)
                        <tr>
                            <td>{{$code->item_code}}</td>
                            <td>{{$code->code_name}}</td>
                            <td><button type="sumbit" class="btn btn-default"><a href="/codes/delete/{{$code->id}}">削除</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

    <footer>
    <div>{{$codes->appends(request()->query())->links('pagination::bootstrap-4')}} </div>
    </footer>

@stop

@section('css')
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
@stop
