@extends('adminlte::page')
@include('common')

@section('title', '品目コード削除')

@section('content_header')
    <h1>品目コードを削除する</h1>
@stop

<br>

@section('content')

    <div class="col-auto">
        <div class="card">
            
            <div class="card-header">
                <h3 class="card-title">品目コード リスト</h3>
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
    {{-- <div>{{$codes->appends(request()->query())->links('pagination::bootstrap-4')}} </div> --}}
    </footer>

@stop

@section('css')
@stop

@section('js')
@stop
