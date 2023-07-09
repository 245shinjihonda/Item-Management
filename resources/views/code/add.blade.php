@extends('adminlte::page')
@include('common')

@section('title', '商品登録')

@section('content_header')
    <h1>コード登録</h1>
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
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cut_number">種別コード</label>
                            <input type="text" class="form-control" name="item_code" placeholder="AAA, AAB, ...">
                        </div>

                        <div class="form-group">
                            <label for="item_number">対象となる商品のタイプ</label>
                            <input type="text" class="form-control" name="code_name" placeholder="ザック, 靴, レインウエア等">
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
