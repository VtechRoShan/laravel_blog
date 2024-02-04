@extends('layouts.app')
@section('section_bar')
<div class="col-12"><h2 class="section-title"></h2></div>
@endsection
@section('content')
<style>
    .content{
        padding: 0rem !important;
    }
</style>
<div class="col-lg-8 mb-5 mb-lg-0">
    <div class="row">

        <div class="col-12">
            <article class="card article-card article-card-sm h-100 ">
            <a href="{{ route('view_post', $tags->slug) }}">
                <div class="card-image">
                <div class="post-info"> <span class="text-uppercase">{{ (new DateTime($tags->publish_at))->format('d M Y') }}</span></div>
                <img loading="lazy" decoding="async" src="{{ Storage::url($tags->images->thumbnail_image) }}" alt="Post Thumbnail" class="w-100">
                </div>
            </a>
            <div class="card-body px-0">
            <ul class="post-meta mb-2">
                @if($tags->category)
                    @foreach ($tags->category as $category)
                        <li><a href="#!">{{ $category->name }}</a></li>
                    @endforeach
                @endif
            </ul>
                <h2><a class="post-title" href="{{ route('view_post', $tags->slug) }}">{{ $tags->title }}</a></h2>
                <p class="card-text">{!! $tags-> post_body !!}</p>
            </div>
            </article>
        </div>

        @foreach($tags->blogs as $blog)
        <div class="col-md-4 col-lg-4 col-sm-4 mb-4 mt-3">
            <article class="card article-card article-card-sm h-100">
            <a href="{{ route('view_post', $blog->slug) }}">
                <div class="card-image">
                <div class="post-info"> <span class="text-uppercase">{{ (new DateTime($blog->publish_at))->format('d M Y') }}</span>
                    <span class="text-uppercase">{{$blog-> sharedAttributes -> reading_time }} minute reads</span>
                </div>
                <img loading="lazy" decoding="async" src="{{ Storage::url($blog->images->thumbnail_image) }}" alt="Post Thumbnail" class="w-100">
                </div>
            </a>
            <div class="card-body px-0">
            <ul class="post-meta mb-2">
                @if($blog->category)
                    @foreach ($blog->category as $category)
                        <li><a href="#!">{{ $category->name }}</a></li>
                    @endforeach
                @endif
            </ul>
                <h2><a class="post-title" href="{{ route('view_post', $blog->slug) }}">{{ $blog->title }}</a></h2>
                <p class="card-text">{{ $blog-> sharedAttributes ->summary }}</p>
                <div class="content"> <a class="read-more-btn" href="{{ route('view_post', $blog->slug) }}">Read Full Article</a>
                </div>
            </div>
            </article>
        </div>
        @endforeach
        <div class="col-12">
            <div class="row">
            <div class="col-12">
                <nav class="mt-4">
                <!-- pagination -->
                <nav class="mb-md-50">
                    <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="#!" aria-label="Pagination Arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                        </a>
                    </li>
                    <li class="page-item active "> <a href="{{ route('/') }}" class="page-link">1 </a> </li>
                    <li class="page-item"> <a href="#!" class="page-link"> 2 </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#!" aria-label="Pagination Arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                        </svg>
                        </a>
                    </li>
                    </ul>
                </nav>
                </nav>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="widget-blocks">
      <div class="row">
        <div class="col-lg-12 col-md-6">
          <div class="widget">
            <h2 class="section-title h2"> All Tags</h2>
            <div class="widget-body">
            <div class="widget-list">
                        @forelse($alltags as $index => $category)
                            @if ($index == 0) <!-- First related post -->
                            <article class="card mb-4">
                                <div class="card-image">
                                    <img loading="lazy" decoding="async" src="{{ Storage::url($category->images->thumbnail_image) }}" alt="Post Thumbnail" class="w-100">
                                </div>
                                <div class="card-body px-0 pb-1">
                                    <h3><a class="post-title post-title-sm" href="{{ route('view_post_by_category', $category->slug) }}">{{ $category->name }}</a></h3>
                                    <p class="card-text">{!! Str::limit(strip_tags($category->post_body), 70, '...') !!}</p>
                                    <div class="content">
                                        <a class="read-more-btn" href="{{ route('view_post_by_category', $category->slug) }}">Read Full Article</a>
                                    </div>
                                </div>
                            </article>
                            @else <!-- Other related posts -->
                            <a class="media align-items-center" href="{{ route('view_post_by_category', $category->slug) }}">
                                <img loading="lazy" decoding="async" src="{{ Storage::url($category->images->thumbnail_image) }}" alt="Post Thumbnail" class="w-100">
                                <div class="media-body ml-3">
                                    <h3 style="margin-top:-5px">{{ $category->name }}</h3>
                                    <p class="mb-0 small">{!! Str::limit(strip_tags($category->post_body), 30, '...') !!}</p>
                                </div>
                            </a>
                            @endif
                        @empty
                        <p>No Data Found.</p>
                        @endforelse
                    </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection


@push('js')
<script>
    // your code
</script>
@endpush