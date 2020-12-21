@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-header">{{ __('Transactions') }}</div>
                        <table>
                            <tr>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Created At</th>
                            </tr>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{$transaction->type}}</td>
                                    <td>{{$transaction->amount}}</td>
                                    <td>{{$transaction->created_at}}</td>
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


