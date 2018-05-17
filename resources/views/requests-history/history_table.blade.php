@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr class="tableheader">
                <th style="text-align: center; vertical-align: middle;">Id</th>
                <th style="text-align: center; vertical-align: middle;">Birthday</th>
                <th style="text-align: center; vertical-align: middle;">When</th>
            </tr>
            </thead>
            <tbody>
            @foreach($requestsHistory as $item)
                <tr>
                    <td style="text-align: left;">{{$item->id}}</td>
                    <td style="text-align: left;">{{$item->birthday}}</td>
                    <td style="text-align: left;">{{$item->created_at}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
