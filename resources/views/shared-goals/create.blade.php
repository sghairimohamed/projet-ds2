@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un Objectif Partagé</h1>
    <form method="POST" action="{{ url('/shared-goals') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="start_date">Date de début</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="end_date">Date de fin</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="max_participants">Participants max</label>
            <input type="number" name="max_participants" id="max_participants" class="form-control">
        </div>

        <div class="form-group">
            <label for="status">Statut</label>
            <select name="status" id="status" class="form-control" required>
                <option value="open">Ouvert</option>
                <option value="closed">Fermé</option>
                <option value="completed">Terminé</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Image (facultatif)</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Créer</button>
    </form>
</div>
@endsection
