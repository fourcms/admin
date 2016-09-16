@extends('admin.layouts.app')

@section('content')

    <div class="container container-error">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h2>
                    Oops!
                </h2>
                <h3>
                    404 Not Found
                </h3>
                <div class="error-details">
                    Sorry, an error has occured, Requested page not found!
                </div>
                <div class="error-actions">
                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                        <i class="fa fa-home"></i>
                        Take Me Home
                    </a>
                    <a href="{{ url('/contact') }}" class="btn btn-default btn-lg">
                        <i class="fa fa-envelope"></i> Contact Support
                    </a>
                </div>
            </div>

        </div>
    </div>


@endsection
