@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Listado de Cursos</h5>
    </div>
    <div class="card-body"></div>


    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Lista de Cursos</h1>
        <a href="{{ route('cursos.create') }}" class="btn btn-primary">Nuevo Curso</a>
    </div>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>

                <th>Año</th>
                <th>Semestre</th>
                <th>Ciclo</th>
                <th>Profesor Jefe</th>
                <th>Nivel</th>
                <th>Letra</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cursos as $curso)
                <tr>
                    <td>{{ $curso->ciclo->semestre->anioAcademico->anio_valor ?? 'N/A' }}</td>
                    <td>{{ $curso->ciclo->semestre->nombre ?? 'N/A' }}</td>
                    <td>{{ $curso->ciclo->nombre ?? 'N/A' }}</td>

                    <td>{{ $curso->profesorJefe->nombre ?? 'Sin asignar' }}</td>

                    <td>{{ $curso->nivel }}</td>
                    <td>{{ $curso->letra }}</td>
                    
                    <td>
                        <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection