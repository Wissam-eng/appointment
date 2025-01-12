<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hospitals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>


<body>


    <div class="ss" style="    display: flex;">

        <div class="sidebar bg-gradient-primary vh-100 p-3 text-white" style="width: 8%;position: sticky;top: 0px;">

            <a href="{{ url('/home') }}" class="btn btn-primary w-100 mb-3" style="background-color: #07459f;">
                <i class="fa fa-home"></i>
            </a>
            <ul class="nav flex-column">
                <!-- Hospital Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="hospitalDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-square-h"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/hospitals/create') }}" title="Add New Hospital" id="AddHospital" class="down">
                        <i class="fa-regular fa-square-plus"></i></a>
                    <a href="{{ url('/hospitals/') }}" class="text-white down" id="DeleteHospital">
                        <i class="fa-solid fa-square-h"></i>
                    </a>
                    <a href="{{ url('/hospitals/trash') }}" class="down" id="TrashHospital" title="Trash Hospitals">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!-- Doctors Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="doctorsDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user-doctor"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/doctors/create') }}" title="Add New Doctor" id="AddDoctor" class="down">
                        <i class="fa-regular fa-square-plus"></i></a>
                    <a href="{{ url('/doctors') }}" class="text-white down" id="TrashDoctor">
                        <i class="fa-solid fa-user-doctor"></i>
                    </a>
                    <a href="{{ url('/doctors/trash') }}" class="down" id="DeleteDoctor" title="Trash Doctors">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!-- Clinic Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="clinicDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-c"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/clinics/create') }}" title="Add New Clinic" id="Addclinic" class="down">
                        <i class="fa-regular fa-square-plus"></i></a>
                    <a href="{{ url('/clinics') }}" class="text-white down" id="Trashclinic">
                        <i class="fa-solid fa-c"></i>
                    </a>
                    <a href="{{ url('/clinics/trash') }}" class="down" id="Deleteclinic" title="Trash Clinics">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!-- Pharmacy Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="pharmacyDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-staff-snake"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/pharmacy/create') }}" title="Add New Pharmacy" id="Addpharamacy" class="down">
                        <i class="fa-regular fa-square-plus"></i></a>
                    <a href="{{ url('/pharmacy') }}" class="text-white down" id="Trashpharamacy">
                        <i class="fa-solid fa-staff-snake"></i>
                    </a>
                    <a href="{{ url('/pharmacy/trash') }}" class="down" id="Deletepharamacy" title="Trash Pharmacy">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!-- Rooms Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="roomsDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-door-closed"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/rooms/create') }}" title="Add New Room" id="Addrooms" class="down">
                        <i class="fa-solid fa-plus"></i></a>
                    <a href="{{ url('/rooms') }}" class="text-white down" id="Trashrooms">
                        <i class="fa-solid fa-door-closed"></i>
                    </a>
                    <a href="{{ url('/rooms/trash') }}" class="down" id="Deleterooms" title="Trash Rooms">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!-- Rooms_class Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="roomsClassDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-crown"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/roomsClass/create') }}" title="Add New Room" id="AddroomsClass" class="down">
                        <i class="fa-solid fa-plus"></i></a>
                    <a href="{{ url('/roomsClass') }}" class="text-white down" id="TrashroomsClass">
                        <i class="fa-solid fa-crown"></i>
                    </a>
                    <a href="{{ url('/roomsClass/trash') }}" class="down" id="DeleteroomsClass" title="Trash Rooms">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>
                <!-- specialization Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="specializationsDropdown" role="button" data-toggle="dropdown" aria-expanded="false">

                        <i class="fa-solid fa-s"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/specializations/create') }}" title="Add New specialization" id="Addspecialization" class="down">
                        <i class="fa-solid fa-plus"></i></a>
                    <a href="{{ url('/specializations') }}" class="text-white down" id="Trashspecialization">

                        <i class="fa-solid fa-s"></i>
                    </a>
                    <a href="{{ url('/specializations/trash') }}" class="down" id="Deletespecialization" title="Trash Rooms">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!-- Visitors Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="visitorsDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-people-group"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/visitors/create') }}" title="Add New Visitor" id="Addvisitors" class="down">
                        <i class="fa-solid fa-plus"></i></a>
                    <a href="{{ url('/visitors') }}" class="text-white down" id="Trashvisitors">
                        <i class="fa-solid fa-people-group"></i>
                    </a>
                    <a href="{{ url('/visitors/trash') }}" class="down" id="Deletevisitors" title="Trash Visitors">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!-- Transactions Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="transDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/transactions/create') }}" title="Add New Transaction" id="Addtrans" class="down">
                        <i class="fa-solid fa-plus"></i></a>
                    <a href="{{ url('/transactions') }}" class="text-white down" id="Trashtrans">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                    </a>
                    <a href="{{ url('/transactions/trash') }}" class="down" id="Deletetrans" title="Trash Transactions">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!-- Products Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="productsDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-box-open"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/products/create') }}" title="Add New Product" id="Addproducts" class="down">
                        <i class="fa-solid fa-plus"></i></a>
                    <a href="{{ url('/products') }}" class="text-white down" id="Trashproducts">
                        <i class="fa-solid fa-box-open"></i>
                    </a>
                    <a href="{{ url('/products/trash') }}" class="down" id="Deleteproducts" title="Trash Products">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!-- Orders Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="ordersDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/orders/create') }}" title="Add New Order" id="Addorders" class="down">
                        <i class="fa-solid fa-plus"></i></a>
                    <a href="{{ url('/orders') }}" class="text-white down" id="Trashorders">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                    <a href="{{ url('/orders/trash') }}" class="down" id="Deleteorders" title="Trash Orders">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!-- Employees Section -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="employeesDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-briefcase"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/employees/create') }}" title="Add New Employee" id="Addemployees" class="down">
                        <i class="fa-solid fa-plus"></i></a>
                    <a href="{{ url('/employees') }}" class="text-white down" id="Trashemployees">
                        <i class="fa-solid fa-briefcase"></i>
                    </a>
                    <a href="{{ url('/employees/trash') }}" class="down" id="Deleteemployees" title="Trash Employees">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!---------------------------------------------------- Charts Section------------------------------------------------------------------>

                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="chartsDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-chart-bar"></i>
                    </a>
                </li>
                <li class="actions">
                    <a href="{{ url('/charts/create') }}" title="Add New Chart" id="Addcharts" class="down">
                        <i class="fa-solid fa-plus"></i></a>
                    <a href="{{ url('/charts') }}" class="text-white down" id="Trashcharts">
                        <i class="fa-solid fa-user-doctor"></i>
                    </a>
                    <a href="{{ url('/charts/trash') }}" class="down" id="Deletecharts" title="Trash Charts">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </li>

                <!---------------------------------------------------------------------------------------------------------------------->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="doctorsDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-layer-group"></i>
                    </a>
                </li>

                <li class="actions">
                    <a href="{{ url('/doctors/create') }}" title="Add New Student" id="AddDoctor" class="down">
                        <i class="fa-solid fa-plus"></i></a>

                    <a href="{{ url('/doctors') }}" class=" text-white down" id="TrashDoctor">
                        <i class="fa-solid fa-user-doctor"></i>
                    </a>

                    <a href="{{ url('/doctors/trash') }}" class="down" id="DeleteDoctor" title="Add New Student">
                        <i class="fa-solid fa-trash "></i>
                    </a>



                </li>
                <!---------------------------------------------------------------------------------------------------------------------->
                <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="doctorsDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-gear"></i>
                    </a>
                </li>

                <li class="actions">
                    <a href="{{ url('/doctors/create') }}" title="Add New Student" id="AddDoctor" class="down">
                        <i class="fa-solid fa-plus"></i></a>

                    <a href="{{ url('/doctors') }}" class=" text-white down" id="TrashDoctor">
                        <i class="fa-solid fa-user-doctor"></i>
                    </a>

                    <a href="{{ url('/doctors/trash') }}" class="down" id="DeleteDoctor" title="Add New Student">
                        <i class="fa-solid fa-trash "></i>
                    </a>



                </li>
                <!---------------------------------------------------------------------------------------------------------------------->
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link text-white dropdown-toggle" id="doctorsDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user-doctor"></i>
                    </a>
                </li>

                <li class="actions">
                    <a href="{{ url('/doctors/create') }}" title="Add New Student" id="AddDoctor" class="down">
                        <i class="fa-solid fa-plus"></i></a>

                    <a href="{{ url('/doctors') }}" class=" text-white down" id="TrashDoctor">
                        <i class="fa-solid fa-user-doctor"></i>
                    </a>

                    <a href="{{ url('/doctors/trash') }}" class="down" id="DeleteDoctor" title="Add New Student">
                        <i class="fa-solid fa-trash "></i>
                    </a>



                </li> -->
                <!---------------------------------------------------------------------------------------------------------------------->


                <li class="nav-item dropdown">
                    <a href="{{ url('/logout') }}" class="nav-link text-white " id="doctorsDropdown" role="button">
                        <i class="fa fa-sign-out-alt"></i>
                    </a>
                </li>





            </ul>


        </div>





        <div class="content">



            @yield('content')

        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('.search-icon').on('click', function() {
                $('.search-form').toggle();
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
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
    </script>

</body>

</html>