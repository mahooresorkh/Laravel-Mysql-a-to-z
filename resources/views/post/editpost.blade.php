@extends('layouts.app')

@section('content')


<div class="card text-white bg-primary mb-3 create_post_box" style="max-width: 30rem;">
    <div class="card-header"><span style="font-size: 20px;">ویرایش پست</span></div>
    
        <div class="card-body">
            <form action="/update/{{$post->id}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="form-group create_post_items">
                <label><strong> عنوان پست</strong></label>
                <input type="text" class="form-control" name="title" value="{{$post->title}}">
            </div>
            <div class="form-group create_post_items">
                <label><strong>متن پست</strong></label>
                <textarea class="form-control" rows="7" name="content">{{$post->content}}</textarea>
            </div>
            <hr>
            <div class="form-group">
                <label for="upload_post_image">انتخاب تصویر پست</label>
                <input type="file" class="form-control-file" id="upload_post_image" name="post_image">
            </div>
            <hr>

            <div class="form-group">
                <label class="radio-inline">
                    <label for="disable_image_upload">پست تصویری نداشته باشد</label>
                    <input type="checkbox" name="no_image" value="1" id="disable_image_upload">
                </label>               
            </div>

            
            <div class="form-group">
                <label class="radio-inline">
                    <input type="radio" name="is_public" value="0">انتشار برای دوستان
                </label>
                &nbsp;&nbsp;&nbsp;
                <label class="radio-inline">
                    <input type="radio" name="is_public" checked value="1">انتشار عمومی
                </label>                      
            </div>


            <button class="btn btn-secondary" type="submit" style="width: 60px" name="submit">
                انتشار
            </button>
            @if(count($errors)>0)
                <br><br>
                @foreach($errors->all() as $error)
                    <p class="text-warning">
                        {{$error}}
                    </p>
                @endforeach 
            @endif
        </form>
        </div>
        
    
</div>
            
  
@endsection