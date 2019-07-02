@extends('layouts.app')

@section('content')
<form action="/tipoTweet" method="POST">
	@csrf	
	<textarea maxlength="240" name="contenido" id="contenido" placeholder="Contenido del tweet" value="{{ old('contenido') }}"></textarea>
	@error('contenido')
	    <div class="alert alert-danger">{{ $message }}</div>
	@enderror
	<input class="btn btn-success" type="submit" value="GUARDAR">
</form>
@endsection