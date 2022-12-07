

@extends('front.index')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                   <div ><h1> Web Area  </h1></div>

                </div>

                 Profile
                 <form class="form-group"  action="{{route('user-submit-update-profile')}}" method="POST"  >
                    {{ csrf_field() }} @method('put')

                    {!! $errors->first('msg', '<div class="form-text  text-main error" >:message</div>') !!}
                    <div class="form-input">
                        <input class="form-control" placeholder="Name" name="name" id="email" value="{{$user->name}}">
                    </div>                    
                    {!! $errors->first('msg', '<div class="form-text  text-main error" >:message</div>') !!}
                    <div class="form-input">
                        <input class="form-control" placeholder="Email" name="email" id="email" value="{{$user->email}}">
                    </div>
                    {!! $errors->first('email', '<div class="form-text  text-main error" >:message</div>') !!}
                    <div class="form-input">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    {!! $errors->first('password', '<div class="form-text  text-main error" >:message</div>') !!}

                    <div class="mt-30 text-center">
                        <button class="red-btn w-75 p-3 br20">Update</button>
                    </div>

                </form>

                </div>

                <br>
                <br>

            </div>
        </div>
    </div>
</div>
@endsection