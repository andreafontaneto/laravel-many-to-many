@extends('layouts.admin')

@section('content')
<div class="container">
  <div>
    <h1>ERRORE 404</h1>
    <h3>Pagina non trovata</h3>
    <p>{{ $exception->getMessage() }}</p>
  </div>
</div>
@endsection
