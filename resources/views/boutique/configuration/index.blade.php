@extends('boutique.layouts.app')
@section('content')
  @verbatim
  <div class="page-body">
    <div class="container configuration-container py-5" id="app">
    </div>
  </div>
  @endverbatim
@endsection

@section('js')
  @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection
