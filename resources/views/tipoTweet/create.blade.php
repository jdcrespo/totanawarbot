@extends('layouts.app')

@section('content')
<form action="{{ route('tipoTweet.store') }}" method="POST">
	@csrf	
	<textarea class="mx-auto w-50" maxlength="240" name="contenido" id="contenido" placeholder="Contenido del tweet" value="{{ old('contenido') }}"></textarea>
	{!! $errors->first('contenido', '
	    <div class="alert alert-danger">:message</div>') !!}
	<input class="btn btn-success" type="submit" value="GUARDAR">
</form>
@endsection
