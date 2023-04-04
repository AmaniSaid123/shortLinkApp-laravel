@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-style">{{ __('Update Link') }}</div>
                <div class="col-lg-12">
                    <div class="pull-right ">
                        <a class="btn btn-info back-button" href="{{ route('links.index') }}"> Back</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="{{ route('links.update',$link->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-outline mb-4 col-md-4">
                            <label class="form-label" for="form2Example11"> {{ __('URL') }}</label>
                            <input type="url" name="url" value="{{ $link->url }}" class="form-control" placeholder="Url">

                            @error('url')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="btn btn-success btn-block" type="submit">
                                Update
                            </button>

                        </div>
                    </form>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection