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

    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif

    <div class="card" style="margin: 20px auto; width: 100%;">
        <div class="card-header">Create New Room</div>
        <div class="card-body">
            <form action="{{ url('rooms_type') }}" method="POST" enctype="multipart/form-data" dir="rtl"
                style="display: flex; flex-direction: column; align-items: center;">
                {!! csrf_field() !!}

                <input type="file" name="profile_pic" id="profile_pic" style="display: none;">
                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                    src="{{ asset('storage/images/default_profile.png') }}" alt="Profile Picture">

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
                        <label for="room_type_name">النوع</label>
                        <input type="text" name="room_type_name" id="room_type_name" class="form-control" required>
                    </div>

                    <input type="hidden" name="facility_id" id="facility_id" value="{{ session('facility_id') }}">
                </div>

                <input type="submit" value="Save" class="btn btn-success" style="margin-top: 2%;">
            </form>
        </div>
    </div>
@stop
