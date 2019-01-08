@extends('admin.panel')

@section('admin.content')
    <div class="card-header">{{ __('Images (tap to image to change users)') }}</div>

    <div class="card-body">
        <admin-images
                :images="{{ json_encode($images) }}"
                :users="{{ json_encode($users) }}"
        ></admin-images>
    </div>
@endsection