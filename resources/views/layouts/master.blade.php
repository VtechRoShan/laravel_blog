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
<main>
  <section class="section">
    <div class="container">
      <div class="row no-gutters-lg">
        <div class="col-12">
          <h2 class="section-title">Latest Articles</h2>
        </div>
        @yield('content')
      </div>
    </div>
  </section>
</main>

@include('layouts.script')
</body>
</html>
