@extends('layouts.empty')

@section('content')
    <main class="auth-container">
        <div>
            <div>
                <div class="panel flexible">
                    <div class="panel-heading">
                        <h3>Reset password</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus asperiores debitis doloremque iusto laudantium obcaecati officiis, quasi repellendus veritatis voluptatem!</p>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">E-Mail Address</label>

                                <div>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        Send Password Reset Link
                                    </button>
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
