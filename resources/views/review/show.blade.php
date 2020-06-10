@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1 class='pagetitle'>レビュー詳細ページ</h1>
        <div class="card">
            <div class="card-body d-flex">
                <section class='review-main'>
                  <h2 class='h4'>タイトル</h2>
                  <p class='mb20'>{{ $review->title }}</p>
                  <h2 class='h4'>レビュー本文</h2>
                  <p>{{ $review->body }}</p>
                </section>  
                <aside class='review-image'>
                  @if(!empty($review->image))
                      <img class='content-image' src="{{ asset('storage/images/'.$review->image) }}">
                  @else
                      <img class='content-image' src="{{ asset('images/dummy.png') }}">
                  @endif
                </aside>
            </div>
            <div class="d-flex justify-content-around">
                <a href="{{ route('review.index') }}" class='btn btn-info btn-style mb20'>一覧へ戻る</a>
                <form method="GET" action="{{ route('review.edit', ['id' => $review->id]) }}">
                    @csrf
                    <input type='submit' class='btn btn-success btn-style mb20' value='編集する'>
                </form>
                <form method="POST" action="{{ route('review.delete', ['id' => $review->id ])}}" id="delete_{{ $review->id}}" >
                    @csrf
                    <a href="#" class="btn btn-danger btn-style mb20" data-id="{{ $review->id }}" onclick="deletePost(this);" >削除する</a>
                </form>
            </div>
        </div>
</div>

<script>
    /************************************
    削除ボタンを押してすぐにレコードが削除
    されるのも問題なので、一旦javascriptで
    確認メッセージを流します。
    *************************************/
    function deletePost(e) {
        'use strict';
        if (confirm('本当に削除していいですか?')) {
        document.getElementById('delete_' + e.dataset.id).submit();
        }
    }
</script>

@endsection