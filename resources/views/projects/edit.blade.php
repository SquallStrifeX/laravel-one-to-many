{{-- resources/views/admin/projects/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifica Progetto: {{ $project->name }}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ci sono stati alcuni problemi con il tuo input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.projects.update', $project->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Importante per le richieste di aggiornamento in Laravel --}}
        <div class="form-group">
            <label for="name">Nome Progetto</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Inserisci il nome del progetto" value="{{ old('name', $project->name) }}">
        </div>
        <div class="form-group">
            <label for="description">Descrizione</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $project->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="repository_link">Link al Repository</label>
            <input type="text" class="form-control" id="repository_link" name="repository_link" placeholder="Inserisci il link al repository" value="{{ old('repository_link', $project->repository_link) }}">
        </div>
        <div class="form-group">
            <label for="date_start">Data Inizio</label>
            <input type="date" class="form-control" id="date_start" name="date_start" value="{{ old('date_start', $project->date_start) }}">
        </div>
        <div class="form-group">
            <label for="date_end">Data Fine (opzionale)</label>
            <input type="date" class="form-control" id="date_end" name="date_end" value="{{ old('date_end', $project->date_end) }}">
        </div>
        <div class="form-group">
            <label for="img">Immagine del Progetto (opzionale)</label>
            <input type="file" class="form-control-file" id="img" name="img">
        </div>
        <button type="submit" class="btn btn-primary">Aggiorna Progetto</button>
    </form>
</div>
@endsection
