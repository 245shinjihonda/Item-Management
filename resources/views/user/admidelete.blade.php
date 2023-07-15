@extends('adminlte::page')
@include('common')

@section('title', '管理者削除')

@section('content_header')
    <h1>管理者削除</h1>
@stop

@section('content')

    <br>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">管理者一覧</h3>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>氏名</th>
                                <th>メールアドレス</th>
                                <th>             </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($administrators as $administrator)
                                <tr>
                                    <td>{{$administrator->name}}</td>
                                    <td>{{$administrator->email}}</td>
                                    <td><button type="sumbit" class="btn btn-default"><a href="/users/admi/delete/{{$administrator->id}}">削除</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    
@stop

@section('css')
@stop

@section('js')
@stop