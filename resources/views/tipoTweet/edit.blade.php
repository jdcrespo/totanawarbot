@extends('layouts.app')

@section('content')
<form action="{{ route('tipoTweet.update', $tipoTweet->id) }}" method="POST">
  {{ method_field('PUT') }}
	@csrf	
	<textarea maxlength="240" name="contenido" id="contenido" placeholder="Contenido del tweet" value="{{ $tipoTweet->contenido }}"></textarea>
	{!! $errors->first('contenido', '
	    <div class="alert alert-danger">:message</div>') !!}
	<input class="btn btn-success" type="submit" value="GUARDAR">
</form>
@endsection
