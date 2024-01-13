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
                  <i class="fa-solid fa-compass fa-beat mx-2" style="color: #000000;"></i>  <a href="">  Navigations </a> <span class="mx-1 text-dark"> <b>|</b> </span>
                  <i class="fa-solid fa-route fa-beat-fade mx-2" style="color: #000000;"></i  <a href="">  Create Navigation </a> 
               </ol>
            </nav>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <div class="d-flex flex-row float-end">
                  <u>
                     <div id="realtimeClock" class="clock" onload="showTime()"></div>
                  </u>
               </div>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
</div>
<!-- Main content -->
<section class="content">
   <div class="mx-5 px-5 b-3">
      <div class="row">
         <!-- right column -->
         <div class="col-md-12">
            <div class="card ">
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
                           <input class="form-control" type="file" name="thumbnail_image" >

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