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



    <div class="card" style="    margin: 20px auto;
    width: 69%;">
        <div class="card-header">Create New hospital</div>
        <div class="card-body">

            <form action="{{ url('appointments') }}" method="post">
                {!! csrf_field() !!}


                <div class="form-row">
                    <label>Name</label></br>
                    <input type="text" name="appointment_name" id="name" class="form-control"></br>
                </div>


                <div class="form-row">
                    <label>Address</label></br>
                    <input type="text" name="appointment_address" id="address" class="form-control">
                </div>

                <div class="form-row">
                    <label>Mobile</label>
                    <input type="text" name="mobile" id="mobile" class="form-control">
                </div>

                <div class="form-row">
                    <label>number of room</label>
                    <input type="text" name="room_num" id="room_num" class="form-control">
                </div>

                <input type="submit" value="Save" class="btn btn-success"></br>
            </form>

        </div>
    </div>

@stop
