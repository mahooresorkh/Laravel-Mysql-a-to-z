@extends('layouts.app')

@section('content')

<div class="card text-white bg-primary mb-3 register_box" style="max-width: 30rem;">
    <div class="card-header"> ویرایش اطلاعات<img class="register_images" src="/images/edit.svg" alt="edit sign"></div>
    <div class="card-body"> 
        <form action="/updateprofile" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-sm-6 register_box_order1">
                    <label for="exampleInputEmail1">نام </label>
                    <input type="text" class="form-control register_textbox_name" name="first_name" value="{{$user->first_name}}">
                </div>
                <div class="form-group col-sm-6 register_box_order2">
                    <label for="exampleInputEmail1"> نام خانوادگی </label>
                    <input type="text" class="form-control register_textbox_name" name="last_name" value="{{$user->last_name}}">
                </div>
            </div>
            <hr class="register_box_hr">

            <div class="form-group">
                <div class="d-flex justify-content-center">
                    <label for="exampleInputEmail1">نام کاربری </label>
                </div>

                <div class="d-flex justify-content-center">
                    <input type="text" class="form-control register_textbox" name="username" style="width: 250px;" value="{{$user->username}}">
                </div>

            </div>
           
            <hr class="register_box_hr">
            <div class="form-row">
                <div class="form-group col-sm-6 register_box_order1">
                    <label for="exampleInputPassword1">رمز عبور</label>
                    <input type="password" class="form-control register_textbox" name="password">
                </div>
                <div class="form-group col-sm-6 register_box_order2">
                    <label for="exampleInputPassword1">تکرار رمز عبور</label>
                    <input type="password" class="form-control register_textbox" name="password2">
                </div>
            </div>   
            <hr class="register_box_hr"> 
            <div class="form-group">
                <label for="exampleFormControlFile1">انتخاب تصویر پروفایل</label>
                <input type="file" class="form-control-file" id="upload_profile_image" name="profile_image">
            </div>
            <hr class="register_box_hr">

            <div class="form-group">
                
                <label class="radio-inline">
                    <label for="disable_image_upload">پروفایل تصویری نداشته باشد</label>
                    <input type="checkbox" name="no_image" value="1" id="disable_image_upload">
                </label>               
            </div>
            <hr class="register_box_hr">
            <button type="submit" class="btn btn-secondary" name="submit">ثبت ویرایش</button>
            @if(count($errors)>0)
                <br><br>
                @foreach($errors->all() as $error)
                    <p class="text-warning">
                        {{$error}}
                    </p>
                @endforeach 
            @endif
            @if(session('error'))
                <p class="text-warning">
                    {{session('error')}}
                </p>
            @endif
        </form>  
    </div>
</div>


@endsection