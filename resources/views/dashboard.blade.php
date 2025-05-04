@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête du dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1">Bonjour, {{ Auth::user()->name }} !</h1>
                            <p class="text-muted mb-0">Voici un aperçu de votre progression</p>
                        </div>
                        <div class="d-flex gap-3">
                            <a href="{{ route('goals.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Nouvel objectif
                            </a>
                            <a href="{{ route('shared-goals.create') }}" class="btn btn-outline-primary">
                                <i class="fas fa-users me-2"></i>Objectif partagé
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Objectifs en cours</h6>
                            <h3 class="mb-0">{{ $activeGoalsCount ?? 0 }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-bullseye text-primary fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Objectifs terminés</h6>
                            <h3 class="mb-0">{{ $completedGoalsCount ?? 0 }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-check-circle text-success fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Badges obtenus</h6>
                            <h3 class="mb-0">{{ $badgesCount ?? 0 }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-trophy text-warning fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Progression moyenne</h6>
                            <h3 class="mb-0">{{ $averageProgress ?? 0 }}%</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-chart-line text-info fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Objectifs en cours -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Objectifs en cours</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Objectif</th>
                                    <th>Progression</th>
                                    <th>Échéance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeGoals as $goal)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-primary bg-opacity-10 p-2 rounded">
                                                        <i class="fas fa-bullseye text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0">{{ $goal->title }}</h6>
                                                    <small class="text-muted">{{ Str::limit($goal->description, 50) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-primary" role="progressbar" 
                                                     style="width: {{ $goal->progress }}%;" 
                                                     aria-valuenow="{{ $goal->progress }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100"></div>
                                            </div>
                                            <small class="text-muted">{{ $goal->progress }}%</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $goal->deadline->isPast() ? 'danger' : 'success' }}">
                                                {{ $goal->deadline->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('goals.show', $goal) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('goals.edit', $goal) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('goals.destroy', $goal) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet objectif ?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <p class="text-muted mb-0">Aucun objectif en cours</p>
                                            <a href="{{ route('goals.create') }}" class="btn btn-primary btn-sm mt-2">
                                                Créer un objectif
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Objectifs partagés et badges -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Objectifs partagés récents</h5>
                </div>
                <div class="card-body">
                    @forelse($recentSharedGoals as $sharedGoal)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 p-2 rounded">
                                    <i class="fas fa-users text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $sharedGoal->title }}</h6>
                                <small class="text-muted">
                                    {{ $sharedGoal->participants->count() }} participants
                                </small>
                            </div>
                            <a href="{{ route('shared-goals.show', $sharedGoal) }}" class="btn btn-sm btn-outline-primary">
                                Voir
                            </a>
                        </div>
                    @empty
                        <p class="text-muted text-center mb-0">Aucun objectif partagé récent</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Badges récents</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @forelse($recentBadges as $badge)
                            <div class="col-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body text-center">
                                        <div class="mb-2">
                                            <i class="fas fa-trophy fa-2x text-warning"></i>
                                        </div>
                                        <h6 class="mb-1">{{ $badge->name }}</h6>
                                        <small class="text-muted">{{ $badge->description }}</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted text-center mb-0">Aucun badge obtenu</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .card {
        border-radius: 1rem;
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .progress {
        border-radius: 1rem;
    }

    .badge {
        padding: 0.5em 0.75em;
        border-radius: 0.5rem;
    }

    .btn-group .btn {
        border-radius: 0.5rem;
    }

    .table th {
        border-top: none;
        font-weight: 600;
    }

    .table td {
        vertical-align: middle;
    }
</style>
@endsection 