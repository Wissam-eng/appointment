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
        <div class="card-header" style="    direction: rtl;">اضافة طبيب </div>
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


            <form action="{{ url('profile') }}" class="frm" method="post" enctype="multipart/form-data">

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
                        <label>الاسم الأول</label>
                        <input type="text" name="first_name" id="first_name" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>الاسم الثاني</label>
                        <input type="text" name="second_name" id="second_name" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>الاسم الثالث</label>
                        <input type="text" name="third_name" id="third_name" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>الاسم الأخير</label>
                        <input type="text" name="last_name" id="last_name" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>تاريخ الميلاد</label>
                        <input type="date" name="date_birth" id="date_birth" class="form-control">
                    </div>






                    <div class="form-row">
                        <label>الموبايل</label>
                        <input type="number" name="mobile" id="mobile" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>العمر</label>
                        <input type="number" name="old" id="old" class="form-control">
                    </div>



                    <div class="form-row">
                        <label>الجنس</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="0">الرجاء الاختيار</option>
                            <option value="1">ذكر</option>
                            <option value="2">أنثى</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <label>الحالة الاجتماعية</label>
                        <select name="martial_status" id="martial_status" class="form-control">
                            <option value="0">الرجاء الاختيار</option>
                            <option value="1">أعزب</option>
                            <option value="2">متزوج</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <label>الجنسية</label>
                        <input type="text" name="nationality" id="nationality" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>الشهادة العلمية</label>
                        <input type="text" name="certification" id="certification" class="form-control">
                    </div>




                    <div class="form-row">
                        <label> user type</label>
                        <select name="user_type" id="user_type" class="form-control">
                            <option value="0">الرجاء الاختيار</option>
                            <option value="1">admin</option>
                            <option value="2">facility</option>
                        </select>
                    </div>


                    <script>
                        $('#user_type').on('change', function() {
                            var selectedValue = $(this).val();
                            if (selectedValue == 2) {
                                $('.facility_id').show();  // Show the row
                            } else {
                                $('.facility_id').hide();  // Hide the row
                            }
                        });
                    </script>
                    
                    <div class="form-row facility_id" style="display: none;">
                        <label> المنشاة</label><br>
                        <select name="facility_id" id="facility_id" class="form-control">
                            <option value="0">الرجاء الاختيار</option>
                            @foreach ($facilities as $facility)
                                <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    

                    <!-- Initialize Select2 -->
                    <script>
                        $(document).ready(function() {
                            $('#facility_id').select2({
                                placeholder: "اختر المنشاة", // Optional: Placeholder text for the search
                                allowClear: true // Optional: To allow clearing the selection
                            });
                        });
                    </script>












                    <fieldset style="display: flex; flex-wrap: wrap;justify-content: space-around;">
                        <legend>معلومات المستخدم</legend>

                        <div class="form-row">
                            <label> email</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="form-row">
                            <label> password</label>
                            <input type="text" name="password" class="form-control">
                        </div>
                    </fieldset>








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
