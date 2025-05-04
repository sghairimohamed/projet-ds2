@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- En-tête avec statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6 flex items-center space-x-4">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-trophy text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm">Badges obtenus</h3>
                    <p class="text-2xl font-semibold">{{ count($userBadges) }}</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 flex items-center space-x-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-star text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm">Badges disponibles</h3>
                    <p class="text-2xl font-semibold">{{ count($badges) }}</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 flex items-center space-x-4">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-percentage text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm">Progression</h3>
                    <p class="text-2xl font-semibold">
                        @if(count($badges) > 0)
                            {{ round((count($userBadges) / count($badges)) * 100) }}%
                        @else
                            0%
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Liste des badges -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($badges as $badge)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-200">
                    <div class="p-6">
                        <div class="flex flex-col items-center text-center">
                            <div class="relative mb-4">
                                <div class="w-24 h-24 rounded-full {{ in_array($badge->id, $userBadges) ? 'bg-yellow-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <i class="fas {{ $badge->icon }} {{ in_array($badge->id, $userBadges) ? 'text-yellow-600' : 'text-gray-400' }} text-4xl"></i>
                                </div>
                                @if(in_array($badge->id, $userBadges))
                                    <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center">
                                        <i class="fas fa-check text-sm"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $badge->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $badge->description }}</p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                                <div class="bg-{{ in_array($badge->id, $userBadges) ? 'green' : 'gray' }}-500 h-2.5 rounded-full" 
                                     style="width: {{ in_array($badge->id, $userBadges) ? '100' : '0' }}%"></div>
                            </div>
                            <div class="text-sm text-gray-500">
                                @switch($badge->condition_type)
                                    @case('goals_completed')
                                        <i class="fas fa-flag-checkered mr-1"></i>
                                        {{ $badge->condition_value }} objectifs complétés
                                        @break
                                    @case('streak_days')
                                        <i class="fas fa-fire mr-1"></i>
                                        {{ $badge->condition_value }} jours consécutifs
                                        @break
                                    @case('shared_goals')
                                        <i class="fas fa-users mr-1"></i>
                                        {{ $badge->condition_value }} objectifs partagés
                                        @break
                                    @case('journal_entries')
                                        <i class="fas fa-book mr-1"></i>
                                        {{ $badge->condition_value }} entrées de journal
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="bg-gray-100 rounded-lg p-8">
                        <i class="fas fa-trophy text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucun badge disponible</h3>
                        <p class="text-gray-500 mb-4">Commencez à accomplir des objectifs pour débloquer des badges !</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .shadow-sm {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    .hover\:shadow-md:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .transition {
        transition: all 0.2s ease-in-out;
    }
</style>
@endsection 