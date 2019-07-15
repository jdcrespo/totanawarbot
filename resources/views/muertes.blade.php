@extends('layouts.app')

@section('content')
<table class="table ttable-sm table-hover" id="tablaUsuarios">
    <thead>
        <tr>
            <th scope="col">Texto</th>
            <th scope="col">Imagen</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($muertes as $muerte)
            <tr>
                <td>
                    {{ $muerte->texto }}
                </td>
                <td class="text-center">
                    <a href="{{$muerte->imagen}}" target="_blank" class='btn btn-info'>
                        IMAGEN
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready( function () {
        $('#tablaUsuarios').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        } );
    } );
</script>
@endsection
