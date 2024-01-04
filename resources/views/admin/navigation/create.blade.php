@extends('admin.layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Navigation</h1>
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
                  <h5 class="">Add New Navigation</h5>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <form action="{{ route('navigation.store') }}" method="post" enctype="multipart/form-data">
                     @csrf

                     <div class='row'>
                        <div class='col-sm-6 col-md-6 col-lg-6'>
                        <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" required  name='name' value="{{old('name')}}">
                        <span style="color: red">
                           @error('name')
                           {{ $message }}
                           @enderror
                        </span>
                     </div>
                        </div>
                        <div class='col-sm-6 col-md-6 col-lg-6'>
                            <div class="form-group">
                              <label for="seo_title">SEO Tags  </label>
                              <input class="form-control" id="seo_title" aria-describedby="seo_title"
                                name='seo_title' type='text' value='{{old("seo_title")}}' >

                                <span style="color: red">
                                 @error('seo_title')
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
                     <button class="btn btn-primary float-right" type="submit">Add Navigation</button>
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