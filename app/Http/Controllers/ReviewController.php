<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;

class ReviewController extends Controller
{
    public function index()
    {
        // statusが1(アクティブ)のレコードのみ表示する条件指定
        $reviews = Review::where('status', 1)->orderBy('created_at', 'DESC')->paginate(6);
        // dd($reviews);
        return view('review.index', compact('reviews'));
    }

    public function create()
    {
        return view('review.create');
    }

    public function store(Request $request)
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

        Review::insert($data);

        return redirect('/')->with('flash_message', '投稿が完了しました');
    }

    public function show($id)
    {
        $review = Review::where('id', $id)->where('status', 1)->first();

        return view('review.show', compact('review'));
    }
}
