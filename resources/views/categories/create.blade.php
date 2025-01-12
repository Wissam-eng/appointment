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

    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="card" style="    margin: 20px auto; width: 69%;">
        <div class="card-header" style="    direction: rtl;">اضافة فئة </div>
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


            <form action="{{ url('categories') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}


                <input type="file" name="img" value="default_profile.png" id="img" style="display: none;">
                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;" src="{{ asset('storage/images/default_profile.png') }}" name="first_name" value="" class="form-control" disabled>



                <script>
                    $(document).ready(function() {
                        $('#clickableImage').on('click', function() {
                            $('#img').click();
                        });

                        $('#img').on('change', function(event) {
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
                        <label> الفئة</label>
                        <input type="text" name="category_name" id="category_name" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>النوع</label>
                        <select name="category_type" id="category_type" class="form-control">
                            <option value="0">الرجاء الاختيار</option>
                            <option value="1">طبي</option>
                            <option value="2">انتاجي</option>
                        </select>
                    </div>




                    <input type="hidden" name="facility_id" value="{{ auth()->user()->facility_id }}">





                    <script>
                        function setDateToToday(elementId) {
                            const element = document.getElementById(elementId);
                            if (element) {
                                element.value = new Date().toISOString().split('T')[0];
                            }
                        }
                        setDateToToday('join_date');
                    </script>
                    <br>
                </div>
                <div style="display: flex;justify-content:center;margin-top:2%">
                    <input type="submit" value="حفظ" class="btn btn-success">
                </div>
            </form>



        </div>
    </div>

@stop
