@extends('layouts.empty')

@section('content')
<main class="auth-container">
    <div>
        <div>
            <div class="panel flexible">
                <div class="panel-heading">
                    <h3>Sign in with email</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus asperiores debitis doloremque iusto laudantium obcaecati officiis, quasi repellendus veritatis voluptatem!</p>
                </div>
                <div class="panel-body">
                    <form class="auth-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">E-Mail Address</label>
                            <div>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>

                            <div>
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit">Login</button>

                                <a href="{{ route('password.request') }}">
                                    <button type="button">Forgot Your Password?</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="after-form">
        <img src="{{ URL::asset('images/auth_form/draw-book.jpg') }}">
    </div>
</main>
@endsection
