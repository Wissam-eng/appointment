<?php $__env->startSection('content'); ?>


<style>
    .bg-gradient-primary {
        background: linear-gradient(to bottom, #1976d2, #0d47a1);
    }

    .nav-link {

        font-size: 1rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .nav-link i {
        margin-right: 10px;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 5px;
    }

    .sidebar .text-center img {
        border: 2px solid white;
    }

    .heart-container {
        position: relative;
        display: inline-block;
        font-size: 62px;
    }

    .heart-container .fa-heart {
        color: red;
    }

    .heart-container .text {
        position: absolute;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 24px;
        font-weight: bold;
    }

    .search-container {
        display: flex;
        align-items: center;
    }

    .search-form {
        display: none;
        margin-left: 10px;
    }

    .search-icon {
        cursor: pointer;
    }
</style>


<style>
    .trash_it,
    .delete_it {
        /* color: red; */
        cursor: pointer
    }

    .edit_it,
    .restor_it {
        color: green;
        cursor: pointer
    }

    a {
        text-decoration: auto;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 1rem;
        justify-content: center;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        position: relative;
        overflow: hidden;
    }

    .card-header {
        position: relative;
    }

    .card-img {
        width: 100%;
        height: 200px;
        margin-top: 8%;
        object-fit: cover;
    }

    .card-actions {
        position: absolute;
        top: 2px;
        right: 10px;
        display: flex;
        gap: 0.5rem;
        align-items: flex-end;

    }

    .card-actions a,
    .card-actions i {
        color: #315883;
        text-decoration: none;
        font-size: 1.2rem;
    }

    .card-body {
        padding: 1rem;
    }

    .card-title {
        margin: 0;
        font-size: 1.2rem;
    }

    .card-text {
        margin: 0.5rem 0;
    }

    .search-container {
        display: flex;
        align-items: center;
    }

    .search-form {
        display: none;
        margin-left: 10px;
    }

    .search-icon {
        cursor: pointer;
    }
</style>

<nav class="navbar navbar-expand-lg bg-body-tertiary" style="    position: sticky;top: 0px;z-index: 33;    padding: 0px;        ">
    <div class="container-fluid" style="    padding: 0px;">


        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="justify-content: space-around;;background-color:white;">
            <div class="icon">
                <i class="fa-solid fa-puzzle-piece" style="font-size: 400%;    color: #3061bc;"></i>
            </div>
            <div class="search-container">
                <i class="fas fa-search search-icon" style="margin-top:10px;margin-right: 20px;"></i>
                <form class="search-form" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                </form>
            </div>

        </div>
    </div>
</nav>




<div class="d-flex">



    <style>
        li a {
            display: none;
        }

        .down {
            padding: 2%;
            background-color: #14386d;
            border-radius: 5px;
            color: white;

        }

        .actions {
            display: flex;
            justify-content: space-evenly;
            gap: 1%;
            align-items: center;
        }

        .card-container {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px;
            scroll-snap-type: x mandatory;
        }

        .card {
            flex: 0 0 auto;
            width: 200px;
            /* يمكنك تغيير هذا العرض وفقًا لحجم البطاقات */
            margin-right: 10px;
            scroll-snap-align: start;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>



    <div class="content flex-grow-1 p-3">
        <div class="container">
            <div class="card-body">
                <?php if(session('flash_message')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('flash_message')); ?>

                </div>
                <?php endif; ?>

                <div class="card-container">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="card">
                        <div class="card-header">
                            <img src="<?php echo e($item->img ? asset($item->img) : asset('storage/images/default_profile.png')); ?>" alt="Profile Picture" class="card-img">
                            <div class="card-actions">

                                <a href="<?php echo e(url('/categories/' . $item->id . '/edit')); ?>" title="Edit Student"><i class="fa-regular fa-pen-to-square"></i></a>

                                <form id="delete-form-<?php echo e($item->id); ?>" method="POST" action="<?php echo e(route('stock.destroy', $item->id)); ?>" accept-charset="UTF-8" style="display:inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <i class="fa-solid fa-trash-can trash_it" style="cursor:pointer" data-form-id="delete-form-<?php echo e($item->id); ?>"></i>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title"><i class="fa-solid fa-puzzle-piece"></i> <?php echo e($item->category_name); ?></h5>
                       
                
                       
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        handleDeleteConfirmation('.trash_it', 'Do you want to Trash this item?', 'Trash');
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('hospitals.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sb\appointment\resources\views/categories/index.blade.php ENDPATH**/ ?>