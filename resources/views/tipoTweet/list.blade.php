@extends('layouts.app')

@section('content')
<a href="{{ route('tipoTweet.create') }}" class="btn btn-primary">Crear</a>
<table class="table ttable-sm table-hover" id="tablaUsuarios">
	<thead>
		<tr>
			<th scope="col">Texto</th>
			<th>Ult. uso</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($tiposTweet as $tipo)
		<tr>
			<td>
				{{$tipo->contenido}}
			</td>
			<td>{{$tipo->usado}}</td>
			<td>
				<form style="display: inline;" method="post" action="{{ route('tipoTweet.destroy', $tipo->id) }}">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                </form>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready( function () {
	    $('#tablaUsuarios').DataTable();
	} );
</script>
@endsection
