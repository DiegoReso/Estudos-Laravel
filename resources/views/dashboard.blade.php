@extends('layouts.main')

@section('title', 'Dashboard' )

@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Meus</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if(count($events) > 0)

    @else
    <p>Voce ainda nao tem eventos, <a href="/evets/create">Criar Eventos</a></p>
    @endif
</div>

@endsection