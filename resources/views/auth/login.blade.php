@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">

                        <!-- Facebook -->
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <a href="{{ route('auth/facebook') }}" class="btn btn-facebook">Login to Facebook</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
