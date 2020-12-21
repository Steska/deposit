@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header">{{ __('Deposits') }}</div>
                        <table>
                            <tr>
                                <th>Amount</th>
                                <th>Percent</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>
                            @foreach($deposits as $deposit)
                                <tr>
                                    <td>{{$deposit->invested}}</td>
                                    <td>{{$deposit->percent}}</td>
                                    <td>@if ($deposit->active == 1) Active @else Close @endif</td>
                                    <td>{{$deposit->created_at}}</td>
                                </tr>
                            @endforeach
                        </table>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


