{{-- resources/views/admin/projects/index.blade.php --}}
@extends('layouts.app') {{-- Assicurati che questo layout esista o adattalo alla tua struttura --}}

@section('content')
<div class="container">
    <h1>Lista Progetti</h1>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Crea Nuovo Progetto</a>
    <br><br>
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrizione</th>
                <th>Data Inizio</th>
                <th>Data Fine</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
            <tr>
                <td>
                    <a href="{{ route('admin.projects.show', $project->slug) }}">{{ $project->name }}</a>
                </td>
                <td>{{ Str::limit($project->description, 50) }}</td>
                <td>{{ $project->date_start }}</td>
                <td>{{ $project->date_end ?? 'Non definita' }}</td>
                <td>
                    <a href="{{ route('admin.projects.show', ['project' => $project->slug]) }}" class="btn btn-info">Visualizza</a>
                    <a href="{{ route('admin.projects.edit', ['project' => $project->slug]) }}" class="btn btn-primary">Modifica</a>
                    <form action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questo progetto?')">Elimina</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
