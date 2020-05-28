@extends('layouts.app')

@section('content')


<div class="card text-white bg-primary mb-3 login_box" style="max-width: 20rem;">
    <div class="card-header">تغییر رمز عبور<img class="login_images" src="/images/refresh.png" alt="lock sign"></div>
    <div class="card-body"> 
        <form method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">
        
            <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                <label for="exampleInputEmail1"> پست الکترونیکی </label>
                <input type="email" class="form-control register_textbox {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $email or old('email') }}" name="email" required autofocus>
                @if ($errors->has('email'))
                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                @endif
            </div>
            
            <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                <label for="password"> رمز عبور جدید </label>
                <input type="password" class="form-control register_textbox {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                @endif
            </div>
        
            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                <label for="password-confirm"> تکرار رمز عبور  </label>
                <input type="password" class="form-control register_textbox {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" required>
                @if ($errors->has('password_confirmation'))
                    <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>
        
            <button type="submit" class="btn btn-secondary" name="submit">تغییر رمز عبور</button>
        </form>  
    </div>
</div>

@endsection
