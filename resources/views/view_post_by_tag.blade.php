@extends('layouts.app')
@section('section_bar')
<div class="col-12"><h2 class="section-title">Latest Articles</h2></div>
@endsection
@section('content')
<style>
    .content{
        padding: 0rem !important;
    }
</style>
<div class="col-lg-8 mb-5 mb-lg-0">
    <div class="row">
        
        @foreach($tags->blogs as $key => $blog)
        <div class="{{ $key === 0 ? 'col-12' : 'col-md-6 col-lg-6 col-sm-6'}} mb-4">
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
            <h2 class="section-title h2">Recommended</h2>
            <div class="widget-body">
              <div class="widget-list">
                  @foreach($categories as $category)
                      @if($loop->first)
                          <!-- First Category in an article tag -->
                          <article class="card mb-4">
                              <div class="card-image">
                                  <div class="post-info"> <span class="text-uppercase">1 minutes read</span> </div>
                                  <img loading="lazy" decoding="async" src="{{ asset('storage/' . $category->thumbnail_image) }}" alt="Post Thumbnail" class="w-100">
                              </div>
                              <div class="card-body px-0 pb-1">
                                  <h3><a class="post-title post-title-sm" href="article.html">{{ $category->name }}</a></h3>
                                  <p class="card-text">{{ $category->summary }}</p>
                                  <div class="content"> <a class="read-more-btn" href="article.html">Read Full Article</a> </div>
                              </div>
                          </article>
                      @else
                          <!-- Other Categories in 'a' tags -->
                          <a class="media align-items-center" href="article.html">
                              <!-- You might want to replace 'No Image Specified' with actual image logic -->
                              <span class="image-fallback image-fallback-xs">No Image Specified</span>
                              <div class="media-body ml-3">
                                  <h3 style="margin-top:-5px">{{ $category->name }}</h3>
                                  <p class="mb-0 small">{{ $category->summary }}</p>
                              </div>
                          </a>
                      @endif
                  @endforeach
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-6">
            <div class="widget">
            <h2 class="section-title h2">Categories</h2>
                <div class="widget-body">
                <ul class="widget-list">
                    @foreach($categories as $category)
                    <li><a href="#!">{{ $category->name }}......<span class="ml-auto">({{ $category->blogs->count()  }})</span></a>
                    </li>
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