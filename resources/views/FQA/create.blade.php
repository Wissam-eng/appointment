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


    <div class="card" style="    margin: 20px auto; width: 69%;">
        <div class="card-header" style="    direction: rtl;">اضافة سؤال </div>
        <div class="card-body">

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
                }
            </style>


            <form action="{{ url('FQA') }}" method="post" enctype="multipart/form-data">

                {!! csrf_field() !!}




                <div class="frm">



                    <div class="form-row">
                        <label> question</label>
                        <input type="text" name="question" id="question" class="form-control">
                    </div>

                    <div class="form-row">
                        <label> answer</label>
                        <input type="text" name="answer" id="answer" class="form-control">
                    </div>

                    <input type="hidden" name="facility_id" id="facility_id" value="{{ session('facility_id') }}" class="form-control">

                    <br>
                </div>


                <div style="display: flex;justify-content:center;margin-top:2%">
                    <input type="submit" value="حفظ" class="btn btn-success">
                </div>
            </form>



        </div>
    </div>

@stop
