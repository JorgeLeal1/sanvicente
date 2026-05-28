@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0 fw-bold text-primary">Listado de Alumnos</h5>
            <a href="{{ route('alumnos.create') }}" class="btn btn-sv shadow-sm">+ Nuevo Alumno</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">RUT</th>
                            <th>Nombre</th>
                            <th>Curso</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumnos as $alumno)
                        <tr>
                            <td class="px-4 fw-bold text-secondary">{{ $alumno->rut }}</td>
                            <td>{{ $alumno->nombre }} {{ $alumno->apellido }}</td>
                            <td><span class="badge bg-info text-dark">{{ $alumno->curso->nombre ?? 'S/A' }}</span></td>
                            <td class="text-center">
                                <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection