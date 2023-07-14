@extends('adminlte::page')
@include('common')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
@stop

@section('content')
           
        @if(isset($error_existingItem))
        <div class="alert alert-danger">
        {{$error_existingItem}}
        </div>
        @endif
        
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form method="POST" action="/items/add" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cut_number">品目コード</label>
                            <select name="item_code" data-toggle="select">
                                <option value="">品目コードを選択して下さい</option>
                                @foreach ($codes as $code)
                                <option value="{{$code->item_code}}">{{$code->item_code}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="item_number">商品番号</label>
                            <input type="text" class="form-control" name="item_number" placeholder="アルファベット大文字3文字" maxlength='4' required>
                        </div>

                        <div class="form-group">
                            <label for="category">品目名</label>
                            <input type="text" class="form-control" name="category" placeholder="ザック, 靴, レインウエア等" maxlength='100' required>
                        </div>
                        <div class="form-group">
                            <label for="brand">ブランド</label>
                            <input type="text" class="form-control" name="brand" placeholder="ブランド名, メーカー名" maxlength='100' required>
                        </div>

                        <div class="form-group">
                            <label for="item_name">商品名</label>
                            <input type="text" class="form-control" name="item_name" placeholder="商品名" maxlength='100' required>
                        </div>

                        <div class="form-group">
                            <label for="list_price">定価</label>
                            <input type="number" class="form-control" name="list_price" placeholder="定価（税込価格）" min='1' required>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
