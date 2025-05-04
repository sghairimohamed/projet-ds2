@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Progression de l'objectif : {{ $sharedGoal->title }}</h5>
                        <span class="badge bg-primary">{{ $sharedGoal->progress }}%</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Formulaire d'ajout de progression -->
                    <form action="{{ route('shared-goals.progress.store', $sharedGoal) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="progress" class="form-label">Progression (%)</label>
                            <input type="range" class="form-range" id="progress" name="progress" min="0" max="100" step="1" value="0">
                            <div class="d-flex justify-content-between">
                                <small>0%</small>
                                <small id="progressValue">0%</small>
                                <small>100%</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Commentaire</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image (optionnelle)</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer la progression</button>
                    </form>

                    <!-- Historique des progressions -->
                    <h6 class="mb-3">Historique des progressions</h6>
                    <div class="list-group">
                        @forelse($sharedGoal->progressLogs()->with('user')->latest()->get() as $log)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="mb-0">{{ $log->user->name }}</h6>
                                        <small class="text-muted">{{ $log->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <span class="badge bg-primary">{{ $log->progress }}%</span>
                                </div>
                                @if($log->comment)
                                    <p class="mb-2">{{ $log->comment }}</p>
                                @endif
                                @if($log->image_path)
                                    <img src="{{ Storage::url($log->image_path) }}" alt="Progression" class="img-fluid rounded mb-2" style="max-height: 200px;">
                                @endif
                                @if($log->user_id === Auth::id())
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProgressModal{{ $log->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('shared-goals.progress.destroy', [$sharedGoal, $log]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette progression ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal d'édition -->
                                    <div class="modal fade" id="editProgressModal{{ $log->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('shared-goals.progress.update', [$sharedGoal, $log]) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Modifier la progression</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="progress{{ $log->id }}" class="form-label">Progression (%)</label>
                                                            <input type="range" class="form-range" id="progress{{ $log->id }}" name="progress" min="0" max="100" step="1" value="{{ $log->progress }}">
                                                            <div class="d-flex justify-content-between">
                                                                <small>0%</small>
                                                                <small class="progressValue">{{ $log->progress }}%</small>
                                                                <small>100%</small>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="comment{{ $log->id }}" class="form-label">Commentaire</label>
                                                            <textarea class="form-control" id="comment{{ $log->id }}" name="comment" rows="3">{{ $log->comment }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="image{{ $log->id }}" class="form-label">Image (optionnelle)</label>
                                                            <input type="file" class="form-control" id="image{{ $log->id }}" name="image" accept="image/*">
                                                            @if($log->image_path)
                                                                <img src="{{ Storage::url($log->image_path) }}" alt="Progression" class="img-fluid rounded mt-2" style="max-height: 200px;">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">Aucune progression enregistrée</p>
                            </div>
                        @endforelse
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
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Mise à jour de la valeur du slider de progression
    document.getElementById('progress').addEventListener('input', function() {
        document.getElementById('progressValue').textContent = this.value + '%';
    });

    // Mise à jour des valeurs des sliders dans les modals
    document.querySelectorAll('input[type="range"]').forEach(function(slider) {
        if (slider.id !== 'progress') {
            slider.addEventListener('input', function() {
                this.parentElement.querySelector('.progressValue').textContent = this.value + '%';
            });
        }
    });
</script>
@endsection 