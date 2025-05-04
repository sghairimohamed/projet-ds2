

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo e($sharedGoal->title); ?></h5>
                        <div class="btn-group">
                            <a href="<?php echo e(route('shared-goals.progress', $sharedGoal)); ?>" class="btn btn-primary">
                                <i class="fas fa-chart-line me-2"></i>Progression
                            </a>
                            <?php if($sharedGoal->created_by === Auth::id()): ?>
                                <a href="<?php echo e(route('shared-goals.edit', $sharedGoal)); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-2"></i>Modifier
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Description</h6>
                        <p><?php echo e($sharedGoal->description); ?></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Dates</h6>
                            <p>
                                <strong>Début :</strong> <?php echo e($sharedGoal->start_date->format('d/m/Y')); ?><br>
                                <strong>Fin :</strong> <?php echo e($sharedGoal->end_date->format('d/m/Y')); ?>

                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Statistiques</h6>
                            <p>
                                <strong>Participants :</strong> <?php echo e($sharedGoal->participants->count()); ?>/<?php echo e($sharedGoal->max_participants); ?><br>
                                <strong>Progression :</strong> <?php echo e($sharedGoal->progress); ?>%
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
                        <?php $__currentLoopData = $sharedGoal->participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0"><?php echo e($participant->name); ?></h6>
                                        <small class="text-muted">A rejoint le <?php echo e($participant->pivot->joined_at->format('d/m/Y')); ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php if(!$sharedGoal->participants->contains(Auth::id()) && $sharedGoal->participants->count() < $sharedGoal->max_participants): ?>
                        <form action="<?php echo e(route('shared-goals.join', $sharedGoal)); ?>" method="POST" class="mt-3">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary w-100">Rejoindre l'objectif</button>
                        </form>
                    <?php elseif($sharedGoal->participants->contains(Auth::id())): ?>
                        <form action="<?php echo e(route('shared-goals.leave', $sharedGoal)); ?>" method="POST" class="mt-3">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-danger w-100">Quitter l'objectif</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nour_user\projetweb2\resources\views/shared-goals/show.blade.php ENDPATH**/ ?>