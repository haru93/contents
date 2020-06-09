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
                  <h2 class='h2'>タイトル</h2>
                  <p class='h2 mb20'>{{ $review->title }}</p>
                  <h2 class='h2'>レビュー本文</h2>
                  <p>{{ $review->body }}</p>
                </section>  
                <aside class='review-image'>
                  @if(!empty($review->image))
                      <img class='content-image' src="{{ asset('storage/images/'.$review->image) }}">
                  @else
                      <img class='content-image' src="{{ asset('images/dummy.png') }}">
                  @endif
                </aside>
                <form method="GET" action="{{ route('review.edit', ['id' => $review->id]) }}">
                    @csrf
                    <input type='submit' class='btn btn-primary' value='編集する'>
                </form>
            </div>
            <a href="{{ route('review.index') }}" class='btn btn-info btn-back mb20'>一覧へ戻る</a>
        </div>
</div>
@endsection