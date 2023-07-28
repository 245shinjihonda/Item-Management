@extends('adminlte::page')
@include('common')

@section('title', '品目コード一覧')

@section('content_header')
    <h1>品目コード一覧</h1>
@stop

@section('content')

    <div>
        <a href="{{ url('codes/add') }}" class="btn btn-default" style="background:rgb(236, 243, 131)">品目コード登録</a>
        @can('is_admi')
        <a href="{{ url('codes/delete-list') }}" class="btn btn-default" style="background:rgba(252, 139, 105, 0.938)">品目コード削除</a>
        @endcan
    <div>

    <div class="search-form">
        <form class="row g-2" action="{{ url('codes/search') }}" method="GET">
            @csrf
                    <div class="col-auto">
                        <input class="btn btn-success" type="submit" value="検索">
                    </div>
                    <div class="col-auto">
                        <input class="form-control" type="text" name="keyword" value="商品タイプを入力">
                    </div>
        </form>
    </div>

<br>
        <?php $url = $_SERVER['REQUEST_URI']; ?>
        @if (strstr($url, 'code_name'))
            検索結果表示 
        @endif

       <?php   
        $nocode = $codes->isEmpty();
        ?>
        @if($nocode)
        <div class="alert alert-danger">
        <p>該当する品目コードはありません。</p>
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
                <h3 class="card-title">品目コード一覧</h3>
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
                            <th>対象となる商品のタイプ</th>
                            <th>取扱状況</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($codes as $code)
                            <tr>
                                <td>{{$code->item_code}}</td>
                                <td>{{$code->code_name}}</td>
                                <td>{{$code->status}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <footer>
    {{-- <div>{{$codes->appends(request()->query())->links('pagination::bootstrap-4')}} </div> --}}
    </footer>

@stop

@section('css')
@stop

@section('js')
@stop
