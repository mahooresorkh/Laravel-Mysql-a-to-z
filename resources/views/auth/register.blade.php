@extends('layouts.app')

@section('content')
                    
    <div class="card text-white bg-primary mb-3 register_box" style="max-width: 30rem;">
        <div class="card-header">فرم ثبت نام کاربران <img class="register_images" src="/images/person-fill.svg" alt="lock sign"></div>
        <div class="card-body"> 
            <form method="POST" action="{{ route('register') }}" enctype='multipart/form-data'>
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-sm-6 register_box_order1 {{ $errors->has('first_name') ? ' has-danger' : '' }}">
                        <label for="exampleInputEmail1">نام </label>
                        <input type="text" class="form-control register_textbox_name {{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>
                        @if ($errors->has('first_name'))
                            <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-sm-6 register_box_order2 {{ $errors->has('last_name') ? ' has-danger' : '' }}">
                        <label for="exampleInputEmail1"> نام خانوادگی </label>
                        <input type="text" class="form-control register_textbox_name {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
                        @if ($errors->has('last_name'))
                            <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                        @endif
                    </div>

                </div>

                <hr class="register_box_hr">

                <div class="form-row">
                    <div class="form-group col-sm-6 register_box_order1 {{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="exampleInputEmail1"> پست الکترونیکی </label>
                        <input type="email" class="form-control register_textbox {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-sm-6 register_box_order2 {{ $errors->has('username') ? ' has-danger' : '' }}">
                        <label for="exampleInputEmail1">نام کاربری </label>
                        <input type="text" class="form-control register_textbox {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>
                        @if ($errors->has('username'))
                            <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                        @endif
                    </div>

                </div>

                <hr class="register_box_hr">

                <div class="form-row">
                    <div class="form-group col-sm-6 register_box_order1 {{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="exampleInputPassword1">رمز عبور</label>
                        <input type="password" class="form-control register_textbox {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-sm-6 register_box_order2">
                        <label for="password-confirm">تکرار رمز عبور</label>
                        <input type="password" id="password-confirm" class="form-control register_textbox" name="password_confirmation" required>
                    </div>
                </div>   

                <hr class="register_box_hr">

                <div class="form-group">
                    <label for="exampleFormControlFile1">انتخاب تصویر پروفایل</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="profile_image">
                    @if ($errors->has('profile_image'))
                        <div class="invalid-feedback">{{ $errors->first('profile_image') }}</div>
                    @endif
                </div>

                <hr class="register_box_hr">

                <button type="submit" class="btn btn-secondary" name="submit">ثبت نام</button>
            </form>  
        </div>
    </div>

@endsection
