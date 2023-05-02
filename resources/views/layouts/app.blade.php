@props(['content', 'css' => '', 'javascript' => ''])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <base href="./">

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="description" content="Shibaza Framework">
  <meta name="author" content="CptMeow">
  <meta name="keyword" content="Shibaza">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Shibaza Framework') }}</title>
  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/favicon/apple-icon-57x57.png') }}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favicon/apple-icon-60x60.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/favicon/apple-icon-72x72.png') }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/apple-icon-76x76.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/favicon/apple-icon-114x114.png') }}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/favicon/apple-icon-120x120.png') }}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/favicon/apple-icon-144x144.png') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favicon/apple-icon-152x152.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-icon-180x180.png') }}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/favicon/android-icon-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/favicon-96x96.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="{{ asset('assets/favicon/ms-icon-144x144.png') }}">
  <meta name="theme-color" content="#ffffff">
  <!-- Vendors styles-->
  <link rel="stylesheet" href="{{ asset('vendors/simplebar/dist/simplebar.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/@coreui/icons/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/@coreui/coreui-pro/dist/css/coreui.min.css') }}">
  <!-- Main styles for this application-->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <!-- We use those styles to show code examples, you should remove them in your application.-->
  <link href="{{ asset('css/examples.css') }}" rel="stylesheet">
  <!--CSS PAGE-->
  {{ $css }}
</head>

<body class="app">
  @include('layouts.template.shared.nav-builder')
  @include('layouts.template.shared.sidebar')

  <div class="wrapper d-flex flex-column min-vh-100 bg-light bg-opacity-50 dark:bg-transparent">

    @include('layouts.template.shared.header')

    <div class="body flex-grow-1 px-3">
      {{ $content }}
    </div>

    @include('layouts.template.shared.footer')
  </div>

  <!-- CoreUI and necessary plugins-->
  <script src="{{ asset('vendors/@coreui/coreui-pro/dist/js/coreui.bundle.min.js') }}"></script>
  <script src="{{ asset('vendors/jquery/jquery-3.6.1.min.js') }}"></script>
  <script src="{{ asset('vendors/simplebar/dist/simplebar.min.js') }}"></script>

   <!-- นำเข้าไฟล์ jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script>
    if (document.body.classList.contains('dark-theme')) {
      var element = document.getElementById('btn-dark-theme');
      if (typeof(element) != 'undefined' && element != null) {
        document.getElementById('btn-dark-theme').checked = true;
      }
    } else {
      var element = document.getElementById('btn-light-theme');
      if (typeof(element) != 'undefined' && element != null) {
        document.getElementById('btn-light-theme').checked = true;
      }
    }

    function handleThemeChange(src) {
      var event = document.createEvent('Event');
      event.initEvent('themeChange', true, true);

      if (src.value === 'light') {
        document.body.classList.remove('dark-theme');
      }
      if (src.value === 'dark') {
        document.body.classList.add('dark-theme');
      }
      document.body.dispatchEvent(event);
    }
  </script>
  <script>
    let selectLocale = document.getElementById("select-locale")
    selectLocale.addEventListener("change", function() {
      document.getElementById('select-locale-form').submit();
    });
  </script>
  <script>
    // $( document ).ready(function() {

    // });
    $("#btn-delete").click(function() {
      if (confirm("Are you sure you want to delete this?")) {
        return true;
      } else {
        return false;
      }
    });
  </script>
  <!--JS PAGE-->
  {{ $javascript }}



</body>

</html>

