@extends('layouts.app')

@section('content')

    @if (session('status'))
        <br><br>
        <div style="text-align: center; margin:0px auto; max-width:400px;">
            <h1 style="text-align: center !important; color:pink;">{{ session('status') }}</h1>
        </div>
    
    @else
        <div class="card text-white bg-primary mb-3 login_box" style="max-width: 20rem;">
        <div class="card-header">بازیابی رمز عبور<img class="login_images" src="/images/refresh.png" alt="lock sign"></div>
        <div class="card-body"> 
            <form method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                    <label for="exampleInputEmail1"> پست الکترونیکی </label>
                    <input type="email" class="form-control register_textbox {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-secondary" name="submit">فرستادن لینک </button>
            </form>  
        </div>
        </div>
    @endif
   
@endsection

