@extends('adminlte::page')
@include('common')

@section('title', '利用者一覧')

@section('content_header')
    <h1>利用者一覧</h1>
@stop

@section('content')

    @can('is_admi')

        <div>
            <a href="{{ url('users/add-form') }}" class="btn btn-default" style="background:rgb(236, 243, 131)">利用者登録</a>
            <a href="{{ url('users/delete-list') }}" class="btn btn-default" style="background:rgba(252, 139, 105, 0.938)">利用者削除</a>
            {{-- <a href="{{ url('users/admi/add-form') }}" class="btn btn-default">管理者登録</a>   
            <a href="{{ url('users/admi/delete-list') }}" class="btn btn-default">管理者削除</a> --}}
        </div>

        <br>

        <div class="row">
            <div class="col-8">
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admiusers as $admiuser)
                                    <tr>
                                        <td>{{$admiuser->name}}</td>
                                        <td>{{$admiuser->email}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 

    @endcan

    <br>

    <div class="row">
        <div class="col-8">
            <div class="card"> 

                <div class="card-header">
                    <h3 class="card-title">利用者一覧</h3>
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
                                <th>氏名</th>
                                <th>メールアドレス</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
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
