<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PGR System</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <style type="text/css">
    .lt-ie9 #app { display: none !important; }
    html, body, #browser-support-check-container {position : relative; width: 100%; height: 100%; background: #3c8dbc; padding: 0; margin: 0;}
    #browser-support-check-modal {position: absolute; left: 50%; top: 50%; width: 500px; height: 200px; margin: -100px 0 0 -250px; background : #000; padding: 10px; color: #FFF;}
    #browser-support-check-container {display: none;}
    #browser-support-check-modal {display: none;}
    .lt-ie9 #browser-support-check-container {display: block;}
    .lt-ie9 #browser-support-check-modal {display: block;}
  </style>

  <link rel="stylesheet" href="{{ url(config('app.url_prefix') . mix('css/app.css')) }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <script>
  window.csrfToken  =  <?php echo json_encode([
  'csrfToken' => csrf_token(),
  ]); ?>
  </script>
  @stack('header_scripts')

<link rel="stylesheet" href="{{ asset(str_finish(config('app.url_prefix'), '/') . 'visjs/vis.min.css') }}"/>
<script src="{{ asset(str_finish(config('app.url_prefix'), '/') . 'visjs/vis.min.js') }}"></script>

<link rel="stylesheet"
      href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>
<link rel="stylesheet"
      href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
<link rel="stylesheet"
      href="//cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"/>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css"/>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>