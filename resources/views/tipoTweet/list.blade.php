@extends('layouts.app')

@section('content')
<a href="/tipoTweet/create" class="btn btn-primary">Crear</a>
<table class="table ttable-sm table-hover" id="tablaUsuarios">
	<thead>
		<tr>
			<th scope="col">Texto</th>
			<th scope="col">Asesinos</th>
			<th scope="col">Victimas</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($tiposTweet as $tipo)
		<tr>
			<td>
				{{$tipo->contenido}}
			</td>
			<td>
				{{$tipo->asesinos}}
			</td>
			<td>
				{{$tipo->victimas}}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection
