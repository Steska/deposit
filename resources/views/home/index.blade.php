@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            You balance {{$balance}}
            <div>
            <a href="/wallet/balance">{{__('Add Balance')}}</a>
                <a href="/deposit">{{__('Add Deposit')}}</a>
            </div>
        </div>
    </div>
</div>
@endsection
