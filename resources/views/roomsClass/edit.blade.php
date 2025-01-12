@extends('hospitals.layout')
@section('content')


    <style>
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
    </style>

    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif


    <div class="card" style="    margin: 20px auto;width: 100%;">
        <div class="card-header">Create New room</div>
        <div class="card-body">

            <form action="{{ url('roomsClass', $roomsClass->id) }}" enctype="multipart/form-data" method="post" dir="rtl"
                style="display: flex;flex-direction: column;align-items: center;">
                {!! csrf_field() !!}
                @method('PUT')
                <input type="file" name="profile_pic" value="default_profile.png" id="profile_pic"
                    style="display: none;">

                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                    src="{{ asset('storage/images/default_profile.png') }}" name="first_name" value=""
                    class="form-control" disabled>



                <script>
                    $(document).ready(function() {
                        $('#clickableImage').on('click', function() {
                            $('#profile_pic').click();
                        });

                        $('#profile_pic').on('change', function(event) {
                            if (event.target.files && event.target.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    $('#clickableImage').attr('src', e.target.result);
                                }
                                reader.readAsDataURL(event.target.files[0]);
                            }
                        });
                    });
                </script>


                <div class="frm">


                    <div class="form-row">
                        <label>الدرجة</label>
                        <input type="text" value="{{ $roomsClass->roomsClass_name }}" name="roomsClass_name" id="room_class"
                            class="form-control">
                    </div>



                    <div class="form-row">
                        <label>عدد المرافقين</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button" id="decrease_companion">-</button>
                            </div>
                            <input type="text" value="{{ $roomsClass->number_companions }}" name="number_companions"
                                id="number_companions" class="form-control">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="increase_companion">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <label>عدد الاسرة</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button" id="decrease_bed">-</button>
                            </div>
                            <input class="form-control" value="{{ $roomsClass->number_beds }}" type="text" name="number_beds"
                                id="room_num" />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="increase_bed">+</button>
                            </div>
                        </div>
                    </div>

                    
                    <div class="form-row">
                        <label> السعر</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button" id="decrease_price">-</button>
                            </div>
                            <input class="form-control" value="{{ $roomsClass->price_day }}" type="text" name="price_day"
                                id="price_day" />
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="increase_price">+</button>
                            </div>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function() {
                            // Companion counter
                            $('#increase_companion').click(function() {
                                var number = parseInt($('#number_companions').val());
                                $('#number_companions').val(number + 1);
                            });

                            $('#decrease_companion').click(function() {
                                var number = parseInt($('#number_companions').val());
                                if (number > 0) {
                                    $('#number_companions').val(number - 1);
                                }
                            });

                            // Bed counter
                            $('#increase_bed').click(function() {
                                var number = parseInt($('#room_num').val());
                                $('#room_num').val(number + 1);
                            });

                            $('#decrease_bed').click(function() {
                                var number = parseInt($('#room_num').val());
                                if (number > 0) {
                                    $('#room_num').val(number - 1);
                                }
                            });

                            // price counter
                            $('#increase_price').click(function() {
                                var number = parseInt($('#price_day').val());
                                $('#price_day').val(number + 1);
                            });

                            $('#decrease_price').click(function() {
                                var number = parseInt($('#price_day').val());
                                if (number > 0) {
                                    $('#price_day').val(number - 1);
                                }
                            });
                        });
                    </script>


                    <div class="form-row">
                        <div class="wifi">
                            <label for="wifi_enabled">
                                <div class="card-text no-internet {{ $roomsClass->wifi == 1 ? 'active' : '' }} form-control" data-value="0" name="wifi">
                                    <i class="fa-solid fa-wifi"></i>
                                    <input type="hidden" name="wifi" id="wifi_enabled" value="0">
                                </div>
                            </label>
                        </div>
                    </div>

                    <style>
                        .wifi {
                            border-radius: 5px;
                            padding: 2%;
                            border: 1px solid black;
                            text-align: center;
                        }

                        .no-internet {
                            position: relative;
                            display: inline-block;
                            cursor: pointer;
                        }

                        .no-internet::before {
                            content: "";
                            position: absolute;
                            top: 50%;
                            left: 0;
                            right: 0;
                            height: 3px;
                            background-color: black;
                            transform: rotate(-45deg);
                        }

                        /* Class to change color dynamically */
                        .no-internet.active::before {
                            background-color: transparent;
                        }
                    </style>

                    <script>
                        $(document).ready(function() {
                            $('.no-internet').click(function() {
                                $(this).toggleClass('active');
                                var currentValue = $(this).hasClass('active') ? 1 : 0;
                                $(this).attr('data-value', currentValue); // Update the data-value attribute
                                $('#wifi_enabled').val(currentValue); // Update the hidden input value
                            });
                        });
                    </script>













                </div>


                <input type="submit" value="update" class="btn btn-success" style="margin-top: 2%;"></br>
            </form>

        </div>
    </div>

    <style>
        .frm {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-around;
            direction: rtl;
        }

        .form-row {
            width: 30%;
            margin-bottom: 15px;
        }
    </style>

@stop
