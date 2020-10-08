@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endsection

@section('content')
<h1 class='pagetitle container'>レビュー編集ページ</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <div class="col-md-10">
        <form method='POST' action="{{ route('review.update', ['id' => $review->id ]) }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                <div class="form-group">
                    <label>タイトル</label>
                    <input type='text' class='form-control' name='title' value="{{ $review->title }}">
                </div>
                <div class="form-group">
                <label>レビュー本文</label>
                    <textarea class='description form-control' name='body'>{{ $review->body }}</textarea>
                </div>
                <aside class='review-image'>
                    @if(!empty($review->image))
                        <img class='content-image' src="{{ asset($review->image) }}">
                    @else
                        <img class='content-image' src="{{ asset('images/dummy.png') }}">
                    @endif
                </aside>
                <div class="form-group">
                    <label for="file1">画像を変更する</label>
                    <input type="file" id="file1" name='image' class="form-control-file">
                </div>
                <input type='submit' class='btn btn-primary' value='更新'>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection