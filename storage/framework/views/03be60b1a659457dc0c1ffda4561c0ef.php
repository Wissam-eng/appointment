<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hospitals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/venobox@2.0.7/dist/venobox.min.css" />

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/venobox@2.0.7/dist/venobox.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#work_days').select2({
                placeholder: "الرجاء الاختيار",
                allowClear: true
            });
        });
    </script>
</head>

<style>
    /* size of screen mobile */
    @media only screen and (max-width: 700px) {
        .sidebar {
            width: 30% !important;
        }
    }
</style>



<body>


    <div class="ss" style="    display: flex;">

        <div class="sidebar bg-gradient-primary  p-3 text-white"
            style="width: 8%;position: sticky;top: 0px;height: 800px;">

            <a href="<?php echo e(url('/home')); ?>" class="btn btn-primary w-100 mb-3" style="background-color: #07459f;">
                <i class="fa fa-home"></i>
            </a>


            <ul class="nav flex-column">



                <?php if(session('user_type') == 1): ?>
                    <!---------------------------------------------------------------------------------------------------------------------->


                    <li class="nav-item dropdown">
                        <a class="nav-link text-white dropdown-toggle" id="profileDropdown" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-user"></i>
                        </a>
                    </li>

                    <li class="actions">
                        <a href="<?php echo e(url('/profile/create')); ?>" title="Add New Student" id="Addprofile" class="down">
                            <i class="fa-solid fa-plus"></i></a>

                        <a href="<?php echo e(url('/profile')); ?>" class=" text-white down" id="Trashprofile">
                            <i class="fa-solid fa-user-doctor"></i>
                        </a>

                        <a href="<?php echo e(url('/profile/trash')); ?>" class="down" id="Deleteprofile" title="Add New Student">
                            <i class="fa-solid fa-trash "></i>
                        </a>



                    </li>
                    <!---------------------------------------------------------------------------------------------------------------------->








                    <!-- facility Section -->
                    <li class="nav-item dropdown">
                        <a class="nav-link text-white dropdown-toggle" id="facilityDropdown" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-building"></i>
                        </a>
                    </li>
                    <li class="actions">
                        <a href="<?php echo e(url('/facilities/create')); ?>" title="Add New Hospital" id="Addfacility"
                            class="down">
                            <i class="fa-regular fa-square-plus"></i>
                        </a>
                        <a href="<?php echo e(url('/facilities/')); ?>" class="text-white down" id="Deletefacility">
                            <i class="fa-regular fa-building"></i>
                        </a>
                        <a href="<?php echo e(url('facilities.trash')); ?>" class="down" id="Trashfacility"
                            title="Trash Hospitals">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </li>

                    <!----- clientAdvertisements Section -->
                    <li class="nav-item dropdown">
                        <a class="nav-link text-white dropdown-toggle" id="clientAdvertisementsDropdown" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fa-brands fa-buysellads"></i>
                        </a>
                    </li>

                    <li class="actions">
                        <a href="<?php echo e(url('/clientAdvertisements/create')); ?>" title="Add New Student"
                            id="AddclientAdvertisements" class="down">
                            <i class="fa-solid fa-plus"></i></a>

                        <a href="<?php echo e(url('/clientAdvertisements')); ?>" class=" text-white down"
                            id="TrashclientAdvertisements">
                            <i class="fa-brands fa-buysellads"></i>
                        </a>

                        <a href="<?php echo e(url('/clientAdvertisements/trash')); ?>" class="down"
                            id="DeleteclientAdvertisements" title="Add New Student">
                            <i class="fa-solid fa-trash "></i>
                        </a>



                    </li>
                    <!---------------------------------------------------------------------------------------------------------------------->
                <?php elseif(session('user_type') == 2): ?>
                    <li class="nav-item dropdown">
                        <a href="<?php echo e(url('/profile.myprofile/' . Auth::user()->id)); ?>"
                            class="nav-link text-white dropdown-toggle" id="profileDropdown" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-user"></i>
                        </a>
                    </li>



                    <?php if(session('facility_type') == 1): ?>
                        <!-- Hospital Section -->
                        <li class="nav-item dropdown">
                            <a href="<?php echo e(url('/facilities.hospitals')); ?>" class="nav-link text-white dropdown-toggle"
                                id="hospitalDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-square-h"></i>
                            </a>
                        </li>
                        



                        <!-- analysis Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="analysisDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">

                                <i class="fa-solid fa-dna"></i>
                            </a>
                        </li>

                        <li class="actions">
                            <a href="<?php echo e(url('/analysis/create')); ?>" title="Add New specialization" id="Addanalysis"
                                class="down">
                                <i class="fa-solid fa-plus"></i>
                            </a>

                            <a href="<?php echo e(url('/analysis')); ?>" class="text-white down" id="Trashanalysis">

                                <i class="fa-solid fa-dna"></i>
                            </a>

                            <a href="<?php echo e(url('/analysis/trash')); ?>" class="down" id="Deleteanalysis"
                                title="Trash Rooms">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>


                        <!-- operations Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="operationsDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">

                                <i class="fa-solid fa-heart-pulse"></i>
                            </a>
                        </li>

                        <li class="actions">
                            <a href="<?php echo e(url('/operations/create')); ?>" title="Add New specialization"
                                id="Addoperations" class="down">
                                <i class="fa-solid fa-plus"></i>
                            </a>

                            <a href="<?php echo e(url('/operations')); ?>" class="text-white down" id="Trashoperations">

                                <i class="fa-solid fa-heart-pulse"></i>
                            </a>

                            <a href="<?php echo e(url('/operations/trash')); ?>" class="down" id="Deleteoperations"
                                title="Trash Rooms">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>
                    <?php elseif(session('facility_type') == 2 || session('facility_type') == 3): ?>
                        <!-- Clinic Section -->
                        <li class="nav-item dropdown">
                            <a href="<?php echo e(url('/facilities.clinics')); ?>" class="nav-link text-white dropdown-toggle"
                                id="clinicDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-c"></i>
                            </a>
                        </li>
                    <?php elseif(session('facility_type') == 4): ?>
                        <!-- Pharmacy Section -->
                        <li class="nav-item dropdown">
                            <a href="<?php echo e(url('/pharmacys')); ?>" class="nav-link text-white dropdown-toggle"
                                id="pharmacyDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-staff-snake"></i>
                            </a>
                        </li>
                        
                    <?php elseif(session('facility_type') == 5): ?>
                        <li class="nav-item dropdown">
                            <a href="<?php echo e(url('/facilities.company')); ?>" class="nav-link text-white dropdown-toggle"
                                id="pharmacyDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-shop"></i>
                            </a>
                        </li>
                        <!-- categories Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="categoriesDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">

                                <i class="fa-solid fa-puzzle-piece"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/categories/create')); ?>" title="Add New specialization"
                                id="Addcategories" class="down">
                                <i class="fa-solid fa-plus"></i></a>
                            <a href="<?php echo e(url('/categories')); ?>" class="text-white down" id="Trashcategories">

                                <i class="fa-solid fa-puzzle-piece"></i>
                            </a>
                            <a href="<?php echo e(url('/categories/trash')); ?>" class="down" id="Deletecategories"
                                title="Trash Rooms">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>


                        <!-- Products Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="productsDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-box-open"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/stock/create')); ?>" title="Add New Product" id="Addproducts"
                                class="down">
                                <i class="fa-solid fa-plus"></i></a>
                            <a href="<?php echo e(url('/stock')); ?>" class="text-white down" id="Trashproducts">
                                <i class="fa-solid fa-box-open"></i>
                            </a>
                            <a href="<?php echo e(url('/stock/trash')); ?>" class="down" id="Deleteproducts"
                                title="Trash Products">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>

                        <!-- Orders Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="ordersDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                        </li>
                        <li class="actions">
                            
                            <a href="<?php echo e(url('/cart')); ?>" class="text-white down" id="Trashorders">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                            <a href="<?php echo e(url('/cart/trash')); ?>" class="down" id="Deleteorders"
                                title="Trash Orders">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>

                        <!-- Employees Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="employeesDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-briefcase"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/employees/create')); ?>" title="Add New Employee" id="Addemployees"
                                class="down">
                                <i class="fa-solid fa-plus"></i></a>
                            <a href="<?php echo e(url('/employees')); ?>" class="text-white down" id="Trashemployees">
                                <i class="fa-solid fa-briefcase"></i>
                            </a>
                            <a href="<?php echo e(url('/employees/trash')); ?>" class="down" id="Deleteemployees"
                                title="Trash Employees">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>


                        <!----- FQA Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="FQADropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-question"></i>
                            </a>
                        </li>

                        <li class="actions">
                            <a href="<?php echo e(url('/FQA/create')); ?>" title="Add New Student" id="AddFQA"
                                class="down">
                                <i class="fa-solid fa-plus"></i></a>

                            <a href="<?php echo e(url('/FQA')); ?>" class=" text-white down" id="TrashFQA">
                                <i class="fa-solid fa-question"></i>
                            </a>

                            <a href="<?php echo e(url('/FQA/trash')); ?>" class="down" id="DeleteFQA"
                                title="Add New Student">
                                <i class="fa-solid fa-trash "></i>
                            </a>



                        </li>
                        <!---------------------------------------------------------------------------------------------------------------------->


                        <!----- review Section -->
                        <li class="nav-item dropdown">
                            <a href="<?php echo e(url('/review')); ?>" class="nav-link text-white dropdown-toggle"
                                id="starDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-star"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(session('facility_type') == 1 ||
                            session('facility_type') == 2 ||
                            session('facility_type') == 3 ||
                            session('facility_type') == 4): ?>
                        <!-- categories Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="categoriesDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">

                                <i class="fa-solid fa-puzzle-piece"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/categories/create')); ?>" title="Add New specialization"
                                id="Addcategories" class="down">
                                <i class="fa-solid fa-plus"></i></a>
                            <a href="<?php echo e(url('/categories')); ?>" class="text-white down" id="Trashcategories">

                                <i class="fa-solid fa-puzzle-piece"></i>
                            </a>
                            <a href="<?php echo e(url('/categories/trash')); ?>" class="down" id="Deletecategories"
                                title="Trash Rooms">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>

                        <!-- specialization Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="specializationsDropdown"
                                role="button" data-toggle="dropdown" aria-expanded="false">

                                <i class="fa-solid fa-s"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/specializations/create')); ?>" title="Add New specialization"
                                id="Addspecialization" class="down">
                                <i class="fa-solid fa-plus"></i></a>
                            <a href="<?php echo e(url('/specializations')); ?>" class="text-white down"
                                id="Trashspecialization">

                                <i class="fa-solid fa-s"></i>
                            </a>
                            <a href="<?php echo e(url('/specializations/trash')); ?>" class="down" id="Deletespecialization"
                                title="Trash Rooms">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>

                        <!-- Doctors Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="doctorsDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user-doctor"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/doctors/create')); ?>" title="Add New Doctor" id="AddDoctor"
                                class="down">
                                <i class="fa-regular fa-square-plus"></i></a>
                            <a href="<?php echo e(url('/doctors')); ?>" class="text-white down" id="TrashDoctor">
                                <i class="fa-solid fa-user-doctor"></i>
                            </a>
                            <a href="<?php echo e(url('/doctors/trash')); ?>" class="down" id="DeleteDoctor"
                                title="Trash Doctors">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>

                        <!-- injured Section -->
                        

                        <!-- Rooms Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="roomsDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-door-closed"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/rooms/create')); ?>" title="Add New Room" id="Addrooms"
                                class="down">
                                <i class="fa-solid fa-plus"></i></a>
                            <a href="<?php echo e(url('/rooms')); ?>" class="text-white down" id="Trashrooms">
                                <i class="fa-solid fa-door-closed"></i>
                            </a>
                            <a href="<?php echo e(url('/rooms/trash')); ?>" class="down" id="Deleterooms"
                                title="Trash Rooms">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>


                        <!-- room_types Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="room_typesDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-table-cells"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/rooms_type/create')); ?>" title="Add New Room" id="Addroom_types"
                                class="down">
                                <i class="fa-solid fa-plus"></i></a>
                            <a href="<?php echo e(url('/rooms_type')); ?>" class="text-white down" id="Trashroom_types">
                                <i class="fa-solid fa-table-cells"></i>
                            </a>

                        </li>

                        <!-- Rooms_class Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="roomsClassDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-crown"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/roomsClass/create')); ?>" title="Add New Room" id="AddroomsClass"
                                class="down">
                                <i class="fa-solid fa-plus"></i></a>
                            <a href="<?php echo e(url('/roomsClass')); ?>" class="text-white down" id="TrashroomsClass">
                                <i class="fa-solid fa-crown"></i>
                            </a>
                            <a href="<?php echo e(url('/roomsClass/trash')); ?>" class="down" id="DeleteroomsClass"
                                title="Trash Rooms">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>


                        <!-- appointments Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="visitorsDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-calendar-check"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/appointments/create')); ?>" title="Add New Visitor" id="Addvisitors"
                                class="down">
                                <i class="fa-solid fa-plus"></i></a>
                            <a href="<?php echo e(url('/appointments')); ?>" class="text-white down" id="Trashvisitors">
                                <i class="fa-regular fa-calendar-check"></i>
                            </a>
                            
                        </li>

                        <!-- Transactions Section -->
                        

                        <!-- Products Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="productsDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-box-open"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/stock/create')); ?>" title="Add New Product" id="Addproducts"
                                class="down">
                                <i class="fa-solid fa-plus"></i></a>
                            <a href="<?php echo e(url('/stock')); ?>" class="text-white down" id="Trashproducts">
                                <i class="fa-solid fa-box-open"></i>
                            </a>
                            <a href="<?php echo e(url('/stock/trash')); ?>" class="down" id="Deleteproducts"
                                title="Trash Products">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>

                        <!-- Orders Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="ordersDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                        </li>
                        <li class="actions">
                            
                            <a href="<?php echo e(url('/cart')); ?>" class="text-white down" id="Trashorders">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                            <a href="<?php echo e(url('/cart/trash')); ?>" class="down" id="Deleteorders"
                                title="Trash Orders">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>

                        <!-- Employees Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="employeesDropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-briefcase"></i>
                            </a>
                        </li>
                        <li class="actions">
                            <a href="<?php echo e(url('/employees/create')); ?>" title="Add New Employee" id="Addemployees"
                                class="down">
                                <i class="fa-solid fa-plus"></i></a>
                            <a href="<?php echo e(url('/employees')); ?>" class="text-white down" id="Trashemployees">
                                <i class="fa-solid fa-briefcase"></i>
                            </a>
                            <a href="<?php echo e(url('/employees/trash')); ?>" class="down" id="Deleteemployees"
                                title="Trash Employees">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </li>


                        <!----- FQA Section -->
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white dropdown-toggle" id="FQADropdown" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-question"></i>
                            </a>
                        </li>

                        <li class="actions">
                            <a href="<?php echo e(url('/FQA/create')); ?>" title="Add New Student" id="AddFQA"
                                class="down">
                                <i class="fa-solid fa-plus"></i></a>

                            <a href="<?php echo e(url('/FQA')); ?>" class=" text-white down" id="TrashFQA">
                                <i class="fa-solid fa-question"></i>
                            </a>

                            <a href="<?php echo e(url('/FQA/trash')); ?>" class="down" id="DeleteFQA"
                                title="Add New Student">
                                <i class="fa-solid fa-trash "></i>
                            </a>



                        </li>
                        <!---------------------------------------------------------------------------------------------------------------------->


                        <!----- review Section -->
                        <li class="nav-item dropdown">
                            <a href="<?php echo e(url('/review')); ?>" class="nav-link text-white dropdown-toggle"
                                id="starDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-star"></i>
                            </a>
                        </li>


                        <!---------------------------------------------------------------------------------------------------------------------->
                    <?php endif; ?>



                <?php endif; ?>


















                <!---------------------------------------------------- Charts Section------------------------------------------------------------------>

                

                <!---------------------------------------------------------------------------------------------------------------------->
                
                <!---------------------------------------------------------------------------------------------------------------------->





                <li class="nav-item dropdown">
                    <!-- Logout link with JavaScript submission of the form -->
                    <a href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault(); 
                                document.getElementById('logout-form').submit();"
                        class="nav-link text-white">
                        <i class="fa fa-sign-out-alt"></i>

                    </a>





                    <!-- Hidden form to handle the POST request -->
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </li>






            </ul>


        </div>





        <div class="content">



            <?php echo $__env->yieldContent('content'); ?>

        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('.search-icon').on('click', function() {
                $('.search-form').toggle();
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            function formatDateToISO(date) {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${year}-${month}-${day}`; // تنسيق yyyy-mm-dd
            }

            const today = new Date();
            const nextMonth = new Date(today);
            nextMonth.setMonth(nextMonth.getMonth() + 1);

            $(".currentDate").val(formatDateToISO(today)); // تاريخ اليوم
            $(".dateAfterOneMonth").val(formatDateToISO(nextMonth)); // تاريخ بعد شهر
        });









        function handleDeleteConfirmation(buttonClass, message, confirmButtonText) {
            $(document).on('click', buttonClass, function(e) {
                e.preventDefault();
                var formId = $(this).data('form-id');
                var form = $('#' + formId);

                Swal.fire({
                    title: 'Are you sure?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }
    </script>

    <style>
        li a {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {



            // For categories
            $('#room_typesDropdown').on('click', function() {
                $('#Addroom_types').toggle();
                $('#Deleteroom_types').toggle();
                $('#Trashroom_types').toggle();
            });


            // For categories
            $('#categoriesDropdown').on('click', function() {
                $('#Addcategories').toggle();
                $('#Deletecategories').toggle();
                $('#Trashcategories').toggle();
            });


            // For FQA
            $('#clientAdvertisementsDropdown').on('click', function() {
                $('#AddclientAdvertisements').toggle();
                $('#DeleteclientAdvertisements').toggle();
                $('#TrashclientAdvertisements').toggle();
            });


            $('#FQADropdown').on('click', function() {
                $('#AddFQA').toggle();
                $('#DeleteFQA').toggle();
                $('#TrashFQA').toggle();
            });


            // For facility
            $('#profileDropdown').on('click', function() {
                $('#Addprofile').toggle();
                $('#Deleteprofile').toggle();
                $('#Trashprofile').toggle();
            });


            $('#operationsDropdown').on('click', function() {
                $('#Addoperations').toggle();
                $('#Deleteoperations').toggle();
                $('#Trashoperations').toggle();
            });


            // For facility
            $('#facilityDropdown').on('click', function() {
                $('#Addfacility').toggle();
                $('#Deletefacility').toggle();
                $('#Trashfacility').toggle();
            });

            // For analysis
            $('#analysisDropdown').on('click', function() {
                $('#Addanalysis').toggle();
                $('#Deleteanalysis').toggle();
                $('#Trashanalysis').toggle();
            });
            // For doctors
            $('#doctorsDropdown').on('click', function() {
                $('#AddDoctor').toggle();
                $('#DeleteDoctor').toggle();
                $('#TrashDoctor').toggle();
            });
            // For specialization
            $('#specializationsDropdown').on('click', function() {
                $('#Addspecialization').toggle();
                $('#Deletespecialization').toggle();
                $('#Trashspecialization').toggle();
            });

            // For hospitals
            $('#hospitalDropdown').on('click', function() {
                $('#AddHospital').toggle();
                $('#DeleteHospital').toggle();
                $('#TrashHospital').toggle();
            });

            // For clinics
            $('#clinicDropdown').on('click', function() {
                $('#Addclinic').toggle();
                $('#Deleteclinic').toggle();
                $('#Trashclinic').toggle();
            });

            // For pharmacy
            $('#pharmacyDropdown').on('click', function() {
                $('#Addpharamacy').toggle();
                $('#Deletepharamacy').toggle();
                $('#Trashpharamacy').toggle();
            });

            // For rooms
            $('#roomsDropdown').on('click', function() {
                $('#Addrooms').toggle();
                $('#Deleterooms').toggle();
                $('#Trashrooms').toggle();
            });
            // For roomsClass
            $('#roomsClassDropdown').on('click', function() {
                $('#AddroomsClass').toggle();
                $('#DeleteroomsClass').toggle();
                $('#TrashroomsClass').toggle();
            });

            // For visitors
            $('#visitorsDropdown').on('click', function() {
                $('#Addvisitors').toggle();
                $('#Deletevisitors').toggle();
                $('#Trashvisitors').toggle();
            });

            // For transactions
            $('#transDropdown').on('click', function() {
                $('#Addtrans').toggle();
                $('#Deletetrans').toggle();
                $('#Trashtrans').toggle();
            });

            // For products
            $('#productsDropdown').on('click', function() {
                $('#Addproducts').toggle();
                $('#Deleteproducts').toggle();
                $('#Trashproducts').toggle();
            });

            // For orders
            $('#ordersDropdown').on('click', function() {
                $('#Addorders').toggle();
                $('#Deleteorders').toggle();
                $('#Trashorders').toggle();
            });

            // For employees
            $('#employeesDropdown').on('click', function() {
                $('#Addemployees').toggle();
                $('#Deleteemployees').toggle();
                $('#Trashemployees').toggle();
            });

            // For charts
            $('#chartsDropdown').on('click', function() {
                $('#Addcharts').toggle();
                $('#Deletecharts').toggle();
                $('#Trashcharts').toggle();
            });

            // For settings
            $('#settingsDropdown').on('click', function() {
                $('#Addsettings').toggle();
                $('#Deletesettings').toggle();
                $('#Trashsettings').toggle();
            });
        });



        new VenoBox({
            selector: '.my-image-links',
            numeration: true,
            infinigall: true,
            share: true,
            spinner: 'rotating-plane'
        });
    </script>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\sb\appointment\resources\views/hospitals/layout.blade.php ENDPATH**/ ?>