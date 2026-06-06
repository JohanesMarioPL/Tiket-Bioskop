<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="preconnect" href="('https://fonts.googleapis.com')">
  <link rel="preconnect" href="('https://fonts.gstatic.com')" crossorigin>
  <link href="('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap')"
    rel="stylesheet">

  <title>Chain App Dev - App Landing Page HTML5 Template</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <!--

TemplateMo 570 Chain App Dev

https://templatemo.com/tm-570-chain-app-dev

-->

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="{{ asset('https://use.fontawesome.com/releases/v5.8.1/css/all.css') }}"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('assets/css/templatemo-chain-app-dev.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/animated.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">

</head>
@yield('ExtraCSS')

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="{{ route('landing') }}" class="logo">
              <img src="{{ asset('assets/images/logo.png') }}" alt="Chain App Dev">
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              @auth
                <li>
                  <div class="gradient-button"><a href="{{ route('dashboard') }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></div>
                </li>
                <li>
                  <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                    @csrf
                  </form>
                  <div class="gradient-button"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out-alt"></i> Logout</a></div>
                </li>
              @else
                <li>
                  <div class="gradient-button"><a id="login_trigger" href="#modal"><i class="fa fa-sign-in-alt"></i> Login</a></div>
                </li>
                <li>
                  <div class="gradient-button"><a id="register_trigger" href="#modal"><i class="fa fa-user-plus"></i> Register</a></div>
                </li>
              @endauth
            </ul>
            <a class='menu-trigger'>
              <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <div id="modal" class="popupContainer" style="display:none;">
    <div class="popupHeader">
      
      <span class="header_title">Login</span>
      <span class="modal_close"><i class="fa fa-times"></i></span>
    </div>

    <section class="popupBody">
      <!-- Social Login -->
      <div class="social_login">
        <!-- <div class="">
          <a href="#" class="social_box fb">
            <span class="icon"><i class="fab fa-facebook"></i></span>
            <span class="icon_title">Connect with Facebook</span>

          </a>

          <a href="#" class="social_box google">
            <span class="icon"><i class="fab fa-google-plus"></i></span>
            <span class="icon_title">Connect with Google</span>
          </a>
        </div> -->
<!-- 
        <div class="centeredText">
          <span>Or use your Email address</span>
        </div> -->

        <div class="action_btns">
          <div class="one_half"><a href="#" id="login_form" class="btn">Login</a></div>
          <div class="one_half last"><a href="#" id="register_form" class="btn">Sign up</a></div>
        </div>
      </div>

      <!-- Username & Password Login form -->
      <div class="user_login">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
          @csrf
          <label>Email Address</label>
          <input type="email" name="email" value="{{ old('email') }}" required autofocus />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
          <br />

          <label>Password</label>
          <input type="password" name="password" required autocomplete="current-password" />
          <x-input-error :messages="$errors->get('password')" class="mt-2" />
          <br />

          <div class="checkbox">
            <input id="remember" type="checkbox" name="remember" />
            <label for="remember">Remember me on this computer</label>
          </div>

          <div class="action_btns">
            <div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a>
            </div>
            <div class="one_half last"><button type="submit" class="btn btn_red">Login</button></div>
          </div>
        </form>

        <a href="#" class="forgot_password">Forgot password?</a>
      </div>

      <!-- Register Form -->
      <div class="user_register">
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <label>Full Name</label>
          <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
          <x-input-error :messages="$errors->get('name')" class="mt-2" />
          <br />

          <label>Email Address</label>
          <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
          <br />

          <label>Password</label>
          <input type="password" name="password" required autocomplete="new-password" />
          <x-input-error :messages="$errors->get('password')" class="mt-2" />
          <br />

          <label>Confirm Password</label>
          <input type="password" name="password_confirmation" required autocomplete="new-password" />
          <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
          <br />

          <div class="checkbox">
            <input id="send_updates" type="checkbox" />
            <label for="send_updates">Send me occasional email updates</label>
          </div>

          <div class="action_btns">
            <div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a>
            </div>
            <div class="one_half last"><button type="submit" class="btn btn_red">Register</button></div>
          </div>
        </form>
      </div>
    </section>
  </div>

  <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                <div class="row">
                  <div class="col-lg-12">
                    <h2>Get The Latest App From App Stores</h2>
                    <p>Chain App Dev is an app landing page HTML5 template based on Bootstrap v5.1.3 CSS layout provided
                      by TemplateMo, a great website to download free CSS templates.</p>
                  </div>
                  <div class="col-lg-12">
                    <div class="white-button first-button scroll-to-section">
                      <a href="#contact">Free Quote <i class="fab fa-apple"></i></a>
                    </div>
                    <div class="white-button scroll-to-section">
                      <a href="#contact">Free Quote <i class="fab fa-google-play"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                <img src="{{ asset('assets/images/slider-dec.png') }}" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  @include('layouts.footer')

  <!-- Scripts -->  
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/owl-carousel.js') }}"></script>
  <script src="{{ asset('assets/js/animation.js') }}"></script>
  <script src="{{ asset('assets/js/imagesloaded.js') }}"></script>
  <script src="{{ asset('assets/js/popup.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  <script>
    $(document).ready(function() {
      @if(request()->is('register'))
        $("#register_trigger").click();
      @elseif(request()->is('login'))
        $("#login_trigger").click();
      @endif
    });
  </script>

  @yield('ExtraJS')
</body>

</html>