

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Objectifs partagés</h2>
        <a href="<?php echo e(route('shared-goals.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvel objectif partagé
        </a>
    </div>
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $sharedGoals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo e($goal->title); ?></h5>
                        <p class="card-text text-muted small mb-2"><?php echo e(Str::limit($goal->description, 80)); ?></p>
                        <div class="mb-2">
                            <span class="badge bg-primary"><?php echo e($goal->progress); ?>% progression</span>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-users me-1"></i>
                            <?php echo e($goal->participants->count()); ?>/<?php echo e($goal->max_participants); ?> participants
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-calendar-alt me-1"></i>
                            <?php echo e($goal->start_date->format('d/m/Y')); ?> - <?php echo e($goal->end_date->format('d/m/Y')); ?>

                        </div>
                        <div class="mt-auto">
                            <a href="<?php echo e(route('shared-goals.show', $goal)); ?>" class="btn btn-outline-primary w-100">
                                <i class="fas fa-eye me-1"></i>Voir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Aucun objectif partagé pour le moment.</p>
                <a href="<?php echo e(route('shared-goals.create')); ?>" class="btn btn-primary">Créer un objectif partagé</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="mt-4">
        <?php echo e($sharedGoals->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nour_user\projetweb2\resources\views/shared-goals/index.blade.php ENDPATH**/ ?>