@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
@stop

@section('content')
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
                <form method="POST" action="{{url('items/add')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">名前(必須)</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前" value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label for="kana_name">フリガナ(必須)</label>
                            <input type="text" class="form-control" id="kana_name" name="kana_name"  placeholder="名前を全角カタカナ入力して下さい" value="{{ old('kana_name')}}">
                        </div>

                        <div class="form-group">
                            <label for="quantity">個数(必須)</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" placeholder="1,2,3..." value="{{ old('quantity')}}">
                        </div>

                        <div class="form-group">
                            <label for="type">種別(必須)</label>
                            <select class="form-control" id="type" name="type">
                            <option value="">選択してください</option>
                                <option value="1">文房具</option>
                                <option value="2">書籍</option>
                                <option value="3">衣類</option>
                                <option value="4">家具</option>
                                <option value="5">家電</option>
                                <option value="6">雑貨</option>
                                <option value="7">日用品</option>
                                <option value="8">食品</option>
                                <option value="9">ゲーム</option>
                                <option value="10">医薬品</option>
                            </select>
                        </div>

                        <div class="form-group">
                        <label for="image">画像</label>
                        <input type="file" class="form-control" id="image" name="image">
                        </div>
    
                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明" value="{{ old('detail')}}">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
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