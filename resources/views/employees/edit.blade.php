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



    <div class="card" style="margin:20px;">
        <div class="card-header" style="direction: rtl;">المنتج {{ $employee->product_name }}</div>
        <div class="card-body">
            @if (session('flash_message'))
                <div class="alert alert-danger">
                    {{ session('flash_message') }}
                </div>
            @endif
            <style>
                .frm {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    align-items: center;
                    direction: rtl;
                    gap: 1%;
                }

                .form-row {
                    width: 30%;
                    margin-bottom: 15px;
                }
            </style>




            <form action="{{ route('employees.update', $employee->id) }}" class="frm" method="post"
                enctype="multipart/form-data">

                {!! csrf_field() !!}


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
                        <label> الوظيفة</label>
                        <input type="text" name="position" id="position" class="form-control">
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
                        <label>الراتب الأساسي</label>
                        <input type="text" name="basic_salary" id="basic_salary" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>النسبة</label>
                        <input type="text" name="commission" id="commission" class="form-control">
                    </div>


                    <div class="form-row">
                        <label>الفترة</label>
                        <select name="period" id="period" class="form-control">
                            <option value="0">الرجاء الاختيار</option>
                            <option value="1">صباحي</option>
                            <option value="2">مسائي</option>
                        </select>
                    </div>


                    <div class="form-row">
                        <label for="work_days">الأيام</label>
                        <select name="work_days[]" id="work_days" class="form-control" multiple>
                            <option value="0">الرجاء الاختيار</option>
                            <option value="1">الإثنين</option>
                            <option value="2">الثلاثاء</option>
                            <option value="3">الأربعاء</option>
                            <option value="4">الخميس</option>
                            <option value="5">الجمعة</option>
                            <option value="6">السبت</option>
                            <option value="7">الأحد</option>
                        </select>
                    </div>






                    <div class="form-row">
                        <label>بداية الدوام</label>
                        <input type="time" name="duty_start" id="duty_start" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>نهاية الدوام</label>
                        <input type="time" name="duty_end" id="duty_end" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>تاريخ التوظيف</label>
                        <input type="date" name="join_date" id="join_date" class="form-control">
                    </div>


                    <input type="hidden" name="Establishment_id" value="{{ session('facility_id') }}">

                    <script>
                        $(document).ready(function() {
                            $('#facility_type').on('change', function() {
                                var selectedType = $(this).val();

                                if (selectedType == '1') { // مستشفى
                                    $('#hospital_row').show();
                                    $('#clinic_row').hide();
                                } else if (selectedType == '2') { // عيادة
                                    $('#clinic_row').show();
                                    $('#hospital_row').hide();
                                } else { // الرجاء الاختيار
                                    $('#hospital_row').hide();
                                    $('#clinic_row').hide();
                                }
                            });
                        });
                    </script>


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
