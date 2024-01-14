<div class="container">
  <nav class="navbar navbar-expand-lg navbar-light px-0">
        <a class="navbar-brand order-1 py-0" href="{{ route('/') }}">
          <img loading="prelaod" decoding="async" class="img-fluid" src="{{ asset('frontend/images/logo.png') }}" alt="Reporter Hugo">
        </a>
        <div class="navbar-actions order-3 ml-0 ml-md-4">
          <button aria-label="navbar toggler" class="navbar-toggler border-0" type="button" data-toggle="collapse"
            data-target="#navigation"> <span class="navbar-toggler-icon"></span>
          </button>
        </div>
        <form action="#!" class="search order-lg-3 order-md-2 order-3 ml-auto">
          <input id="search-query" name="s" type="search" placeholder="Search..." autocomplete="off">
        </form>

        

<style>.content {
  padding: 7rem 0; }

h2 {
  font-size: 20px; }

.custom-dropdown a span {
  display: inline-block;
  position: relative;
  -webkit-transition: .3s transform ease;
  -o-transition: .3s transform ease;
  transition: .3s transform ease; }

.custom-dropdown.show a {
  color: #000; }
  .custom-dropdown.show a span {
    -webkit-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg); }

.custom-dropdown .btn:active, .custom-dropdown .btn:focus {
  -webkit-box-shadow: none !important;
  box-shadow: none !important;
  outline: none; }

.custom-dropdown .btn.btn-custom {
  border: 1px solid #efefef; }

.custom-dropdown .title-wrap {
  padding-top: 10px;
  padding-bottom: 10px; }

.custom-dropdown .title {
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase; }

.custom-dropdown .dropdown-link {
  color: #888;
  display: inline-block;
  padding-right: 0px;
  position: relative; }
  .custom-dropdown .dropdown-link .wrap-icon {
    font-size: 30px; }
  .custom-dropdown .dropdown-link .number {
    width: 24px;
    height: 24px;
    line-height: 20px;
    border-radius: 50%;
    background: #007bff;
    position: absolute;
    font-size: 13px;
    top: -10px;
    right: -10px;
    border: 2px solid #fff;
    color: #fff;
    text-align: center; }



    .custom-dropdown .dropdown-item {
  font-size: 14px;
  color: #888;
  border-bottom: 1px solid #efefef;
  padding-top: 10px;
  padding-left: 15px;
  padding-bottom: 10px;
  position: relative; }
  .custom-dropdown .dropdown-item:before {
    content: "";
    position: absolute;
    width: 0px;
    height: 100%;
    left: 0;
    bottom: 0;
    top: 0;
    opacity: 0;
    visibility: hidden;
    z-index: 2;
    background: #007bff;
    -webkit-transition: .3s all ease;
    -o-transition: .3s all ease;
    transition: .3s all ease; }
  .custom-dropdown .dropdown-item:last-child {
    border-bottom: none; }
  .custom-dropdown .dropdown-item:hover {
    color: #000;
    padding-left: 20px; }
    .custom-dropdown .dropdown-item:hover:before {
      opacity: 1;
      visibility: visible;
      width: 6px; }

.custom-dropdown .dropdown-menu {
  border: 1px solid transparent;
  -webkit-box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.2);
  box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.2);
  margin-top: 0px !important;
  padding-top: 0;
  padding-bottom: 0;
  padding: 10px;
  opacity: 0;
  top: 100% !important;
  left: 50% !important;
  -webkit-transform: translate(-50%, 0) !important;
  -ms-transform: translate(-50%, 0) !important;
  transform: translate(-50%, 0) !important;
  right: auto !important;
  -webkit-transition: .3s margin-top ease, .3s opacity ease, .3s visibility ease;
  -o-transition: .3s margin-top ease, .3s opacity ease, .3s visibility ease;
  transition: .3s margin-top ease, .3s opacity ease, .3s visibility ease;
  visibility: hidden;
  min-width: 680px; }
  .custom-dropdown .dropdown-menu.active {
    opacity: 1;
    visibility: visible;
    margin-top: 10px !important; }
  .custom-dropdown .dropdown-menu .mega-menu {
    padding: 20px; }
    .custom-dropdown .dropdown-menu .mega-menu a {
      display: block;
      padding-top: 5px;
      padding-bottom: 5px;
      text-decoration: none;
      color: #000;
      font-weight: 400; }
      .custom-dropdown .dropdown-menu .mega-menu a:hover {
        color: #e83e8c; }
    .custom-dropdown .dropdown-menu .mega-menu > div {
      width: 33.3333%;
      padding-left: 10px;
      padding-right: 10px; }
      .custom-dropdown .dropdown-menu .mega-menu > div ul {
        margin: 0;
        padding: 0; }</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <div class="collapse navbar-collapse text-center order-lg-2 order-4" id="navigation">
          <ul class="navbar-nav mx-auto mt-lg-0">


          @foreach($navigations as $navigation)
            <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{$navigation ->name}}
              </a>
              <div class="dropdown custom-dropdown">
       

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              
              <div class="mega-menu d-flex">
                <div>
                  <a href="#" class="d-block mb-1"><img src="images/hero_1.jpg" alt="Image" class="img-fluid mb-3"></a>
                  <p><a href="#">PSD Mockups</a><span class="text-muted">View All Here</span></p>
                </div>
                <div>
                  <ul class="list-unstyled">
                  @foreach ($navigation->categories as $category)
                      @if ($loop->index % 2 == 0)
                          <a href="#" class="dropdown-item"><i class="{{ $category->cat_icon }}"></i> {{ $category->name }}  </a>
                      @endif
                  @endforeach
                  </ul>
                </div>
                <div>
                <ul class="list-unstyled">
                @foreach ($navigation->categories as $category)
                    @if ($loop->index % 2 != 0)
                        <a href="#" class="dropdown-item"><i class="{{ $category->cat_icon }}"></i> {{ $category->name }} </a>
                    @endif
                @endforeach
                </ul>
                </div>
              </div>
            </div>
          </div>
            </li>
        @endforeach


          </ul>
        </div>
      </nav>
    </div>