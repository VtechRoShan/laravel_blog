@extends('layouts.app')
@section('section_bar')
<div class="col-12">
   <h2 class="section-title">Latest Articles</h2>
</div>
@endsection
@section('content')
<style>
   .content{
   padding: 0rem !important;
   }
   .shadow-custom {
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important; /* Default state with a slightly larger shadow for visibility */
   transition: box-shadow 0.3s ease-in-out !important;
   }
   .shadow-custom:hover {
   box-shadow: 0 8px 25px rgba(0, 0, 150, 0.3) !important; /* Increased blur and spread on hover, with a hint of color */
   }
</style>
<div class="col-lg-8 mb-5 mb-lg-0">
   <div class="row">
      <div class="col-12">
         <article class="card article-card article-card-sm h-100 ">
            <a href="{{ route('view_post', $categoryWithBlogs->slug) }}">
               <div class="card text-white my-3">
                  <div class="card-body p-3" style="background-color: rgba(23, 23, 33, 1);">
                     <div class="d-flex justify-content-between align-items-center">
                        <h2 class="section-title h2 text-white">{{ $categoryWithBlogs->name }}</h2>
                        <div>
                           <img src="{{ asset('path_to_author_avatar.png') }}" alt="Author" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                           <span style="font-size: 14px;">By Jack Roper &middot; </span>
                           <span style="font-size: 14px;">{{ (new DateTime($categoryWithBlogs->publish_at))->format('d M Y') }} &middot; </span>
                           <span style="font-size: 14px;">{{ $categoryWithBlogs->sharedAttributes->reading_time }} Mins reading</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card  featured_image text-white text-center overflow-hidden">
                  <img src="{{ Storage::url($categoryWithBlogs->images->featured_image) }}" class="card-img" alt="Featured Image" style="object-fit: cover; width: 100%; height: auto;">
               </div>
               <style>
                  .featured_image {
                  box-shadow: 0px 8px 6px -6px black;/* Bottom shadow */
                  /* Spread shadow */
                  }
                  .card-img-overlay {
                  transform: translateY(50%);
                  }
               </style>
            </a>
            <div class="card-body px-0">
               <ul class="post-meta mb-2">
                  {{--  @if($tags->category)
                  @foreach ($tags->category as $category)
                  <li><a href="#!">{{ $category->name }}</a></li>
                  @endforeach
                  @endif --}}
               </ul>
               <h2><a class="post-title" href="{{ route('view_post', $categoryWithBlogs->slug) }}">{{ $categoryWithBlogs->title }}</a></h2>
               <p class="card-text">{!! $categoryWithBlogs->sharedAttributes-> post_body !!}</p>
               <div class="py-3">
                  <figure class="figure mx-auto d-block">
                     <img src="{{ Storage::url($categoryWithBlogs->images->thumbnail_image) }}" class="figure-img img-fluid rounded mx-auto d-block shadow-lg shadow-custom " alt="Post Thumbnail">
                     <figcaption class="figure-caption text-center text-dark"> {{ $categoryWithBlogs->images->image_caption }} </figcaption>
                  </figure>
               </div>
               <div class="shadow-lg p-3 bg-info-tertiary rounded">
                  <h3 class="section-title h3">Summary</h3>
                  <p class="card-text">{{ $categoryWithBlogs->sharedAttributes->summary }}</p>
               </div>
            </div>
         </article>
      </div>
      @foreach($categoryWithBlogs->blogs as $key => $blog)
      <div class="{{ $key === 0 ? 'col-md-4 col-lg-4 col-sm-4' : 'col-md-4 col-lg-4 col-sm-4'}} mb-4">
         <article class="card article-card {{ $key === 0 ? '':'article-card-sm h-100' }}">
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
   </div>
</div>
<div class="col-lg-4">
   <div class="widget-blocks">
      <div class="row">
         <div class="col-lg-12">
            <div class="widget">
               <div class="widget-body">
                  <img loading="lazy" decoding="async" src="{{ asset('frontend/images/author.png') }}" alt="About Me" class="w-100 author-thumb-sm d-block">
                  <p class="mb-3 pb-2">"Discover our DevOps console—a dedicated space for DevOps aficionados, deployments enthusiasts, and security guardians. Explore our focused blogs and resources to streamline your DevOps journey." </p>
               </div>
            </div>
         </div>
         <div class="col-lg-12 col-md-6">
            <div class="widget">
               <h2 class="section-title h2">Recommended Categories</h2>
               <div class="widget-body">
               <div class="widget-list">
    @forelse($categories as $index => $category)
            @if ($index == 0) <!-- First related post -->
            <article class="card mb-4">
                <div class="card-image">
                    <div class="post-info">
                        <span class="text-uppercase">{{ $category->sharedAttributes->reading_time }} minutes read</span>
                    </div>
                    <img loading="lazy" decoding="async" src="{{ Storage::url($category->images->thumbnail_image) }}" alt="Post Thumbnail" class="w-100">
                </div>
                <div class="card-body px-0 pb-1">
                    <h3><a class="post-title post-title-sm" href="{{ route('view_post_by_category', $category->slug) }}">{{ $category->name }}</a></h3>
                    <p class="card-text">{{ Str::limit($category->sharedAttributes->summary, 150, '...') }}</p>
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
                    <p class="mb-0 small">{{ Str::limit($category->sharedAttributes->summary, 100, '...') }}</p>
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