@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="item">
                            <a href="{{ route('users.index') }}" class="nav-link">{{ __('Users') }}</a>
                        </div>
                        <div class="item">
                            <a href="{{ route('images.index') }}" class="nav-link">{{ __('Images') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    @yield('admin.content')
                </div>
            </div>
        </div>
    </div>
@endsection
