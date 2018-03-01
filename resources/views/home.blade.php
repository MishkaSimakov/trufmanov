@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                  <table class="table">
                    <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Значение</th>
                      <th scope="col">Название</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($measurements as $key => $measurement)
                    <tr>
                      <th scope="row">{{ $key + 1 }}</th>
                      <td>{{ $measurement['value'] }} {{ $measurement['unit'] }}</td>
                      <td>{{ $measurement['name'] }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
