@extends('layouts.app')
@section('contenido')
<!-- Modal -->
<div class="table-responsive">
    <table id="miTabla" class="table table-hover">
        <thead>
            <tr>
                <th class="centered">#</th>
                <th class="centered">Estado</th>
                <th class="centered">fecha registro</th>
                <th class="centered">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($estados as $estado)
                <tr id="estado_{{ $estado->id_estado }}">
                    <td>{{ $estado->id_estado }}</td>
                    <td>{{ $estado->nombre_estado }}</td>
                    <td>{{ $estado->created_at }}</td>
                    <td class=" row justify-content-center">
                        <ul class="opciones">
                            <li>
                                <a title="Eliminar Zona" class="btn btn-danger btn-eliminar" data-tipo="estado" data-id="{{ $estado->id_estado}}">
                                <i class="fas fa-trash-alt" title="Eliminar"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay Estados disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
<script>
    window.mensajeSuccess = @json(session('success'));
    window.mensajeError = @json(session('error'));
</script>