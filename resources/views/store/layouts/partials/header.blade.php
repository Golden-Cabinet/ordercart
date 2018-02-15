<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title></title>

    <!-- Bootstrap core CSS -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/site.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
      body {
        padding-top: 54px;
      }
      @media (min-width: 98%) {
        body {
          padding-top: 56px;
        }
      }

    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>

  @if(\Route::currentRouteName() == 'storeindex')
  <body class="homeBG">
  @else
  <body>
  @endif
 