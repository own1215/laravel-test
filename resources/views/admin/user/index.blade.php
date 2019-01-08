@extends('admin.panel')

@section('admin.content')
    <div class="card-header">{{ __('Users') }}</div>

    <div class="card-body">
        <admin-users
            :users="{{ json_encode($users) }}"
        ></admin-users>
    </div>
@endsection