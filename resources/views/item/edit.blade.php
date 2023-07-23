@extends('adminlte::page')
@include('common')

@section('title', '商品情報更新')

@section('content_header')
    <h1>- {{$item->item_name}} - 商品情報更新</h1>
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
                <form method="POST" action="/items/update/{{$item->id}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cut_number">品目コード</label>
                            <select name="item_code" data-toggle="select">
                                <option value="{{$item->item_code}}">{{$item->item_code}}</option>
                                @foreach ($codes as $code)
                                <option value="{{$code->item_code}}">{{$code->item_code}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="item_number">商品番号</label>
                            <input type="text" class="form-control" name="item_number" value="{{$item->item_number}}" maxlength='4' required>
                        </div>

                        <div class="form-group">
                            <label for="category">品目名</label>
                            <input type="text" class="form-control" name="category" value="{{$item->category}}" maxlength='100' required>
                        </div>
                        <div class="form-group">
                            <label for="brand">ブランド</label>
                            <input type="text" class="form-control" name="brand"  value="{{$item->brand}}" maxlength='100' required>
                        </div>

                        <div class="form-group">
                            <label for="item_name">商品名</label>
                            <input type="text" class="form-control" name="item_name" value="{{$item->item_name}}" maxlength='100' required>
                        </div>

                        <div class="form-group">
                            <label for="list_price">定価 (税抜価格）</label>
                            <input type="number" class="form-control" name="list_price" value="{{$item->list_price}}" min='1' required>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">商品情報を更新する</button>
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
