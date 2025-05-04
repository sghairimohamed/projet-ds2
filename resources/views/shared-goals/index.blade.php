@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Objectifs partagés</h2>
        <a href="{{ route('shared-goals.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvel objectif partagé
        </a>
    </div>
    <div class="row g-4">
        @forelse($sharedGoals as $goal)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $goal->title }}</h5>
                        <p class="card-text text-muted small mb-2">{{ Str::limit($goal->description, 80) }}</p>
                        <div class="mb-2">
                            <span class="badge bg-primary">{{ $goal->progress }}% progression</span>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-users me-1"></i>
                            {{ $goal->participants->count() }}/{{ $goal->max_participants }} participants
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ $goal->start_date->format('d/m/Y') }} - {{ $goal->end_date->format('d/m/Y') }}
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('shared-goals.show', $goal) }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-eye me-1"></i>Voir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Aucun objectif partagé pour le moment.</p>
                <a href="{{ route('shared-goals.create') }}" class="btn btn-primary">Créer un objectif partagé</a>
            </div>
        @endforelse
    </div>
    <div class="mt-4">
        {{ $sharedGoals->links() }}
    </div>
</div>
@endsection 