<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;


class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // authミドルウェアを使い、特定のルートやアクションを、認証済みユーザーだけがアクセスできるよう保護する
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index()
    {
        // 商品一覧取得
        $items = Item::all();
        return view('item.index', compact('items'));
    }

    
    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'kana_name' => 'required|max:100|regex:/^[ァ-ヴー]+$/u',
                'quantity' => 'required|numeric|max:100000',
                'type' => 'required',
                ]);

        //AWSへ画像保存
        //画像がある場合
        if ($request->hasFile('image')) {
        $image = $request->file('image');
        //バケットの'todo_item'フォルダに保存
        $image_path = Storage::disk('s3')->putFile('/', $image, 'public');
        //画像のフルパスを取得
        //$image_path = Storage::disk('s3')->url($path);

        //dd($path);
        //画像がない場合
        }else{
            $image_path = null;
        }

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'kana_name' => $request->kana_name,
                'quantity' => $request->quantity,
                'type' => $request->type,
                'image_path' => $image_path,
                'detail' => $request->detail,
            ]);
            
            return redirect('/items');
        }

        return view('item.add');
    }

    /**
     * 商品検索
     */
    public function search(Request $request)
    {
        // 検索フォームで入力された値を取得する
        $search =$request->get('search');
        
        //入力されたクエリストリングのみ取得
        $query = Item::query();

        if(!empty($search))
        {
            $query->where('name','LIKE',"%{$search}%");
        }

        $items = $query->get();

        return view('item.index',[
            'items'=>$items,  
        ]);
        
    }

    /**
     * 商品並び替え
     */
    public function sort(Request $request)
    {
        //itemをソートで取得
        $sort = $request->get('sort');

        //ID順
        if($sort){
            if($sort === 'ID'){
                $items = Item::orderBy('ID', 'asc')->get();
        
        //名前順
        } elseif ($sort === 'kana_name'){
                $items = Item::orderBy('kana_name')->get();

        //個数（昇順）
        } elseif ($sort === 'asc') {
                $items = Item::orderBy('quantity',  'asc')->get();

        //個数（降順）
        } elseif ($sort === 'desc'){
            $items = Item::orderBy('quantity', 'desc')->get();    
        
         //登録日順
        } elseif ($sort === 'created_at'){
            $items = Item::orderBy('created_at','desc')->get();

        //更新日順
        }else {
            $items = Item::orderBy('updated_at','desc')->get();
        }       
        
        return view('item.index',[
            'items'=>$items,  
        ]);
        
    }
    }
    /**
     * 商品編集画面を表示
     */
    public function edit($id)
    {

    //該当するIDのアイテムを取得
    $item = Item::find($id);
    
        return view('item.update',[
        'item' => $item,   
        ]);
    }
    
    /**
     * 商品編集
     */
    public function update(Request $request) 
    {
        $request->validate([
            'name' => 'required|max:100',
            'kana_name' => 'required|max:100|regex:/^[ァ-ヴー]+$/u',
            'quantity' => 'required|numeric|max:100000',
            'type' => 'required',
            
        ]);

        //現在のファイルのデータを取得
        $item = Item::where('id', '=', $request->id)->first();

        // 新たな画像ファイルの文字列データ取得
        $image = $request->file('image');

        //画像を変更する場合は現在のファイルを削除
        //issetで新たな画像があるか確認
        if(isset($image)){
        
        //s3に新たに画像を保存
        $image_path = Storage::disk('s3')->putFile('/', $image, 'public');

        //s3の画像データを削除
        Storage::disk('s3')->delete($image);

        }else{
            $image_path = $item->image_path;
        }

        //商品編集するため、リクエストで渡されたIDを元にデータを取得
        $item = Item::where('id', $request->id)->first();
            $item->name = $request->name;
            $item->kana_name = $request->kana_name;
            $item->quantity = $request->quantity;
            $item->type = $request->type;
            $item->image_path = $image_path;
            $item->detail = $request->detail;
            $item->save();
        
        
            return redirect('/items');
        
    }

    /**
     * 削除機能
     */
    public function delete(Request $request)
    {
    //既存のレコード取得
    $item = Item::where('id', $request->id)->first();

    //画像がNULLの場合はDBのデータのみ削除
    if(is_null($item->image_path)){
        //商品データを削除
        $item->delete();
    }else{
        //画像がある場合、s3のデータ削除のためurlを「/」で分ける
        //$path = explode("/",$item->image_path,5);
        //dd($path);
        //ファイル文字列データを格納
        //$file_name = $path[4]; 
        //dd($file_name);

        //s3の画像データを削除
        Storage::disk('s3')->delete($item->image_path);
    
        //商品データを削除
        $item->delete();
    }

    return redirect('/items');
    }
}


