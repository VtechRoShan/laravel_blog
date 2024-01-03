@extends('admin.layouts.app')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />
@endpush
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Blog</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="#">Home</a></li>
            </ol>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- right column -->
         <div class="col-md-12">
            <div class="card ">
               <div class="col-md-6 card-header">
                  <h3 class="">Add New Blog</h3>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
                     @csrf
                     <div class="form-group">
                        <label for="blog_title">Blog Post Title</label>
                        <input type="text" class="form-control" required  name='title' value="{{old('title')}}">
                        <span style="color: red">
                           @error('title')
                           {{ $message }}
                           @enderror
                        </span>
                     </div>
                     <div class='row'>
                        <div class='col-sm-6 col-md-6 col-lg-6'>
                           <div class="form-group">
                              <label for="status">Published?</label>
                              <select name='status' class='form-control'>
                                 <option value="Draft" selected> <b> Draft </b> </option>
                                 <option value="Published"> Publish</option>
                              </select>
                              <span style="color: red">
                           @error('status')
                           {{ $message }}
                           @enderror
                        </span>
                           </div>
                        </div>
                        <div class='col-sm-6 col-md-6  col-lg-6'>
                           <div class="form-group">
                              <label for="publish_at">Posted at</label>
                              <input type="date" class="form-control" name='publish_at'value="{{old('publish_at')}}" >
                              <span style="color: red">
                           @error('publish_at')
                           {{ $message }}
                           @enderror
                        </span>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="blog_post_body">Post Body (Ck Editor)
                        @if(config("blog.echo_html"))
                        (HTML)
                        @else
                        (Html will be escaped)
                        @endif
                        </label>
                        <textarea style='min-height:600px;' class="form-control blog_post_body" id="blog_post_body" name='post_body'>{{old("post_body")}}</textarea>
                        <span style="color: red">
                           @error('post_body')
                           {{ $message }}
                           @enderror
                        </span>
                     </div>
                    <hr>
                     <div class='row'>
                        <div class='col-sm-6 col-md-6 col-lg-6'>
                          <div class="form-group">
                              <label for="keyword">Keywords</label>
                              <input type="text" class="form-control" id="keyword" name='keyword' value="{{old('post_body')}}">
                              <span style="color: red">
                           @error('keyword')
                           {{ $message }}
                           @enderror
                        </span>
                           </div>
                        </div>
                        <div class='col-sm-6 col-md-6 col-lg-6'>
                            <div class="form-group">
                              <label for="blog_seo_title">SEO Title Tags  </label>
                              <input class="form-control" id="blog_seo_title" aria-describedby="blog_seo_title_help"
                                name='seo_title' type='text' value='{{old("seo_title")}}' >

                                <span style="color: red">
                                 @error('keyword')
                                 {{ $message }}
                                 @enderror
                              </span>
                          </div>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="blog_meta_desc">Meta Desc</label>
                        <textarea class="form-control" id="blog_meta_desc"
                           name='blog_meta_desc'>{{old("blog_meta_desc")}}</textarea>
                           
                           <span style="color: red">
                                 @error('blog_meta_desc')
                                 {{ $message }}
                                 @enderror
                              </span>
                        
                     </div>
                     <div class="form-group">
                        <label for="blog_short_description">Summery</label>
                        <textarea class="form-control" id="blog_short_description" aria-describedby="blog_short_description_help"
                           name='summary'>{{old("summary")}}</textarea>
                           
                           <span style="color: red">
                                 @error('summary')
                                 {{ $message }}
                                 @enderror
                              </span>
                     </div>
                     <div class='bg-white pt-4 px-4 pb-0 my-2 mb-4 rounded border'>
                       <h4>Featured Images</h4>
                       <div class="row">
                        <div class="col-md-6">
                        <div class="form-group mb-4 p-2 ">
                          
                           <label for="blog_ok">Featured Image</label>
                           <input class="form-control" type="file" name="featured_image" >
                              
                           <span style="color: red">
                                 @error('featured_image')
                                 {{ $message }}
                                 @enderror
                              </span>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group mb-4 p-2 ">
                           <label for="blog_ok">Image Thumbnail</label>
                           <input class="form-control" type="file" name="thumnail_image" >

                           <span style="color: red">
                                 @error('thumnail_image')
                                 {{ $message }}
                                 @enderror
                              </span>
                           </div>

                        </div>
                        </div>
                        <div class="form-group">
                        <label>Image Caption</label>
                        <input type="text" class="form-control" required name='image_caption' avalue='{{old("seo_title")}}' >
                        
                        <span style="color: red">
                                 @error('image_caption')
                                 {{ $message }}
                                 @enderror
                              </span>
                     </div>
                        </div>
                     </div>

                     @if( config("blog.use_wysiwyg") && config("blog.echo_html"))
                     <script src="//cdn.ckeditor.com/4.15.0/full/ckeditor.js"></script>
                     <script>
                        if( typeof(CKEDITOR) !== "undefined" ) {
                            CKEDITOR.replace('post_body');
                        }
                     </script>
                     @endif
                     <button class="btn btn-success float-right" type="submit">Add Blog</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@push('js')
<script>
   function previewImage(event) {
       var input = event.target;
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function(e) {
               document.getElementById('imagePreview').src = e.target.result;
               document.getElementById('imagePreview').style.display = 'block';
           };
           reader.readAsDataURL(input.files[0]);
       }
   }
</script>
@endpush