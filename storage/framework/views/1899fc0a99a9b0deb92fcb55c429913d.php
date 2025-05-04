<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
            <div class="p-6">
                <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Modifier l'objectif</h1>

                <form action="<?php echo e(route('goals.update', $goal)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-6 flex flex-col items-center">
                        <label for="image" class="block text-gray-700 text-sm font-medium mb-2">Photo de couverture</label>
                        <div class="flex flex-col items-center space-y-4">
                            <div class="relative w-32 h-32 rounded-lg overflow-hidden border border-gray-200">
                                <?php if($goal->image_path): ?>
                                    <img src="<?php echo e(Storage::url($goal->image_path)); ?>" 
                                         alt="Image actuelle" 
                                         class="w-full h-full object-cover"
                                         id="imagePreview">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="text-center">
                                <input type="file" 
                                       name="image" 
                                       id="image" 
                                       accept="image/*"
                                       class="hidden"
                                       onchange="previewImage(this)">
                                <label for="image" 
                                       class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 rounded-md cursor-pointer hover:bg-gray-200 transition duration-200 text-sm font-medium">
                                    <i class="fas fa-camera mr-2 text-gray-500"></i>
                                    Changer la photo
                                </label>
                                <p class="text-xs text-gray-500 mt-1">
                                    Format : JPG, PNG. Max 2MB
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="max-w-md mx-auto">
                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <div>
                                <label for="title" class="block text-gray-700 text-sm font-medium mb-1 text-center">Titre</label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       value="<?php echo e(old('title', $goal->title)); ?>"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center">
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-xs mt-1 text-center"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="deadline" class="block text-gray-700 text-sm font-medium mb-1 text-center">Date limite</label>
                                <input type="date" 
                                       name="deadline" 
                                       id="deadline" 
                                       value="<?php echo e(old('deadline', $goal->deadline ? $goal->deadline->format('Y-m-d') : '')); ?>"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center">
                                <?php $__errorArgs = ['deadline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-xs mt-1 text-center"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-medium mb-1 text-center">Description</label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="3"
                                      required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center"><?php echo e(old('description', $goal->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1 text-center"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-6">
                            <label for="visibility" class="block text-gray-700 text-sm font-medium mb-1 text-center">Visibilité</label>
                            <select name="visibility" 
                                    id="visibility"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center">
                                <option value="private" <?php echo e(old('visibility', $goal->visibility) == 'private' ? 'selected' : ''); ?>>Privé</option>
                                <option value="public" <?php echo e(old('visibility', $goal->visibility) == 'public' ? 'selected' : ''); ?>>Public</option>
                                <option value="friends" <?php echo e(old('visibility', $goal->visibility) == 'friends' ? 'selected' : ''); ?>>Amis uniquement</option>
                            </select>
                            <?php $__errorArgs = ['visibility'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1 text-center"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="flex justify-center space-x-2">
                            <a href="<?php echo e(route('goals.show', $goal)); ?>" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-200 transition duration-200">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition duration-200">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<style>
    .shadow-sm {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    .transition {
        transition: all 0.2s ease-in-out;
    }
    .rounded-md {
        border-radius: 0.375rem;
    }
    .border-gray-200 {
        border-color: #e5e7eb;
    }
    .border-gray-300 {
        border-color: #d1d5db;
    }
    .bg-gray-100 {
        background-color: #f3f4f6;
    }
    .hover\:bg-gray-200:hover {
        background-color: #e5e7eb;
    }
    .text-gray-500 {
        color: #6b7280;
    }
    .text-gray-700 {
        color: #374151;
    }
    .text-gray-400 {
        color: #9ca3af;
    }
    .bg-blue-600 {
        background-color: #2563eb;
    }
    .hover\:bg-blue-700:hover {
        background-color: #1d4ed8;
    }
</style>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Nour_user\projetweb2\resources\views/goals/edit.blade.php ENDPATH**/ ?>