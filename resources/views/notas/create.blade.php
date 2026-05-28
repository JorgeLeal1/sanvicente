@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0 fw-bold text-primary">📝 Ingresar Calificaciones</h5>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('notas.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Curso</label>
                                <select name="id_curso" id="id_curso" class="form-select border-primary" required shadow-sm>
                                    <option value="">Seleccione un curso...</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}">{{ $curso->nivel }} {{ $curso->letra }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Asignatura</label>
                                <select name="asignatura" class="form-select border-primary" required>
                                    <option value="Matemáticas">Matemáticas</option>
                                    <option value="Lenguaje">Lenguaje</option>
                                    <option value="Ciencias">Ciencias</option>
                                    <option value="Historia">Historia</option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Alumno</th>
                                        <th style="width: 150px;">Nota (1.0 - 7.0)</th>
                                        <th>Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Aquí podrías usar un loop de alumnos si filtraras por curso --}}
                                    @foreach($alumnos as $alumno)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="notas[{{ $loop->index }}][id_alumno]" value="{{ $alumno->id }}">
                                            {{ $alumno->nombre }} {{ $alumno->apellido }}
                                        </td>
                                        <td>
                                            <input type="number" name="notas[{{ $loop->index }}][valor]" 
                                                   class="form-control border-sv" step="0.1" min="1" max="7" placeholder="0.0">
                                        </td>
                                        <td>
                                            <input type="text" name="notas[{{ $loop->index }}][observacion]" 
                                                   class="form-control form-control-sm" placeholder="Opcional...">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-light me-2">Cancelar</a>
                            <button type="submit" class="btn btn-sv px-4 shadow">Guardar Calificaciones</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-sv { border-color: #3b4cca !important; }
    .btn-sv { background-color: #3b4cca; color: white; }
    .btn-sv:hover { background-color: #2a3a9c; color: white; }
</style>
@endsection