<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Illuminate\Support\Facades\DB;
use Storage;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('reviews');
        
        // 検索フォーム
        $search = $request->input('search');
        //もしキーワードがあったら
        if($search !== null){
            //全角スペースを半角に
            $search_split = mb_convert_kana($search,'s');
            //空白で区切る
            $search_split2 = preg_split('/[\s]+/', $search_split,-1,PREG_SPLIT_NO_EMPTY);
            //単語をループで回す
            foreach($search_split2 as $value) {
                $query->where('title','like','%'.$value.'%')
                      ->orwhere('body','like','%'.$value.'%');
            }
        };
        
        $query->orderBy('created_at', 'desc');
        $reviews = $query->paginate(6);

        return view('review.index', compact('reviews'));
    }

    
    public function create()
    {
        return view('review.create');
    }


    public function store(Request $request)
    {
        $post = $request->all();
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $review = new Review();
            
        if ($request->hasFile('image')) {
            $uploadImg = $review->image = $request->file('image');
            $path = Storage::disk('s3')->putFile('/', $uploadImg, 'public');
            $data = ['user_id' => \Auth::id(), 'title' => $post['title'], 'body' => $post['body'], 'image' => Storage::disk('s3')->url($path)];
        } else {
            $data = ['user_id' => \Auth::id(), 'title' => $post['title'], 'body' => $post['body']];
        }

        $review->fill($data)->save();

        // if ($request->hasFile('image')) {
        //     $request->file('image')->store('/public/images');
        //     $data = ['user_id' => \Auth::id(), 'title' => $post['title'], 'body' => $post['body'], 'image' => $request->file('image')->hashName()];
        // } else {
        //     $data = ['user_id' => \Auth::id(), 'title' => $post['title'], 'body' => $post['body']];
        // }

        // Review::insert($data);

        return redirect('/')->with('flash_message', '投稿が完了しました');
    }


    public function show($id)
    {
        $review = Review::where('id', $id)->where('status', 1)->first();

        return view('review.show', compact('review'));
    }
    
    
    public function edit($id)
    {
        $review = Review::where('id', $id)->where('status', 1)->first();

        return view('review.edit', compact('review'));
    }


    public function update(Request $request, $id)
    {
        $post = $request->all();
        // dd($post);
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
        // 送信されたファイルを操作する
            $request->file('image')->store('/public/images');
            $data = ['user_id' => \Auth::id(), 'title' => $post['title'], 'body' => $post['body'], 'image' => $request->file('image')->hashName()];
        // dd($data);
        } else {
            $data = ['user_id' => \Auth::id(), 'title' => $post['title'], 'body' => $post['body']];
        }
        
        Review::where('id', $id)->update($data);
        // Review::insert($data);

        return redirect('/')->with('flash_message', '編集が完了しました');
    }


    public function delete($id)
    {
        $review = Review::where('id', $id)->where('status', 1)->first();
        $review->delete();

        return redirect('/');
    }
}
