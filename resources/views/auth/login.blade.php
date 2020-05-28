@extends('layouts.app')

@section('content')
                

<div class="card text-white bg-primary mb-3 login_box" style="max-width: 20rem;">
    <div class="card-header">فرم ورود کاربران <img class="login_images" src="/images/key.svg" alt="lock sign"></div>
    <div class="card-body"> 
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group {{ $errors->has('username') ? ' has-danger' : '' }}">
                <label for="exampleInputEmail1">نام کاربری</label>
                <input type="text" class="form-control login_textbox {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
                @if ($errors->has('username'))
                <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                @endif
            </div>

            <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                <label for="exampleInputPassword1">رمز عبور</label>
                <input type="password" class="form-control login_textbox {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}">
                @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="d-flex">
                <div class="mr-auto">
                    <a href="{{ route('password.request') }}" style="font-size:small">رمز عبور را فراموش کرده اید؟</a>
                </div>
                <div>
                    <a href="{{ route('register') }}">
                        <button type="button" class="btn btn-info" name="register">ثبت نام</button>
                    </a>
                    <button type="submit" class="btn btn-secondary" name="submit">ورود</button>
                </div>
            </div>

        </form>  
    </div>
</div>

@endsection
