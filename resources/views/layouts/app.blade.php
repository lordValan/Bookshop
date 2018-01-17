<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bookshop: @yield('title')</title>

    <!-- Icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('/images/icon/favicon-16x16.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('fonts/themify-icons/themify-icons.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::asset('/css/reset.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/css/basic.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/css/slick.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/css/fontawesome-stars-o.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/css/media.css') }}">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ URL::asset('js/jquery.barrating.min.js') }}" charset="utf-8"></script>
    <script src="{{ URL::asset('js/slick.min.js') }}" charset="utf-8"></script>
    <script src="{{ URL::asset('js/main.js') }}" charset="utf-8"></script>
    <script src="{{ URL::asset('js/prefixfree.min.js') }}" charset="utf-8"></script>
</head>
<body>
@include('layouts.preloader')
<header class="header main-header">
    <div class="header-logo-block flexible vert-flex-center rewidth">
        <a href="{{route('home')}}"><img src="{{ URL::asset('/images/header/logo.png') }}" alt="logo" class="header-logo"></a>
        <div class="header-block-search-btns flexible vert-flex-center">            
            <form class="header-form-search" method="GET" action="{{action('BookController@findAllBooks')}}">
                <button type="button" class="header-btn header-form-search-close-btn"><i class="ti-close"></i></button>
                <div class="form-search-container flexible">
                    <input type="text" autocomplete="off" name="query" placeholder="Search over 1 million book titles" class="header-input-search">
                    <div class="search-result-container"></div>
                    <input type="submit" style="display: none;">
                </div>
            </form>
            <button type="button" class="header-btn header-menu-btn"><i class="ti-menu"></i></button>
            <div class="header-btns header-btns-logo flexible">                
                @if(isset($user))
                    <a href="{{route('cart')}}"><button type="button" class="header-btn header-login-btn"><i class="ti-shopping-cart"></i>
                            <span class="items_amount flexible" style="{{count($user->cart_items) == 0 ? 'display: none;' : ''}}">{{count($user->cart_items)}}</span></button></a>
                    <div class="bt-user-container">
                        <button type="button" class="header-btn header-basket-btn" onclick="hideShowUserMenu();" style="background-image: url('{{ File::exists(public_path() . '/images/users/user' . $user->id . '.jpg') ? URL::asset('/images/users/user' . $user->id . '.jpg') : URL::asset('/images/other/unknown.png') }}');">&nbsp;</button>
                        <div class="user-menu">
                            <a href="{{route('useredit')}}">Edit</a>
                            <a href="{{route('logout')}}">Log out</a>
                        </div>
                    </div>
                @else
                    <button type="button" class="header-btn header-login-btn" onclick="showModalAuth();"><i class="ti-shopping-cart"></i></button>
                    <button type="button" class="header-btn header-basket-btn" onclick="showModalAuth();"><i class="ti-user"></i></button>
                @endif
            </div>
        </div>
    </div>
    <div class="header-menu-block flexible">
        <div class="header-menu flexible">
            <div class="header-btns header-btns-menu flexible">
                <button type="button" class="header-btn header-search-btn"><i class="ti-search"></i></button>
                @if(isset($user))
                    <a href="{{route('cart')}}"><button type="button" class="header-btn header-login-btn"><i class="ti-shopping-cart"></i>
                            <span class="items_amount flexible" style="{{count($user->cart_items) == 0 ? 'display: none;' : ''}}">{{count($user->cart_items)}}</span></button></a>
                    <div class="bt-user-container">
                        <button type="button" class="header-btn header-basket-btn" onclick="hideShowUserMenu();" style="background-image: url('{{ URL::asset('/images/users/user') . $user->id . '.jpg' }}');">&nbsp;</button>
                        <div class="user-menu">
                            <a href="{{route('useredit')}}">Edit</a>
                            <a href="{{route('logout')}}">Log out</a>
                        </div>
                    </div>
                @else
                <button type="button" class="header-btn header-login-btn" onclick="showModalAuth();"><i class="ti-shopping-cart"></i></button>
                <button type="button" class="header-btn header-basket-btn" onclick="showModalAuth();"><i class="ti-user"></i></button>
                @endif
            </div>
            <div class="main-menu-items flexible">
                <a href="{{Route('home')}}">Home</a>
                <a href="{{Route('allbooks')}}">Books</a>
                <a href="{{Route('allauthors')}}">Authors</a>
                <a href="{{Route('recomendedbooks')}}">Recommended</a>
                <a href="{{Route('salebooks')}}">Sale</a>
            </div>
        </div>
    </div>
