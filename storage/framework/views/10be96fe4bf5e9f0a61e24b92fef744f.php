

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- En-tête avec statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6 flex items-center space-x-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-book text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm">Total des entrées</h3>
                    <p class="text-2xl font-semibold"><?php echo e($journals->total()); ?></p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 flex items-center space-x-4">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-smile text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm">Moyenne d'humeur</h3>
                    <p class="text-2xl font-semibold"><?php echo e(number_format($journals->avg('mood'), 1)); ?>/5</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6 flex items-center space-x-4">
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-500 text-sm">Dernière entrée</h3>
                    <p class="text-2xl font-semibold"><?php echo e($journals->first() ? $journals->first()->created_at->format('d/m/Y') : 'Aucune'); ?></p>
                </div>
            </div>
        </div>

        <!-- Bouton de création -->
        <div class="flex justify-end mb-6">
            <a href="<?php echo e(route('progress-journals.create')); ?>" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition duration-200">
                <i class="fas fa-plus"></i>
                <span>Nouvelle entrée</span>
            </a>
        </div>

        <!-- Liste des entrées -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-200">
                    <?php if($journal->image_path): ?>
                        <div class="h-48 overflow-hidden">
                            <img src="<?php echo e(Storage::url($journal->image_path)); ?>" 
                                 alt="<?php echo e($journal->title); ?>" 
                                 class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-800"><?php echo e($journal->title); ?></h3>
                            <?php if($journal->mood): ?>
                                <div class="flex items-center space-x-1">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?php echo e($i <= $journal->mood ? 'text-yellow-400' : 'text-gray-300'); ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <p class="text-gray-600 mb-4 line-clamp-3"><?php echo e($journal->content); ?></p>
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span><?php echo e($journal->created_at->format('d/m/Y H:i')); ?></span>
                            <div class="flex space-x-2">
                                <a href="<?php echo e(route('progress-journals.show', $journal)); ?>" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('progress-journals.edit', $journal)); ?>" 
                                   class="text-green-600 hover:text-green-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('progress-journals.destroy', $journal)); ?>" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entrée ?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-12">
                    <div class="bg-gray-100 rounded-lg p-8">
                        <i class="fas fa-book-open text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucune entrée dans votre journal</h3>
                        <p class="text-gray-500 mb-4">Commencez à documenter votre progression en créant votre première entrée.</p>
                        <a href="<?php echo e(route('progress-journals.create')); ?>" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center space-x-2">
                            <i class="fas fa-plus"></i>
                            <span>Créer une entrée</span>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            <?php echo e($journals->links()); ?>

        </div>
    </div>
</div>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
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
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nour_user\projetweb2\resources\views/progress-journals/index.blade.php ENDPATH**/ ?>