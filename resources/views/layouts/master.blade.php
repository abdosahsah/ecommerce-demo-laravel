<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{-- Meta CSRF --}}
  @yield('meta-csrf')
  {{-- Bootswatch --}}
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  {{-- Font awsome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  {{-- Extra script --}}
  @yield('extra_script')
  <title>Shop</title>
</head>
<body>

  <div class="container">
    <div class="row">
      <div class="col-md-12">
  
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
          <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('store.index') }}">Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarColor01">
              <ul class="navbar-nav me-auto">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('store.index') }}">Home
                    <span class="visually-hidden">(current)</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">About</a>
                </li>
              </ul>
              <form class="d-flex">
                <a href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart fa-2x me-sm-2 text-white" style="color: black"></i></a>
                <b class="my-2 my-sm-0 text-white">{{ Cart::count() }}</b>
              </form>
            </div>
          </div>
        </nav>
  
      </div>
    </div>
  </div>

  {{-- Slider --}}
  <div class="container">
    <div class="row justify-content-center mt-2">
      <div class="col-md-8">
  
        @yield('slider')
  
      </div>
    </div>
  </div>

  {{-- Main section content --}}
  <div class="container">
    <div class="row justify-content-center mt-2">
    <div class="col-md-8">

      @yield('content')

    </div>
  </div>
  </div>

  {{-- Extra js code --}}
  @yield('extra_js_code')

  {{-- Bootstrap js cdn --}}
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.min.js" integrity="sha384-PsUw7Xwds7x08Ew3exXhqzbhuEYmA2xnwc8BuD6SEr+UmEHlX8/MCltYEodzWA4u" crossorigin="anonymous"></script>

</body>
</html>