</header>
@if(is_null($user))
<div class="modal-auth">
    <div class="modal-window registration-window">
        <button class="modal-close"><i class="ti-close"></i></button>
        <h2 class="modal-head">Join Bookshop.</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab cumque, voluptates. Dolorum est, ipsum iste iure quas soluta vero voluptate.</p>
        <div class="auth-buttons flexible">
            <a href=""><button class="auth-button auth-google">Sign Up with Google</button></a>
            <a href=""><button class="auth-button auth-facebook">Sign Up with Facebook</button></a>
            <a href=""><button class="auth-button auth-twitter">Sign Up with Twitter</button></a>
            <a href="/register"><button class="auth-button auth-email">Sign Up with email</button></a>
        </div>
        <p>Already have an account? <button class="sign-btn sign-in-btn">Sign in.</button></p>
        <p class="terms-link"><a href="#">Terms of Service</a></p>
    </div>
    <div class="modal-window login-window">
        <button class="modal-close"><i class="ti-close"></i></button>
        <h2 class="modal-head">Welcome back!</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab cumque, voluptates. Dolorum est, ipsum iste iure quas soluta vero voluptate.</p>
        <div class="auth-buttons flexible">
            <a href=""><button class="auth-button auth-google">Sign In with Google</button></a>
            <a href=""><button class="auth-button auth-facebook">Sign In with Facebook</button></a>
            <a href=""><button class="auth-button auth-twitter">Sign In with Twitter</button></a>
            <a href="/login"><button class="auth-button auth-email">Sign In with email</button></a>
        </div>
        <p>Are you new to Bookshop? <button class="sign-btn sign-up-btn">Sign up.</button></p>
        <p class="terms-link"><a href="#">Terms of Service</a></p>
    </div>
</div>
@endif
@yield('content')
<footer class="footer">
    <div class="footer-info-block">
        <div class="rewidth flexible">
            <div class="footer-block footer-about-block">
                <div class="footer-block-head flexible"><img src="{{ URL::asset('/images/header/logo-footer.png') }}" alt="logo-header" class="footer-logo"></div>
                <div class="footer-block-content"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit laboriosam aut quis atque alias.</p></div>
            </div>
            <div class="footer-block footer-about-block">
                <div class="footer-block-head flexible"><i class="ti ti-direction"></i><h3>Our main office</h3></div>
                <div class="footer-block-content"><p>San Francisco, California, US <br>P.O. BOX: 553204 <br>Phone: (+1) 998 3384 <br>Mail: <a href="mailto:admin@bookshop.com" class="mail-link">admin@bookshop.com</a></p></div>
            </div>
            <div class="footer-block footer-about-block flexible">
                <div class="footer-block-head flexible"><i class="ti ti-link"></i><h3>keep in touch</h3></div>
                <div class="footer-block-content footer-block-social flexible">
                    <div class="social-link flexible vert-flex-center">
                        <i class="ti ti-facebook"></i>
                        <a href="#">Facebook</a>
                    </div>
                    <div class="social-link flexible vert-flex-center">
                        <i class="ti ti-twitter"></i>
                        <a href="#">Twitter</a>
                    </div>
                    <div class="social-link flexible vert-flex-center">
                        <i class="ti ti-google"></i>
                        <a href="#">Google Plus</a>
                    </div>
                </div>
            </div>
            <div class="footer-block footer-about-block">
                <div class="footer-block-head flexible"><i class="ti ti-info-alt"></i><h3>Information</h3></div>
                <div class="footer-block-content block-inform flexible">
                    <div class="info-links-column flexible">
                        <a href="">About Us</a>
                        <a href="">Contact Us</a>
                        <a href="">FAQ</a>
                    </div>
                    <div class="info-links-column flexible">
                        <a href="">Terms And Conditions</a>
                        <a href="">My Account</a>
                        <a href="">Blog</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright-block">
        <p>{{date('Y')}}, <a href="http://fomindanil.com/">Danil Fomin</a></p>
    </div>
</footer>
</body>
</html>