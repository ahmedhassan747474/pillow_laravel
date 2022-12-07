


@extends('front.index')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                   <div ><h1> Admin Area  </h1></div>

                </div>

                 Login
                 <form class="form-group"  action="{{route('admin.admin-check-login')}}" method="POST"  >
                    {{ csrf_field() }}

                    {!! $errors->first('msg', '<div class="form-text  text-main error" >:message</div>') !!}
                    <div class="form-input">
                        <input class="form-control"   placeholder="Email" name="email" id="email">
                    </div>
                    {!! $errors->first('email', '<div class="form-text  text-main error" >:message</div>') !!}
                    <div class="form-input">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    </div>
                    {!! $errors->first('password', '<div class="form-text  text-main error" >:message</div>') !!}
                    <div class="d-flex mt-20 justify-content-between align-items-center">
                         <div class="form-check ">
                            <input class="form-check-input text-main" type="checkbox" name="remember_me" value="true" >
                            <label class="form-check-label font-18 text-main" >
                                Remember me
                            </label>
                        </div>

                    </div>
                    <div class="mt-30 text-center">
                        <button class="red-btn w-75 p-3 br20">Login</button>
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



