@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col"> intimstory</th>
            <th scope="col">rus-massage.. </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row"></th>
            <td><a href="{{route('export')}}">Export Massages</a><br>
                <a href="{{route('filter')}}">Export Ind...</a>
            </td>
            <td><a href="{{route('rus')}}">Export Rus Massage...</a> </td>
        </tr>
        </tbody>
    </table>
@endsection

