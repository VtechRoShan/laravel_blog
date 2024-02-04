@extends('layouts.app')
@section('site_title', 'The DevOps Console')
@section('meta_tag', '')
@section('meta_description','Hello World')
@section('content')
<style>
    .content{
        padding: 0rem !important;
    }
</style>

<div class="col-lg-12 col-md-12-col-sm-12">
    <div class="widget-blocks">
    <div class="row">
    <div class="col-12">
        <div class="breadcrumbs mb-4"> <a href="{{ route('/') }}">Home</a>
            <span class="mx-1">/</span>  <a href="">All Tags</a>
            <span class="mx-1"></span>  <a href=""></a>
        </div>
        <h1 class="mb-4 border-bottom border-primary d-inline-block"> All Tags</h1>
    </div>
    <style>
        .custom-h3 {
            margin-top: -5px;
            font-size: 1.5rem;
            color: #333;
        }
        .custom-h4 {
            font-size: 1rem;
            color: #666;
        }
     </style>
        <div class="col-12">
            <div class="widget">
                <div class="widget-body">
                    <div class="widget-list">

                        @forelse($all_tags as $index=> $tag)
                           <!-- Other related posts -->
                                <a class="media align-items-center" href="{{ route('view_post_by_tag', $tag->slug) }}">
                                    <img loading="lazy" decoding="async" src="{{ Storage::url($tag->images->thumbnail_image) }}" alt="Post Thumbnail" class="w-100">
                                    <div class="media-body ml-3">
                                        <!-- <h3 style="margin-top:-5px">  {{ $tag->blogs->count()  }}  {{ (new DateTime($tag->publish_at))->format('d M Y') }} </h3> -->
                                        <div class="d-flex justify-content-between">
                                                <h3 class="custom-h3" >{{ $tag->name }} </h3>
                                                <h4 class="custom-h4">{{ (new DateTime($tag->publish_at))->format('d M Y') }} </h4>
                                        </div>
                                        <p class="mb-0 small">{!!  Str::limit(strip_tags($tag->post_body), 200, '...')  !!}</p>
                                    </div>
                                </a>
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