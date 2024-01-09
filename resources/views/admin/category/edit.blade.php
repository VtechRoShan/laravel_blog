@extends('admin.layouts.app')
@section('content')

<style>
   .fixed-size-image {
    width: 200px; /* Fixed width */
    height: 200px; /* Fixed height */
    object-fit: cover; /* This keeps the aspect ratio and fills the box */
}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Category</h1>
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
                  <h5 class="">Edit Category</h5>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <form method="post" action="{{ route('category.update', $category->id ) }}"  enctype="multipart/form-data">
                     @csrf
                     @method('put')
                     <div class="form-group">
                        <label for="blog_title">Name</label>
                        <input type="text" class="form-control" required  name='name' value="{{ $category->name }}">
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
                              <label for="cat_icon">Category Icon</label>
                              <input type="text" class="form-control" name='cat_icon'value="{{ $category -> cat_icon }}" >
                              <span style="color: red">
                           @error('cat_icon')
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
                        <textarea style='min-height:400px;' class="form-control blog_post_body" id="blog_post_body" name='post_body'>{{ $category->sharedAttributes->post_body  }}</textarea>
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
                              <input type="text" class="form-control" id="keyword" name='keyword' value="{{ $category->sharedAttributes->keyword }}">
                              <span style="color: red">
                           @error('keyword')
                           {{ $message }}
                           @enderror
                        </span>
                           </div>
                        </div>
                        <div class='col-sm-6 col-md-6 col-lg-6'>
                            <div class="form-group">
                              <label for="seo_title">SEO Title Tags  </label>
                              <input class="form-control" id="blog_seo_title" aria-describedby="blog_seo_title_help"
                                name='seo_title' type='text' value="{{ $category->sharedAttributes->seo_title  }}" >

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
                           name='meta_desc'> {{ $category->sharedAttributes->meta_desc  }} </textarea>
                           
                           <span style="color: red">
                                 @error('meta_desc')
                                 {{ $message }}
                                 @enderror
                              </span>
                        
                     </div>
                     <div class="form-group">
                        <label for="blog_short_description">Summery</label>
                        <textarea class="form-control" id="blog_short_description" aria-describedby="blog_short_description_help"
                           name='summary'>  {{ $category->sharedAttributes->summary  }}  </textarea>
                           
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
                              <input type="file"name="featured_image" class="form-control" accept="image/" onchange="previewImage(this, 'featured-preview')">
                              <img src="{{ Storage::url($category->images->featured_image) }}" width="200px" style="padding-top:10px" class="fixed-size-image" id="featured-preview">
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
                           <input class="form-control " type="file" name="thumbnail_image" accept="image/" onchange="previewImage(this, 'thumbnail-preview')" >
                           <img src="{{ Storage::url($category->images->thumbnail_image) }}" width="200px"style="padding-top:10px" class="fixed-size-image" id="thumbnail-preview">
                           <span style="color: red">
                                 @error('thumbnail_image')
                                 {{ $message }}
                                 @enderror
                              </span>
                           </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <label>Image Caption</label>
                        <input type="text" class="form-control" required name='image_caption'  value="{{ $category ->images->image_caption }}" >
                        
                        <span style="color: red">
                                 @error('image_caption')
                                 {{ $message }}
                                 @enderror
                              </span>
                     </div>
                        </div>
                  </div>
                     <button class="btn btn-primary float-right" type="submit">Add Blog</button>
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
   function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById(previewId).setAttribute('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush