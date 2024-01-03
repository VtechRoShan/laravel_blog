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
                        <label for="blog_post_body">Post Body (Tiny Mice)
                        @if(config("blog.echo_html"))
                        (HTML)
                        @else
                        (Html will be escaped)
                        @endif
                        </label>
                        <textarea style='min-height:400px;' class="form-control blog_post_body" id="blog_post_body" name='post_body'>{{old("post_body")}}</textarea>
                        <span style="color: red">
                           @error('post_body')
                           {{ $message }}
                           @enderror
                        </span>
                     </div>

                  <!-- Place the first <script> tag in your HTML's <head> -->
                  <script src="https://cdn.tiny.cloud/1/0nnxiieaki9dx4u1xtnwick76s9pfptyigrrv9xlwo6nmsvt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

                  <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
                  <script>
                    tinymce.init({
                      selector: '#blog_post_body',
                      plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
                      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                      tinycomments_mode: 'embedded',
                      tinycomments_author: 'Author name',
                      mergetags_list: [
                        { value: 'First.Name', title: 'First Name' },
                        { value: 'Email', title: 'Email' },
                      ],
                      ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
                    });
                  </script>

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
                        <label for="meta_desc">Meta Desc</label>
                        <textarea class="form-control" id="meta_desc"
                           name='meta_desc'>{{old("meta_desc")}}</textarea>
                           
                           <span style="color: red">
                                 @error('meta_desc')
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
                  
                     <div class="form-group">
                        <div class='bg-white pt-4 px-4 pb-0 my-2 mb-4 rounded border'>
                           <h4>Select Navigation Section:</h4>
                           <div class='row '>
                                 <select name='nav_bar_id' class='form-control'>
                                    <option  selected value="Navigation"> <b> Select </b> </option>
                                    @foreach($navigations as $navigation)
                                    <option value="{{ $navigation->id }}"> <b> {{ $navigation->name }} </b> </option>
                                    @endforeach
                                 </select>
                                 <span style="color: red">
                                       @error('nav_bar_id')
                                       {{ $message }}
                                       @enderror
                                 </span>
                              
                              <div class='col-md-12 my-3 text-center'>
                                 <em><a class="a-link-cart-color" target='_blank' href=''><i class="fa fa-external-link" aria-hidden="true"></i>
                              </a></em>
                              </div>
                           </div>
                        </div>
                     </div>

                      <div class='bg-white pt-4 px-4 pb-0 my-2 mb-4 rounded border'>
                        <h4>Available Categories:</h4>
                        <div class='row'>
                           @forelse($categories as $category)
                           <div class="form-check col-sm-2">
                                    <input class="form-check-input" type="checkbox" name="category_id[]" value="{{$category->id}}" id="tags_check{{$category->id}}">
                                    <label class="form-check-label" for="category_check{{$category->id}}">
                                       {{$category->name}}
                                    </label>
                                 </div>
                           @empty
                           <div class='col-sm-2'>
                              No categories
                           </div>
                           @endforelse
                           <div class='col-md-12 my-3 text-center'>
                              <em><a class="a-link-cart-color" href=''><i class="fa fa-external-link" aria-hidden="true"></i>
                              Add new categories here</a></em>
                           </div>
                        </div>
                     </div>

                     <div class='bg-white pt-4 px-4 pb-0 my-2 mb-4 rounded border'>
                        <h4>Select Available Tags:</h4>
                        <div class='row'>
                           @forelse($tags as $tag)
                                 <div class="form-check col-sm-2">
                                    <input class="form-check-input" type="checkbox" name="tag_id[]" value="{{$tag->id}}" id="tags_check{{$tag->id}}">
                                    <label class="form-check-label" for="tags_check{{$tag->id}}">
                                       {{$tag->name}}
                                    </label>
                                 </div>
                           @empty
                                 <div class='col-sm-12'>
                                    No tags available.
                                 </div>
                           @endforelse
                           <div class='col-md-12 my-3 text-center'>
                                 <em><a class="a-link-cart-color" href=''>
                                    <i class="fa fa-external-link" aria-hidden="true"></i>
                                    Add new tags here </a></em>
                           </div>
                        </div>
                     </div>
                  </div>
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