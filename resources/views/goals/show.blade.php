@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="relative">
                @if($goal->image_path)
                    <img src="{{ Storage::url($goal->image_path) }}" 
                         alt="{{ $goal->title }}" 
                         class="w-full h-96 object-cover"
                         onerror="this.src='{{ asset('images/default-goal.jpg') }}'">
                @else
                    <div class="w-full h-96 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-bullseye text-white text-6xl"></i>
                    </div>
                @endif
                <div class="absolute top-4 right-4 flex space-x-2">
                    <a href="{{ route('goals.edit', $goal) }}" 
                       class="bg-white p-2 rounded-full shadow-md hover:bg-gray-100 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                    </a>
                    <form action="{{ route('goals.destroy', $goal) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-white p-2 rounded-full shadow-md hover:bg-gray-100 transition duration-200"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet objectif ?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="p-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $goal->title }}</h1>
                <p class="text-gray-600 text-lg mb-6">{{ $goal->description }}</p>

                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-500 mb-2">Date limite</h3>
                        <p class="text-lg font-semibold text-gray-800">
                            {{ $goal->deadline ? $goal->deadline->format('d/m/Y') : 'Non définie' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-500 mb-2">Visibilité</h3>
                        <p class="text-lg font-semibold text-gray-800">
                            @switch($goal->visibility)
                                @case('private')
                                    Privé
                                    @break
                                @case('public')
                                    Public
                                    @break
                                @case('friends')
                                    Amis uniquement
                                    @break
                            @endswitch
                        </p>
                    </div>
                </div>

                <div class="mb-8">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl font-semibold text-gray-800">Progression</h2>
                        <span class="text-lg font-semibold text-blue-600">{{ $goal->progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" 
                             style="width: {{ $goal->progress }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Étapes</h2>
                <button onclick="document.getElementById('addStepModal').classList.remove('hidden')"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Ajouter une étape
                </button>
            </div>

            <div class="space-y-4">
                @forelse($goal->steps as $step)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input type="checkbox" 
                                       name="completed" 
                                       {{ $step->completed ? 'checked' : '' }}
                                       class="h-6 w-6 text-blue-600 rounded focus:ring-blue-500 cursor-pointer"
                                       onchange="updateStepStatus({{ $step->id }}, this.checked)">
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 text-lg">{{ $step->title }}</h3>
                                <p class="text-gray-600">{{ $step->description }}</p>
                                @if($step->deadline)
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Date limite: {{ $step->deadline->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500">Aucune étape n'a été définie pour cet objectif.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter une étape -->
<div id="addStepModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Ajouter une étape</h3>
            <form action="{{ route('goals.addStep', $goal) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="step_title" class="block text-gray-700 text-sm font-bold mb-2">Titre</label>
                    <input type="text" 
                           name="title" 
                           id="step_title" 
                           required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="step_description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" 
                              id="step_description" 
                              rows="3"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mb-4">
                    <label for="step_deadline" class="block text-gray-700 text-sm font-bold mb-2">Date limite</label>
                    <input type="date" 
                           name="deadline" 
                           id="step_deadline"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" 
                            onclick="document.getElementById('addStepModal').classList.add('hidden')"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStepStatus(stepId, completed) {
    fetch(`/steps/${stepId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ completed })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    });
}
</script>

<style>
    .progress-bar {
        transition: width 0.6s ease;
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection 