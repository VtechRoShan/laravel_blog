@extends('layouts.app')
@section('section_bar')
<div class="col-12">
    <div class="breadcrumbs mb-4">
        <a href="index.html">Home</a>
        <span class="mx-1">/</span>
        <a href="#!">Contact</a>
    </div>
</div>
@endsection
@section('content')
<style>
    .content{
        padding: 0rem !important;
    }
</style>
<div class="col-lg-8 mb-5 mb-lg-0">
    <article>
        <img loading="lazy" decoding="async" src="{{ Storage::url($blog->images->featured_image) }}" alt="Post Thumbnail" class="w-100">
        <ul class="post-meta mb-2 mt-4">
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="margin-right:5px;margin-top:-4px" class="text-dark" viewBox="0 0 16 16">
                    <path d="M5.5 10.5A.5.5 0 0 1 6 10h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z" />
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z" />
                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z" />
                </svg> <span>29 May, 2021</span>
            </li>
            <li> <a href="/categories/destination">destination</a>
            </li>
        </ul>
        <h1 class="my-3">Top 7 Reasons to Visit Denver this Summer</h1>
        <div> {!!  $blog->sharedAttributes->post_body !!} </div>
    </article>
</div>


<div class="col-lg-4">
    <div class="widget-blocks">
    <div class="row">
        <div class="col-lg-12">
        <div class="widget">
            @foreach($blog->category as $category)
            <div class="widget m-0">
            <img loading="lazy" decoding="async" src="" alt="About Me" class="w-100 author-thumb-sm d-block">
            <style>
                .clickme {
                    background-color: #EEEEEE;
                    padding: 4px 10px;
                    text-decoration:none;
                    font-weight:bold;
                    border-radius:5px;
                    cursor:pointer;
                }
            </style>
            <span class="widget-title h3"> {{ $category-> name}}  &nbsp; &nbsp; &nbsp;</span><span class="mb-3 pb-2"></span> <a href="about.html" class="clickme">Read More</a>
            </div>
            @endforeach
        </div>
        </div>
        <div class="col-lg-12 col-md-6">
        <div class="widget">
            <h2 class="section-title mb-3">Recommended</h2>
            <div class="widget-body">
                <div class="widget-list">
                    @forelse ($relatedPosts as $index => $relatedPost)
                        @if ($index == 0)  <!-- First related post -->
                            <article class="card mb-4">
                                <div class="card-image">
                                    <div class="post-info"> <span class="text-uppercase">1 minutes read</span></div>
                                    <img loading="lazy" decoding="async" src="{{ Storage::url($relatedPost->images->thumbnail_image) }}" alt="Post Thumbnail" class="w-100">
                                </div>
                                <div class="card-body px-0 pb-1">
                                    <h3><a class="post-title post-title-sm" href="{{ route('view_post', $relatedPost->slug) }}">{{ $relatedPost->title }}</a></h3>
                                    <p class="card-text">{{ Str::limit($relatedPost->description, 150, '...') }}</p>
                                    <div class="content"> <a class="read-more-btn" href="{{ route('view_post', $relatedPost->slug) }}">Read Full Article</a></div>
                                </div>
                            </article>
                        @else  <!-- Other related posts -->
                            <a class="media align-items-center" href="{{ route('view_post', $relatedPost->slug) }}">
                                <img loading="lazy" decoding="async" src="{{ Storage::url($relatedPost->images->thumbnail_image) }}" alt="Post Thumbnail" class="w-100">
                                <div class="media-body ml-3">
                                    <h3 style="margin-top:-5px">{{ $relatedPost->title }}</h3>
                                    <p class="mb-0 small">{{ Str::limit($relatedPost->description, 100, '...') }}</p>
                                </div>
                            </a>
                        @endif
                    @empty
                        <p>No related posts found.</p>
                    @endforelse
                </div>
            </div>
        </div>
        </div>
        <div class="col-lg-12 col-md-6">
        <div class="widget">
            <h2 class="section-title mb-3">Tags in </h2>
            <div class="widget-body">
            <ul class="widget-list">
            @foreach($blog->tags as $tag)
                <li><a href="{{ route('view_post_by_tag', $tag->slug) }}">#{{ (str_replace(' ', '', $tag->name)) }}</a></li>
                @endforeach
                </li>
            </ul>
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