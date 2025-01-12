@extends('hospitals.layout')
@section('content')


    <style>
        form {
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
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
    </style>



    <div class="card" style="    margin: 20px auto;
    width: 69%;">
        <div class="card-header">Create New hospital</div>
        <div class="card-body">

            <form action="{{ url('roomsClass') }}" method="post">
                {!! csrf_field() !!}

                <input type="file" name="profile_pic" value="default_profile.png" id="profile_pic" style="display: none;">

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



                <div class="form-row">
                    <label>roomsClass</label></br>
                    <input type="text" name="roomsClass_name" id="roomsClass_name" class="form-control"></br>
                </div>


                <div class="form-row">
                    <label>السعر يوميا</label></br>
                    <input type="text" name="price_day" id="price_day" class="form-control">
                </div>

                <div class="form-row">
                    <label>عدد المرافقين</label>
                    <input type="text" name="number_companions" id="number_companions" class="form-control">
                </div>

                <div class="form-row">
                    <label>عدد الاسرة</label>
                    <input type="text" name="number_beds" id="number_beds" class="form-control">
                </div>
                
                <input type="hidden" name="facility_id" id="facility_id" value="{{ session('facility_id') }}" class="form-control">

                <div class="form-row">
                    <label for="wifi">خدمة الانترنت </label><br>
                    <input type="checkbox" name="wifi" id="wifi" class="form-check-input">
                </div><br>
                
                <script>
                    $('#wifi').on('change', function(event) {
                        var wifiCheckbox = $('#wifi');
                        $('input[name="wifi_hidden"]').remove();
                        var hiddenWifiInput = $('<input>').attr({
                            type: 'hidden',
                            name: 'wifi_hidden',
                            value: wifiCheckbox.is(':checked') ? 1 : 0
                        });
                        $('#myForm').append(hiddenWifiInput);
                        console.log('WiFi checkbox value: ' + hiddenWifiInput.val());
                        wifiCheckbox.val(hiddenWifiInput.val());
                    });
                </script>
                


                <input type="submit" value="Save" class="btn btn-success"></br>
            </form>

        </div>
    </div>

@stop
