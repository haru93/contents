@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@section('content')
  <div class="container">
    <!-- 検索バー -->
    <div class="row justify-content-end pr-3 pb-4">
      <div class="col-mb-4">
        <form method="GET" action="{{ route('review.index') }}" class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" name="search" type="search" placeholder="検索" aria-label="Search">
          <button class="btn btn-primary my-2 my-sm-0" type="submit">検索する</button>
        </form>
      </div>
    </div>

    <div class="row justify-content-center">
      <!-- レビューの数だけパネルを表示 -->
      @foreach($reviews as $review)
        <div class="col-md-4">
            <div class="card mb50">
                <div class="card-body">
                    @if(!empty($review->image))
                      <div class='image-wrapper'><img class='content-image' src="{{ asset($review->image) }}"></div>
                    @else
                      <div class='image-wrapper'><img class='content-image' src="{{ asset('images/dummy.png') }}"></div>
                    @endif
                    <h3 class='h3 content-title'>{{ $review->title }}</h3>
                    <p class='description'>{{ $review->body }}</p>
                    <a href="{{ route('review.show', ['id' => $review->id ]) }}" class='btn btn-secondary detail-btn'>詳細</a>
                </div>
            </div>
        </div>
      @endforeach
    </div>
    {{ $reviews->links() }}
  </div>
@endsection