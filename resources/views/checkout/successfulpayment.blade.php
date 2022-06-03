@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <i class="far fa-check-circle fa-3x text-success"></i>
            <p class="text-success my-3">Your payment has been proccessed successfully!</p>
            <a href="{{ route('store.index') }}"><button class="btn btn-dark my-2">Back to store</button></a>
        </div>
    </div>
</div>
@endsection