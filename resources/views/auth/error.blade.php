@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Error</div>

                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <p>{{ $error }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
