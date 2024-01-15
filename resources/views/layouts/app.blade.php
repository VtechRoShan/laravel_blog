
<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<title>Reporter - HTML Blog Template</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<meta name="description" content="This is meta description">
	<meta name="author" content="Themefisher">
	<link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">
	<link rel="icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- theme meta -->
  <meta name="theme-name" content="reporter" />
  @include('layouts.style')
</head>

<body>

<header class="navigation mb-0">
    @include('layouts.nav')
</header>

<main>
  <section class="section mt-0">
    <div class="container my-0">
      <div class="row m-0 no-gutters-lg">
        @yield('section_bar')
        @yield('content')
      </div>
    </div>
  </section>
</main>

@include('layouts.footer')
@include('layouts.script')
</body>
</html>
