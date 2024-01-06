@extends('admin.layouts.app')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Navigation</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
            <div class="row m-2">
              <div class="col-sm-6">
              <div class="card-header">
                <h3 class="card-title">Navigation Table</h3>
              </div>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class=" float-sm-right">
                  <!-- <li class="breadcrumb-item">                 -->
                    <a href="{{ route('navigation.create')}}" class="btn btn-sm-success btn-app">
                      <i class="fas fa-pen"></i> Add
                    </a>
                  <!-- </li> -->
                  <!-- <li class="breadcrumb-item">                 -->
                    <a  href=" "class="btn btn-sm btn-app">
                      <i class="fas fa-edit"></i> Trash
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
                      <th>Image</th>
                      <th>Blogs</th>
                      <th>Last Update</th>
                      <th>Label</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($navigations as $key =>$navigation)
                    <tr>
                      <td>{{ $key+1  }}</td>
                      <td>{{ $navigation ->name  }}</td>
                      <td>{{ $navigation ->image  }}</td>
                      <td>View Blogs</td>
                      <td>{{ $navigation -> created_at  }}</td>
                      <td class="text-right py-0 align-middle">
                        <div class="">
                          <a href="{{ route('navigation.show', $navigation ->id )}}" class="btn btn-sm btn-primary m-2"><i class="fas fa-eye"></i></a>
                          <a href="{{ route('navigation.edit', $navigation ->id )}}" class="btn btn-sm btn-info m-2"><i class="fas fa-edit"></i></a>
                          <button class="btn btn-sm btn-danger m-2 " data-toggle="tooltip" data-placement="top" title="Delete"
                                                onclick="handleDelete('{{ $navigation ->id }} ')"><i class="fa fa-trash"
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
            form.action = 'navigation/' + id;
            $('#confirmDeleteModal').modal('show');
        }
    </script>



  @endsection