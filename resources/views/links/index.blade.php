@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-style">{{ __('Links') }}</div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    <a class="btn btn-primary btn-color btn-block" href="{{ route('links.create') }}"> {{ __('Add') }}</a>
                    <table class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>Name</th>
                                <th>Url</th>
                                <th>Short Url</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($links as $link)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://www.w3schools.com/howto/img_avatar.png" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                                        <div class="ms-3">
                                            <p class="fw-bold mb-1">{{$link->user->name}}</p>
                                            <p class="text-muted mb-0">{{$link->user->email}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">{{$link->url}}</p>
                                </td>
                                <td>
                                    <a href="{{ url($link->url) }}" class="uhover">{{$link->short_url}}</a>
                                </td>
                                <td>{{$link->created_at}}</td>
                                <td>
                                    <form action="{{ route('links.destroy', $link->id) }}" method="Post">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-link btn-sm btn-rounded">
                                            Delete
                                        </button>
                                        <a class="btn btn-link btn-sm btn-rounded" href="{{ route('links.edit',$link->id) }}">Edit</a>

                                    </form>
                                
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        {!! $links->links() !!}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection