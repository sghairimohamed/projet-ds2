@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un nouvel objectif</h1>

    <form action="{{ url('goals') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="deadline">Date limite</label>
            <input type="date" id="deadline" name="deadline" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="progress">Progression</label>
            <input type="number" id="progress" name="progress" class="form-control" required min="0" max="100">
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Créer l'objectif</button>
    </form>
</div>