@extends('admin.layouts.app')
@section('content')

<script>
  function updateClock() {
    var now = new Date();
    var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var ampm = now.getHours() >= 12 ? 'pm' : 'am';
    var hours = now.getHours() % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    var minutes = now.getMinutes() < 10 ? '0' + now.getMinutes() : now.getMinutes();
    var seconds = now.getSeconds() < 10 ? '0' + now.getSeconds() : now.getSeconds();
    var strTime = days[now.getDay()] + ", " + months[now.getMonth()] + " " + now.getDate() + ", " + now.getFullYear() + " " + hours + ':' + minutes + ':' + seconds + " " + ampm;
    
    document.getElementById("realtimeClock").innerHTML = strTime;
    setTimeout(updateClock, 1000);
}

window.onload = updateClock; // Start the clock once the window has loaded.
</script>

<style>
   .breadcrumb {
      background-color: #f8f9fa; /* Light grey background */
      border-radius: 0.75rem; /* Rounded corners for the breadcrumb */
      margin-bottom: 0; /* Remove bottom margin */
      display: flex; /* Flexbox layout to align items in a row */
      align-items: center; /* Center items vertically */
      padding: 0.5rem 1rem; /* Padding around the breadcrumb */
   }
</style>

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <nav aria-label="breadcrumb">
        <ol class="breadcrumb text-primary h6">  
        <i class="fa-brands fa-laravel fa-2x mx-2  fa-beat" style="color: #db0000;"></i>   <a href="">  Dashboard </a>  <span class="mx-1 text-dark"> <b>|</b> </span>
                  <i class="fa-solid fa-hand-holding-medical mx-2  fa-beat" style="color: #000000;"></i>   <a href="">  Category </a>  <span class="mx-1 text-dark"> <b>|</b> </span>
                  <i class="fa-solid fa-pencil fa-beat-fade mx-2" style="color: #000000;"></i  <a href="">  Edit Category </a> 
        </ol>
    </nav>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <div class="d-flex flex-row float-end">
       <u> <div id="realtimeClock" class="clock" onload="showTime()"></div> </u>
    </div>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div>
    </div>
    <!-- Main content -->
    <section class="">
      <div class="mx-5 px-5 b-3">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
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
                  <script src="https://cdn.tiny.cloud/1/cx4fazq00qv7o5a2khalj041exk6e1dw82c6spm6brifoywq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

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