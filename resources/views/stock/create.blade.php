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
        <div class="card-header" style="    direction: rtl;">اضافة منتج </div>
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


            <form action="{{ url('stock') }}"  method="post" enctype="multipart/form-data">

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

                <div class="frm">



                    <div class="form-row">
                        <label> product</label>
                        <input type="text" name="product_name" id="product_name" class="form-control">
                    </div>

                    <div class="form-row">
                        <label> qty</label>
                        <input type="text" name="qty" id="qty" class="form-control">
                    </div>


                    <div class="form-row">
                        <label> price</label>
                        <input type="text" name="price" id="price" class="form-control">
                    </div>




                    <input type="hidden" name="facility_id" id="facility_id" value="{{ session('facility_id') }}" class="form-control">


                    <div class="form-row">
                        <label>category</label>
                        <select name="category_id" id="category_id"  class="form-control">
                            <option value="0">الرجاء الاختيار</option>
                            @foreach ($categories as $cate)
                            <option value="{{ $cate->id }}">{{ $cate->category_name }}</option>
                        @endforeach
                
                        </select>
                    </div>




                    <div class="form-row">
                        <label>note</label>
                        <textarea name="note" id="note" class="form-control"></textarea>

                    </div>


                    <div class="form-row">
                        <label> expire date</label>
                        <input type="date" name="exp_date" id="exp_date" class="form-control">
                    </div>
                    
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
