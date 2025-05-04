@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $sharedGoal->title }}</h5>
                        <div class="btn-group">
                            <a href="{{ route('shared-goals.progress', $sharedGoal) }}" class="btn btn-primary">
                                <i class="fas fa-chart-line me-2"></i>Progression
                            </a>
                            @if($sharedGoal->created_by === Auth::id())
                                <a href="{{ route('shared-goals.edit', $sharedGoal) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-2"></i>Modifier
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Description</h6>
                        <p>{{ $sharedGoal->description }}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Dates</h6>
                            <p>
                                <strong>Début :</strong> {{ $sharedGoal->start_date->format('d/m/Y') }}<br>
                                <strong>Fin :</strong> {{ $sharedGoal->end_date->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Statistiques</h6>
                            <p>
                                <strong>Participants :</strong> {{ $sharedGoal->participants->count() }}/{{ $sharedGoal->max_participants }}<br>
                                <strong>Progression :</strong> {{ $sharedGoal->progress }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Participants</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($sharedGoal->participants as $participant)
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $participant->name }}</h6>
                                        <small class="text-muted">A rejoint le {{ $participant->pivot->joined_at->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(!$sharedGoal->participants->contains(Auth::id()) && $sharedGoal->participants->count() < $sharedGoal->max_participants)
                        <form action="{{ route('shared-goals.join', $sharedGoal) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Rejoindre l'objectif</button>
                        </form>
                    @elseif($sharedGoal->participants->contains(Auth::id()))
                        <form action="{{ route('shared-goals.leave', $sharedGoal) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">Quitter l'objectif</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 