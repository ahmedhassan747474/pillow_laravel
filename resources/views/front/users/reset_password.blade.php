<html>
    <body>
        <form method="POST" action="{{ route('change-password') }}">
            @csrf

            {!! $errors->first('msg', '<div class="form-text  text-main error" id="email_error">:message</div>') !!}

            <input type="hidden" name="email" value="{{$email}}"/>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}"   autofocus>
                    {!! $errors->first('password', '<div class="form-text  text-main error" id="email_error">:message</div>') !!}
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">Confirm password</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="confirm_password" value="{{ old('confirm_password') }}"   >
                    {!! $errors->first('confirm_password', '<div class="form-text  text-main error" id="email_error">:message</div>') !!}
                </div>
            </div>

            <div class="form-group row ">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Reset password
                    </button>
                </div>
            </div>
        </form>
    </body>
</html>