@extends('front.index')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div ><h1> Web Area  </h1></div>

                </div>
                @if(Auth::user())
                    Welcome {{Auth::user()->email}}
                    <ul>
                        <li>
                            <a href="{{url('profile')}}">Profile </a>
                        </li>
                        <li>
                            <a href="{{url('logout')}}">Logout </a>
                        </li>
                    </ul>
                @else
                    <a href="{{url('login')}}">Login </a>
                @endif
                </div>

                <br>
                <br>

            </div>
        </div>
    </div>
</div>
@endsection


