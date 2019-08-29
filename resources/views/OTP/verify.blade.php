@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Enter OTP</div>
                    @if($errors->count() > 0)
                        <div class="alert alert-danger">
                     @foreach($errors->all() as $error)
                         {{$error}}
                     @endforeach
                        </div>
                     @endif
                    <div class="card-body">
                    <form action="{{route('OTP.page')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="otp">Your OTP</label>
                            <input type="text" name="OTP" id="otp" class="form-control">

                        </div>
                        <input type="submit" value="verify" class="btn btn-info ">

                        <div class="container m-sm-4">
                            <input type="submit" class="btn btn-sm btn-dark" value="Resent OTP via">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="via" id="sms" value="sms">
                        <label class="form-check-label" for="inlineRadio1">SMS</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="via" id="email" value="email" checked>
                        <label class="form-check-label" for="email">EMAIL</label>
                    </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

