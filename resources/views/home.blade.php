@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-left">
                            <h4>Usuarios</h4>
                        </div>
                        <div class="col text-right">
                            Total: {{$totalUsuarios}}<br>
                            Verificados: {{$totalVerificados}}
                        </div>
                    </div>
                </div>
                    
                <div class="card-body">
                    <table class="table ttable-sm table-hover" id="tablaUsuarios">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Verificado</th>
                                <th scope="col">Vivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>
                                        <a href="https://www.twitter.com/{{$usuario->nombre}}">
                                            {{"@".$usuario->nombre}}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if ($usuario->validado)
                                            <span class="badge badge-success">SI ({{$usuario->validado_por}})</span>
                                        @else
                                            <span class="badge badge-danger">NO</span>
                                        @endif
                                        <a href="/usuarios/verificar/{{$usuario->twitter_user_id}}" class="btn btn-primary btn-sm" onclick='return confirm("¿Estás seguro?")'>Verificar</a>
                                    </td>
                                    <td> 
                                        @if ($usuario->vivo)
                                            <span class="badge badge-success">SI</span>
                                        @else
                                            <span class="badge badge-danger">NO</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function () {
        $('#tablaUsuarios').datatable();
    } );
</script>

@endsection
