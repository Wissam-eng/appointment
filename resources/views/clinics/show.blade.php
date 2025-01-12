@extends('hospitals.layout')
@section('content')





    <nav class="navbar navbar-expand-lg bg-body-tertiary"
        style="    position: sticky;top: 0px;z-index: 33;    padding: 0px;        ">
        <div class="container-fluid" style="    padding: 0px;">


            <div class="collapse navbar-collapse" id="navbarSupportedContent"
                style="justify-content: space-around;;background-color:white;">
                <div class="icon">
                    @if ($facility_type == 3)
                        
                    <i class="fa-solid fa-cent-sign" style="font-size: 400%;    color: #3061bc;"></i>

                    @elseif ($facility_type == 2)

                    <i class="fa-solid fa-c" style="font-size: 400%;    color: #3061bc;"></i>
                    @elseif ($facility_type == 4)

                    <i class="fa-solid fa-staff-snake" style="font-size: 400%;    color: #3061bc;"></i>

                    @endif
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

        <div class="card">
            <div class="card-header" style="text-align: center;">
                <a href="{{ url('doctors') }}">
                    <i class="fa-solid fa-user-doctor" style="font-size: 300%;color: #31bfa6; cursor: pointer;"></i>
                </a>
                <div class="card-actions">


                </div>
            </div>

            <div class="dd">
                <h5 class="card-title"><i class="fa-solid fa-hashtag"></i>{{ $counts['doctors'] }}</h5>
                <a title="doctors"><i class="fa-solid fa-circle-info" style="cursor: pointer;"></i></a>
            </div>
        </div>

        <div class="card">
            <div class="card-header" style="text-align: center;">
                <i class="fa-regular fa-calendar-check" style="font-size: 300%;color: #3163bf; cursor: pointer;"></i>

                <div class="card-actions">


                </div>
            </div>

            <div class="dd">
                <h5 class="card-title"><i class="fa-solid fa-hashtag"></i>{{ $counts['appointments'] }} </h5>
                <a title="appointments"><i class="fa-solid fa-circle-info" style="cursor: pointer;"></i></a>
            </div>
        </div>


        <div class="card">
            <div class="card-header" style="text-align: center;">
                <a href="{{ url('rooms/') }}">
                    <i class="fa-solid fa-door-closed" style="font-size: 300%;color: #ad652f; cursor: pointer;"></i>
                </a>
                <div class="card-actions">


                </div>
            </div>

            <div class="dd">
                <h5 class="card-title"><i class="fa-solid fa-hashtag">{{  $counts['rooms'] }}</i> </h5>
                <a title="rooms"><i class="fa-solid fa-circle-info" style="cursor: pointer;"></i></a>
            </div>
        </div>


        <div class="card">
            <div class="card-header" style="text-align: center;">

                <i class="fa-solid fa-briefcase" style="font-size: 300%;color: #3163bf; cursor: pointer;"></i>

                <div class="card-actions">


                </div>
            </div>

            <div class="dd">
                <h5 class="card-title"><i class="fa-solid fa-hashtag"></i>{{  $counts['employees'] }} </h5>
                <a title="employees"><i class="fa-solid fa-circle-info" style="cursor: pointer;"></i></a>
            </div>
        </div>
{{-- 
        <div class="card">
            <div class="card-header" style="text-align: center;">

                <i class="fa-solid fa-user-injured" style="font-size: 300%;color: #3163bf; cursor: pointer;"></i>

                <div class="card-actions">


                </div>
            </div>

            <div class="dd">
                <h5 class="card-title"><i class="fa-solid fa-hashtag"></i>{{ $counts['patients'] }} </h5>
                <a title="patients"><i class="fa-solid fa-circle-info" style="cursor: pointer;"></i></a>
            </div>
        </div> --}}

        <div class="card">
            <div class="card-header" style="text-align: center;">

                <i class="fa-solid fa-money-bill-transfer" style="font-size: 300%;color: #198754; cursor: pointer;"></i>
                <div class="card-actions">


                </div>
            </div>

            <div class="dd">
                <h5 class="card-title"><i class="fa-solid fa-hashtag"></i>20 </h5>
                <a title="money trans"><i class="fa-solid fa-circle-info" style="cursor: pointer;"></i></a>
            </div>
        </div>

        <div class="card">
            <div class="card-header" style="text-align: center;">
                <!-- <img src="{{ asset('storage/images/calendar.png') }}" alt="Profile Picture" class="card-img"> -->
                <!-- <i class="fa-regular fa-calendar-check" style="font-size: 300%;"></i> -->
                <i class="fa-solid fa-box-open" style="font-size: 300%;color: #6d5a21; cursor: pointer;"></i>

                <div class="card-actions">


                </div>
            </div>

            <div class="dd">
                <h5 class="card-title"><i class="fa-solid fa-hashtag"></i>{{ $counts['stock'] }} </h5>
                <a title="stock"><i class="fa-solid fa-circle-info" style="cursor: pointer;"></i></a>
            </div>
        </div>


        <div class="card">
            <div class="card-header" style="text-align: center;">

                <i class="fa-solid fa-cart-shopping" style="font-size: 300%;color: #212529; cursor: pointer;"></i>

                <div class="card-actions">


                </div>
            </div>
            <div class="dd">
                <h5 class="card-title"><i class="fa-solid fa-hashtag"></i>{{ $counts['cart'] }} </h5>
                <a title="orders"><i class="fa-solid fa-circle-info" style="cursor: pointer;"></i></a>
            </div>
        </div>








    </div>






























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


    <script>
        $(document).ready(function() {
            handleDeleteConfirmation('.trash_it', 'Do you want to Trash this item?', 'Trash');
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

        .content {
            margin: 20px auto;
            width: 69%;
        }

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

        .card {
            height: 100px;
        }

        .d-flex2 {
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            width: 100%;
        }


        .d-flex {
            margin-top: 5%;
            display: flex !important;
            flex-wrap: wrap;
            align-content: center;
            justify-content: center;
            align-items: center;
        }
    </style>


@stop
