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
            <div class="card-body d-flex">
                <div class="btn-group">
                    <form method="GET" action="{{ route('review.edit', ['id' => $review->id]) }}">
                        @csrf
                        <input type='submit' class='btn btn-primary' value='編集'>
                    </form>
                    <form method="POST" action="{{ route('review.delete', ['id' => $review->id ])}}" id="delete_{{ $review->id}}" >
                        @csrf
                        <a href="#" class="btn btn-danger" data-id="{{ $review->id }}" onclick="deletePost(this);" >削除</a>
                    </form>
                </div>
            </div>
            <a href="{{ route('review.index') }}" class='btn btn-info btn-back mb20'>一覧へ戻る</a>
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