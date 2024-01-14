@extends('layouts.app')
@section('content')
<style>
    .content{
        padding: 0rem !important;
    }
</style>
<div class="col-lg-8 mb-5 mb-lg-0">
    <div class="row">
        @foreach($blogs as $key => $blog)
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
                <div class="content"> <a class="read-more-btn" href="{{ route('view_post', $blog->slug) }}">R Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nisi, placeat eius? Optio vero rerum quaerat maxime fugit maiores harum ad, ipsa, placeat nobis dolor sequi exercitationem ipsam, recusandae ea. Tenetur. {{$key}}</a>
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
@endsection


@push('js')
<script>
    // your code
</script>
@endpush