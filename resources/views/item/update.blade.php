@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品詳細・編集</h1>
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
                <form action="{{url('items/update')}}" method="post" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="card-body">
                    <input type="hidden" value="{{ $item->id }}" name="id">
                        <div class="form-group">
                            <label for="name">名前(必須)</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}">
                        </div>

                        <div class="form-group">
                            <label for="kana_name">フリガナ(必須)</label>
                            <input type="text" class="form-control" id="kana_name" name="kana_name"  value="{{ $item->kana_name }}">
                        </div>

                        <div class="form-group">
                            <label for="quantity">個数(必須)</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" value="{{ $item->quantity }}">
                        </div>

                        <div class="form-group">
                            <label for="type">種別(必須)</label>
                            <select class="form-control" id="type" name="type">
                                @foreach (config('type') as $key =>$value )
                                    <option value="{{ $key }}" @if($item->type ==  $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                        <label for="image">画像(選択しない場合、現在の画像が再度表示されます)</label>
                        <div style="margin:20px;">
                            <div style="margin-left:10px;">現在の画像</div>
                            <img src ="{{asset($item->image)}}" width="100"  style="border: solid 1px #777777;">
                        </div>
                        <input type="file" class="form-control" id="image" name="image" value="{{ $item->image }}">
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" value="{{ $item->detail }}">
                        </div>
                    </div>                   
                    <button style="margin-left:30px; margin-bottom:10px; " type="submit" class="btn btn-primary">編集</button>                  
                </form>
                <form action="{{ url('items/delete/.$item->id') }}" method="post" onsubmit="return checkDelete()">
                    @method('delete')
                    @csrf
                    <input type="hidden" value="{{ $item->id }}" name="id">
                    <button style="margin-left:30px; margin-bottom:10px;" type="submit" class="btn btn-secondary" >削除</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function checkDelete(){
            if(window.confirm('削除してよろしいですか？')) {
                return true;  //「OK」なら削除
            }
            else{
            //window.alert('キャンセル');
            return false; //「キャンセル」なら削除しない
        }
    }
    </script>    
@stop

@section('css')
@stop

@section('js')

@stop