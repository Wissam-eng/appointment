<?php $__env->startSection('content'); ?>
    <style>
        hr {
            border: none;
            border-top: 3px double #333;
            color: #333;
            overflow: visible;
            text-align: center;
            height: 5px;
        }

        hr::after {
            background: #fff;
            content: "§";
            padding: 0 4px;
            position: relative;
            top: -13px;
        }

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
            height: 100px;
            flex: 0 0 auto;
            width: 100px;
            margin-right: 10px;
            scroll-snap-align: start;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);




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



    <nav class="navbar navbar-expand-lg bg-body-tertiary" style="    position: sticky;top: 0px;z-index: 33;    padding: 0px;">
        <div class="container-fluid" style="    padding: 0px;">


            <div class="collapse navbar-collapse" id="navbarSupportedContent"
                style="justify-content: flex-end;background-color:white;">
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



        <script>
            $(document).ready(function() {
                $('#doctorsDropdown').on('click', function() {
                    $('#doctorsDropdown a').toggle(); // Toggle all links inside #doctorsDropdown
                });

                $('#hospitalDropdown').on('click', function() {
                    $('#hospitalDropdown a').toggle(); // Toggle all links inside #hospitalDropdown
                });
            });
        </script>
        <style>
            .dd {
                display: flex;
                align-items: center;
                justify-content: space-around;
                height: 86px;
                color: #0dcaf0;
            }
        </style>



        <?php if(session('user_type') == 1): ?>
            <div class="content flex-grow-1 p-3">
                <div class="container">
                    <div class="card-body">

                        <div class="card-container">


                            <div class="card">
                                <div class="card-header" style="text-align: center;">
                                    <a href="<?php echo e(url('hospitals/')); ?>">

                                        <i class="fa-solid fa-square-h"
                                            style="font-size: 300%;color: #0dcaf0; cursor: pointer;"></i>
                                    </a>

                                    <div class="card-actions">


                                    </div>
                                </div>

                                <div class="dd">
                                    <h5 class="card-title"><i class="fa-solid fa-hashtag"></i><?php echo e($counts['hospital']); ?>

                                    </h5>
                                    <a title="hospitals"><i class="fa-solid fa-circle-info"
                                            style="cursor: pointer;"></i></a>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header" style="text-align: center;">
                                    <a href="<?php echo e(url('/facilities/centers')); ?>">
                                        <i class="fa-solid fa-cent-sign"
                                            style="font-size: 300%;color: #0dcaf0; cursor: pointer;"></i>
                                    </a>

                                    <div class="card-actions">


                                    </div>
                                </div>

                                <div class="dd">
                                    <h5 class="card-title"><i class="fa-solid fa-hashtag"></i><?php echo e($counts['centers']); ?> </h5>
                                    <a title="centers"><i class="fa-solid fa-circle-info" style="cursor: pointer;"></i></a>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" style="text-align: center;">
                                    <a href="<?php echo e(route('facilities.clinics')); ?>">
                                        <i class="fa-solid fa-c"
                                            style="font-size: 300%;color: #0dcaf0; cursor: pointer;"></i>
                                    </a>

                                    <div class="card-actions">


                                    </div>
                                </div>

                                <div class="dd">
                                    <h5 class="card-title"><i class="fa-solid fa-hashtag"></i><?php echo e($counts['clinics']); ?> </h5>
                                    <a title="clinics"><i class="fa-solid fa-circle-info" style="cursor: pointer;"></i></a>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-header" style="text-align: center;">
                                    <a href="<?php echo e(url('/facilities/pharmacies')); ?>">
                                        <i class="fa-solid fa-staff-snake"
                                            style="font-size: 300%;color: #0dcaf0; cursor: pointer;"></i>
                                    </a>

                                    <div class="card-actions">


                                    </div>
                                </div>

                                <div class="dd">
                                    <h5 class="card-title"><i class="fa-solid fa-hashtag"></i><?php echo e($counts['pharmacy']); ?>

                                    </h5>
                                    <a title="pharmacies"><i class="fa-solid fa-circle-info"
                                            style="cursor: pointer;"></i></a>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header" style="text-align: center;">

                                    <i class="fa-solid fa-money-bill-transfer"
                                        style="font-size: 300%;color: #198754; cursor: pointer;"></i>
                                    <div class="card-actions">


                                    </div>
                                </div>

                                <div class="dd">
                                    <h5 class="card-title"><i class="fa-solid fa-hashtag"></i>349 </h5>
                                    <a title="View Student"><i class="fa-solid fa-circle-info"
                                            style="cursor: pointer;"></i></a>
                                </div>
                            </div>

                            







                        </div>
                    </div>
                </div>
            </div>
        <?php elseif(session('user_type') == 2): ?>
            <div class="content flex-grow-1 p-3">
                <div class="container">
                    <div class="card-body">

                        <div class="card-container">

                            <?php if(session('facility_type') == 1 ||
                                    session('facility_type') == 2 ||
                                    session('facility_type') == 3 ||
                                    session('facility_type') == 4): ?>
                                <div class="card">
                                    <div class="card-header" style="text-align: center;">
                                        <a href="<?php echo e(url('doctors')); ?>">
                                            <i class="fa-solid fa-user-doctor"
                                                style="font-size: 300%;color: #31bfa6; cursor: pointer;"></i>
                                        </a>
                                        <div class="card-actions">


                                        </div>
                                    </div>

                                    <div class="dd">
                                        <h5 class="card-title"><i class="fa-solid fa-hashtag"></i><?php echo e($counts['doctors']); ?>

                                        </h5>
                                        <a title="doctors"><i class="fa-solid fa-circle-info"
                                                style="cursor: pointer;"></i></a>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header" style="text-align: center;">
                                        <i class="fa-regular fa-calendar-check"
                                            style="font-size: 300%;color: #3163bf; cursor: pointer;"></i>

                                        <div class="card-actions">


                                        </div>
                                    </div>

                                    <div class="dd">
                                        <h5 class="card-title"><i
                                                class="fa-solid fa-hashtag"></i><?php echo e($counts['appointments']); ?>

                                        </h5>
                                        <a title="appointments"><i class="fa-solid fa-circle-info"
                                                style="cursor: pointer;"></i></a>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-header" style="text-align: center;">
                                        <a href="<?php echo e(url('rooms/')); ?>">
                                            <i class="fa-solid fa-door-closed"
                                                style="font-size: 300%;color: #ad652f; cursor: pointer;"></i>
                                        </a>
                                        <div class="card-actions">


                                        </div>
                                    </div>

                                    <div class="dd">
                                        <h5 class="card-title"><i class="fa-solid fa-hashtag"><?php echo e($counts['rooms']); ?></i>
                                        </h5>
                                        <a title="rooms"><i class="fa-solid fa-circle-info"
                                                style="cursor: pointer;"></i></a>
                                    </div>
                                </div>
                                
                            <?php endif; ?>


                            <div class="card">
                                <div class="card-header" style="text-align: center;">

                                    <i class="fa-solid fa-briefcase"
                                        style="font-size: 300%;color: #3163bf; cursor: pointer;"></i>

                                    <div class="card-actions">


                                    </div>
                                </div>

                                <div class="dd">
                                    <h5 class="card-title"><i class="fa-solid fa-hashtag"></i><?php echo e($counts['employees']); ?>

                                    </h5>
                                    <a title="employees"><i class="fa-solid fa-circle-info"
                                            style="cursor: pointer;"></i></a>
                                </div>
                            </div>

                            

                            <div class="card">
                                <div class="card-header" style="text-align: center;">

                                    <i class="fa-solid fa-money-bill-transfer"
                                        style="font-size: 300%;color: #198754; cursor: pointer;"></i>
                                    <div class="card-actions">


                                    </div>
                                </div>

                                <div class="dd">
                                    <h5 class="card-title"><i class="fa-solid fa-hashtag"></i>20 </h5>
                                    <a title="money trans"><i class="fa-solid fa-circle-info"
                                            style="cursor: pointer;"></i></a>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" style="text-align: center;">
                                    <!-- <img src="<?php echo e(asset('storage/images/calendar.png')); ?>" alt="Profile Picture" class="card-img"> -->
                                    <!-- <i class="fa-regular fa-calendar-check" style="font-size: 300%;"></i> -->
                                    <i class="fa-solid fa-box-open"
                                        style="font-size: 300%;color: #6d5a21; cursor: pointer;"></i>

                                    <div class="card-actions">


                                    </div>
                                </div>

                                <div class="dd">
                                    <h5 class="card-title"><i class="fa-solid fa-hashtag"></i><?php echo e($counts['stock']); ?>

                                    </h5>
                                    <a title="stock"><i class="fa-solid fa-circle-info"
                                            style="cursor: pointer;"></i></a>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header" style="text-align: center;">

                                    <i class="fa-solid fa-cart-shopping"
                                        style="font-size: 300%;color: #212529; cursor: pointer;"></i>

                                    <div class="card-actions">


                                    </div>
                                </div>
                                <div class="dd">
                                    <h5 class="card-title"><i class="fa-solid fa-hashtag"></i><?php echo e($counts['cart']); ?> </h5>
                                    <a title="orders"><i class="fa-solid fa-circle-info"
                                            style="cursor: pointer;"></i></a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>



    </div>

    <div class="d-flex" style="margin-top: 5%;">




        <div class="card" style="width: 30%; margin: auto;">

            <div id="carouselExampleSlidesOnly1" class="carousel slide c" data-bs-ride="carousel"
                data-bs-interval="2000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?php echo e(asset('storage/images/kk.webp')); ?>" class="d-block w-100" alt="Slide 1">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo e(asset('storage/images/x.webp')); ?>" class="d-block w-100" alt="Slide 2">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo e(asset('storage/images/a.webp')); ?>" class="d-block w-100" alt="Slide 3">
                    </div>
                </div>
            </div>
        </div>



        <div class="card" style="width: 30%; margin: auto;">

            <div id="carouselExampleSlidesOnly2" class="carousel slide c" data-bs-ride="carousel"
                data-bs-interval="2000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?php echo e(asset('storage/images/kk.webp')); ?>" class="d-block w-100" alt="Slide 1">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo e(asset('storage/images/x.webp')); ?>" class="d-block w-100" alt="Slide 2">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo e(asset('storage/images/a.webp')); ?>" class="d-block w-100" alt="Slide 3">
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="width: 30%; margin: auto;">
            <!-- <div class="card-header" style="text-align: center;">
                                                    <i class="fa-solid fa-calendar-check" style="font-size: 300%; color: #3163bf;"></i>
                                                </div> -->
            <div id="carouselExampleSlidesOnly3" class="carousel slide c" data-bs-ride="carousel"
                data-bs-interval="2000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?php echo e(asset('storage/images/kk.webp')); ?>" class="d-block w-100" alt="Slide 1">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo e(asset('storage/images/x.webp')); ?>" class="d-block w-100" alt="Slide 2">
                    </div>
                    <div class="carousel-item">
                        <img src="<?php echo e(asset('storage/images/a.webp')); ?>" class="d-block w-100" alt="Slide 3">
                    </div>
                </div>
            </div>
        </div>


    </div>


    <style>
        .d-flex2 {
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            width: 100%;
        }
    </style>


    <script>
        $(document).ready(function() {
            handleDeleteConfirmation('.trash_it', 'Do you want to Trash this item?', 'Trash');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hospitals.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sb\appointment\resources\views/home.blade.php ENDPATH**/ ?>