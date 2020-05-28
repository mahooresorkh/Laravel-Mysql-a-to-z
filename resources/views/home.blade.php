@extends('layouts.app')

@section('content')



        <div id="fetch_is_completed" style="display:none">false</div>
        <div id="top_bar">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                خروج&nbsp;&nbsp;&nbsp;<img src="{{ asset('images/logout.svg') }}" alt="">
            </a>
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="logo">
                <span style="color:gold">A-to-Z</span>
            </div>
            <h4>
            </h4>
            <img id="date_time_logo" src="{{ asset('images/date_time.png') }}" alt="datetime logo">
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <div id="root">
        </div>
            
  
@endsection
