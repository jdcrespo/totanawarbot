@extends('layouts.app')

@section('content')
<div class="row m-4">
    <div class="card col-md-6">
        <div class="card-header">
            Fallecidos: {{ count($muertos) }} usuarios
        </div>
        <div class="card-body">
           <table id="tablaMuertes">
               <thead>
                   <tr>
                       <th>Nombre</th>
                       <th>Fecha</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach ($muertos as $muerto)
                        <tr>
                            <td>{{ "@".$muerto->nombre }}</td>
                            <td>{{ $muerto->updated_at }}</td>
                        </tr>
                   @endforeach
               </tbody>
           </table>
        </div>
    </div>
    <div class="card col-md-6">
        <div class="card-header">
            Vivos: {{ count($vivos) }} usuarios
        </div>
        <div class="card-body">
           <table id="tablaVivos">
               <thead>
                   <tr>
                       <th>Nombre</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach ($vivos as $vivo)
                        <tr>
                            <td>{{ "@".$vivo->nombre }}</td>
                        </tr>
                   @endforeach
               </tbody>
           </table>
        </div>
    </div>
</div>
<div class="row m-4">
    <div class="card col-md-12">
        <div class="card-header">
            Tipos de muerte: {{ count($tiposTweet) }}
        </div>
        <div class="card-body">
            <table class="table ttable-sm table-hover" id="tablaTiposMuerte">
                <thead>
                    <tr>
                        <th scope="col">Texto</th>
                        <th>Ult. uso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tiposTweet as $tipo)
                    <tr>
                        <td>
                            {{$tipo->contenido}}
                        </td>
                        <td>{{$tipo->usado}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>      
<script type="text/javascript">
    $(document).ready( function () {
        let jsonConfig = {
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        };
        $('#tablaMuertes').DataTable(jsonConfig);
        $('#tablaVivos').DataTable(jsonConfig);
        $('#tablaTiposMuerte').DataTable(jsonConfig);
    } );
</script>
@endsection
