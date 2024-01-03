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
              <li class="breadcrumb-item active">Dashboard</li>
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
                <h3 class="card-title">Bordered Table</h3>
              </div>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class=" float-sm-right">
                  <!-- <li class="breadcrumb-item">                 -->
                    <a href="{{ route('category.create')}}" class="btn btn-sm-success btn-app">
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
                      <th>Description</th>
                      <th>Image</th>
                      <th>Icon</th>
                      <th>Blogs</th>
                      <th>Last Update</th>
                      <th>Label</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($categories as $key =>$category)
                    <tr>
                      <td>{{ $key+1  }}</td>
                      <td>{{ $category ->name  }}</td>
                      <td>{{ $category ->description  }}</td>
                      <td>{{ $category ->image  }}</td>
                      <td>{{ $category ->cat_icon  }}</td>
                      <td>View Blogs</td>
                      <td>{{ $category -> created_at  }}</td>
                      <td class="text-right py-0 align-middle">
                        <div class="btn-group btn-group-sm">
                          <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                          <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
  @endsection