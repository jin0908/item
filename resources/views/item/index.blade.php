@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                            <!-- <div class="form-inline"> -->
                            
                                <!-- 検索ボタン -->
                                <div style="margin-right:30px ;">
                                    <form action="{{url('items/search')}}">
                                        <input type="text" name="search"  placeholder="キーワードを入力">
                                        <input type="submit" value="検索">
                                    </form>
                                </div>

                                <!-- ソート機能ボタン -->
                                <div style="margin-right:30px ;">
                                    <form action="{{url('items/sort')}}" >
                                        <select name="sort">                                      
                                            <option value="">並び替え選択</option>
                                            <option value="ID">ID順</option>
                                            <option value="kana_name">名前順</option>
                                            <option value="asc">個数（昇順）</option>
                                            <option value="desc">個数（降順）</option>                            
                                            <option value="created_at">登録日順</option>
                                            <option value="updated_at">更新日順</option>
                                        </select>
                                        <input type="submit" value="並び替え">
                                    </form>
                                </div>
                                <a href="{{ url('items/add') }}" class="btn btn-primary">商品登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>個数</th>
                                <th>種別</th>
                                <th style = "padding-left: 45px;">画像</th>
                                <th>初入荷日</th>
                                <th>補充日</th>
                                <th>詳細</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>                                   
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ config("type.$item->type") }}</td>
                                    <td><img src ="{{ $item->image_path }}" class="img-responsive" width="100" style="border: solid 1px #777777;"></td>
                                    <td>{{ date("Y-m-d", strtotime($item->created_at)) }}</td>
                                    <td>{{ date("Y-m-d", strtotime($item->updated_at)) }}</td>
                                    <td><a href="{{ url('items/edit/'.$item->id) }}">>>詳細・編集</a></td>
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
