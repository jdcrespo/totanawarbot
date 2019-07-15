@extends('layouts.app')

@section('content')
<p>{{ $tipoTweet->contenido }}</p>
<a href='{{ route('tipoTweet.index') }}' class='btn btn-primary'>Atrás</a>
@endsection
