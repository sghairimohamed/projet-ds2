@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-4 fw-bold text-primary">Mes Objectifs</h1>
        <a href="{{ route('goals.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle me-2"></i>Nouvel Objectif
        </a>
    </div>

    @if($goals->isEmpty())
        <div class="text-center py-5">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-5">
                    <i class="fas fa-bullseye fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">Aucun objectif pour le moment</h3>
                    <p class="text-muted mb-4">Commencez votre voyage vers le succès en créant votre premier objectif !</p>
                    <a href="{{ route('goals.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle me-2"></i>Créer un Objectif
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($goals as $goal)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-lg goal-card">
                        @if($goal->image_path)
                            <img src="{{ Storage::url($goal->image_path) }}" 
                                 class="card-img-top goal-image" 
                                 alt="{{ $goal->title }}"
                                 onerror="this.src='{{ asset('images/default-goal.jpg') }}'">
                        @else
                            <div class="goal-image-placeholder">
                                <i class="fas fa-bullseye fa-3x text-primary"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold text-truncate">{{ $goal->title }}</h5>
                                <span class="badge bg-{{ $goal->progress >= 100 ? 'success' : 'primary' }}">
                                    {{ $goal->progress }}%
                                </span>
                            </div>
                            
                            <p class="card-text text-muted mb-3">
                                {{ Str::limit($goal->description, 100) }}
                            </p>
                            
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-primary" 
                                     role="progressbar" 
                                     style="width: {{ $goal->progress }}%"
                                     aria-valuenow="{{ $goal->progress }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                                <div>
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $goal->deadline->format('d/m/Y') }}
                                </div>
                                <div>
                                    <i class="fas fa-tasks me-1"></i>
                                    {{ $goal->steps->count() }} étapes
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('goals.show', $goal) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i>Voir les détails
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $goals->links() }}
        </div>
    @endif
</div>

<style>
    .goal-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .goal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .goal-image {
        height: 200px;
        object-fit: cover;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .goal-image-placeholder {
        height: 200px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .progress {
        border-radius: 4px;
        overflow: hidden;
    }
    .progress-bar {
        transition: width 0.6s ease;
    }
    .card-title {
        color: #2c3e50;
    }
    .btn-outline-primary {
        transition: all 0.3s ease;
    }
    .btn-outline-primary:hover {
        transform: translateY(-2px);
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.8em;
    }
</style>
@endsection 