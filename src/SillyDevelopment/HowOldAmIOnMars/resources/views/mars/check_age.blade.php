@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Calculate Age</div>

                    @if (empty($myAgeOnMars) === false)
                        <div class="panel-body">
                            <p class="help-block">For birthday: <strong>{{ $myAgeOnMars['birthday'] }}</strong></p>
                            <p class="help-block">Age on Mars in days: <strong>{{ $myAgeOnMars['in_days'] }}</strong></p>
                            <p class="help-block">Age on Mars in years: <strong>{{ $myAgeOnMars['in_years'] }}</strong></p>
                        </div>
                    @endif

                    @if (empty($error) === false)
                        <div class="panel-body">
                            <p class="help-block">Error: <strong>{{ $error }}</strong></p>
                        </div>
                    @endif

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('/how-old-am-i-on-mars') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="birthday" class="col-md-4 control-label">Birthday</label>

                                <div class="col-md-6">
                                    <input id="birthday" type="date" class="form-control" name="birthday"
                                           value="{{ old('birthday') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Calculate!
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
