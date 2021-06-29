@extends('admin.layouts.app')

@section('title')
    <title>{{ trans('message.publishers') }}</title>
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-4 mb-4">
    <h2>{{ trans('message.publishers') }}</h2>
    <div><a href="{{ route('publishers.create') }}"><button class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i>
        {{ trans('message.add_publisher') }}</button></a></div>
  </div>
  <h2 class="mt-4 pb-2"></h2>
  
  <div class="input-group mb-3">
    <form action="{{ route('publishers.index') }}" method="GET" class="form-inline input-group">
      <input name="search" type="text" class="form-control" placeholder="">
      <div class="input-group-append" id="button-addon4">
        <button type="submit" class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
        <a href="#" class="btn btn-outline-secondary"><i class="fas fa-file-export"></i></a>
      </div>
    </form>
  </div>
  
  @if( session()->has('del_success'))
    <div class="alert alert-success">{{ session()->get('del_success') }}</div>
  @elseif( session()->has('add_success'))
    <div class="alert alert-success">{{ session()->get('add_success') }}</div>
  @elseif( session()->has('update_success'))
    <div class="alert alert-success">{{ session()->get('update_success') }}</div>
  @endif
  
  <table class="table table-bordered bg-white">
    <thead>
      <tr>
        <th scope="col">{{ trans('message.id') }}</th>
        <th scope="col">{{ trans('message.name') }}</th>
        <th scope="col">{{ trans('message.description') }}</th>
        <th scope="col" colspan="2">{{ trans('message.actions') }}</th>
      </tr>
    </thead>
    <tbody>
  
      @foreach($publishers as $key => $publisher)
        <tr>
          <th scope="row">{{ $key+1 }}</th>
          <td>{{ $publisher->pub_name }}</td>
          <td>{{ $publisher->pub_desc }}</td>
          <td>
            <form action="{{ route('publishers.destroy', $publisher->pub_id) }}" method="post">
              <div class="input-group">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="input-group-append" id="button-addon4">
                  <a href="{{ route('publishers.edit', $publisher->pub_id) }}" class="btn btn-sm btn-outline-success"><i class="fa fa-pen"aria-hidden="true"></i></a>
                  <button class="btn btn-sm btn-outline-danger ml-1" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </div>
              </div>
            </form>
          </td>
        </tr>
      @endforeach
      
    </tbody>
  </table>
  <div class="col-md-12 text-center justify-content-center">
    <nav aria-label="Page navigation">
        {{ $publishers->links() }}
    </nav>
  </div>
  
@endsection