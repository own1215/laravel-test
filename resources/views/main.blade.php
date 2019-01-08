@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Images') }}</div>

                <div class="card-body">
                    <front-img-list
                        :images="{{ json_encode($images) }}"
                    ></front-img-list>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
