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
            <i class="fa-solid fa-file-circle-check fa-beat-fade mx-2" style="color: #000000;"></i>  <a href="">  Post Management </a> 
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
            <div class="row m-2">
              <div class="col-sm-6">
              <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class=" float-sm-right">
                  <!-- <li class="breadcrumb-item">                 -->
                    <a href="{{ route('blog.create')}}" class="btn btn-sm-primary btn-app">
                    <i class="fa-solid fa-2x fa-file-pen success text-success"></i> Add
                    </a>
                  <!-- </li> -->
                  <!-- <li class="breadcrumb-item">                 -->
                    <a  href=" "class="btn btn-sm btn-app">
                      <i class="fas fa-edit text-warning "></i> Trash
                    </a>
                  <!-- </li> -->
                </ol>
              </div><!-- /.col -->
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Navigation</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th>Publish</th>
                      <th>Label</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($blogs as $count => $blog)
                    <tr>
                      <td> {{$count+1}}</td>
                      <td>{{ $blog ->title  }}</td>
                      <td>{{ $blog ->navigation ->name  }}</td>
                      <td>
                          @if($blog->category)
                        @foreach ($blog->category as $category)
                            <li><a href="#!">{{ $category->name }}</a></li>
                        @endforeach
                    @endif
                      </td>
                      <td>{{ $blog ->sharedAttributes ->status  }}</td>
                      <td>{{ $blog -> publish_at  }}</td>
                      <td class="text-right py-0 align-middle">
                        <div class="btn-group btn-group-sm">
                        <a href="{{ route('blog.show', $blog ->id )}}" class="btn btn-sm btn-primary m-2"><i class="fas fa-eye"></i></a>
                          <a href="{{ route('blog.edit', $blog ->id )}}" class="btn btn-sm btn-info m-2"><i class="fas fa-edit"></i></a>
                          <button class="btn btn-sm btn-danger m-2 " data-toggle="tooltip" data-placement="top" title="Delete"
                                                onclick="handleDelete('{{ $blog ->id }} ')"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></button>
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                     <h2>Sorry No Data </h2> </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div>
            </div>
            <div class="modal modal-bg-issue fade " style="background-color:transparent !important; border:none !important" id="confirmDeleteModal">
        <div class="modal-dialog" style="margin-top:60px !important">
            <form method="POST" id="deleteBlogForm" action="">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Blog</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center text-bold">Are you sure you want to delete this Blog?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Go Back</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </form>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <script>
        function handleDelete(id) {
            var form = document.getElementById('deleteBlogForm');
            form.action = 'blog/' + id;
            $('#confirmDeleteModal').modal('show');
        }
    </script>
@endsection