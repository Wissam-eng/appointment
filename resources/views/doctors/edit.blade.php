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









<div class="card" style="margin:20px;">
    <div class="card-header" style="direction: rtl;">الطبيب {{$doctors->first_name}}</div>
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
                align-items: center;
                justify-content: space-around;
                direction: rtl;
            }

            .form-row {
                width: 30%;
                margin-bottom: 15px;
            }
        </style>





        <form class="frm" action="{{ route('doctors.update', $doctors->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <input type="file" id="fileInput" name="profile_pic" style="display: none;">

            <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                src="{{ $doctors->profile_pic ? asset($doctors->profile_pic) : asset('storage/images/default_profile.png') }}" />


            <script>
                $(document).ready(function() {
                    $('#clickableImage').on('click', function() {
                        $('#fileInput').click();
                    });

                    $('#fileInput').on('change', function(event) {
                        var file = event.target.files[0];
                        if (file) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $('#clickableImage').attr('src', e.target.result);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                });
            </script>

            <div class="frm">



                <div class="form-row">
                    <label>الاسم الأول</label>
                    <input type="text" name="first_name" value="{{ $doctors->first_name }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>الاسم الثاني</label>
                    <input type="text" name="second_name" value="{{ $doctors->second_name }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>الاسم الثالث</label>
                    <input type="text" name="third_name" value="{{ $doctors->third_name }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>الاسم الأخير</label>
                    <input type="text" name="last_name" value="{{ $doctors->last_name }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>تاريخ الميلاد</label>
                    <input type="date" name="date_birth" value="{{ $doctors->date_birth }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>الموبايل</label>
                    <input type="number" name="mobile" value="{{ $doctors->mobile }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>العمر</label>
                    <input type="number" name="old" value="{{ $doctors->old }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>الجنس</label>
                    <select name="gender" class="form-control" >
                        <option value="1" {{ $doctors->gender == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="2" {{ $doctors->gender == 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>الحالة الاجتماعية</label>
                    <select name="martial_status" class="form-control">
                        <option value="1" {{ $doctors->martial_status == 1 ? 'selected' : '' }}>أعزب</option>
                        <option value="2" {{ $doctors->martial_status == 2 ? 'selected' : '' }}>متزوج</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>الجنسية</label>
                    <input type="text" name="nationality" value="{{ $doctors->nationality }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>الشهادة العلمية</label>
                    <input type="text" name="certification" value="{{ $doctors->certification }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>الراتب الأساسي</label>
                    <input type="text" name="basic_salary" value="{{ $doctors->basic_salary }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>النسبة</label>
                    <input type="text" name="commission" value="{{ $doctors->commission }}" class="form-control">
                </div>


                <div class="form-row">
                    <label>الفترة</label>
                    <select name="period" id="period"   class="form-control">


                        <option value="1" {{ $doctors->period == 1 ? 'selected' : '' }}>صباحي</option>
                        <option value="2" {{ $doctors->period == 2 ? 'selected' : '' }}>مسائي</option>
                    </select>
                </div>


                <div class="form-row">
                    <label for="work_days">الأيام</label>
                    <select name="work_days[]" id="work_days" class="form-control"  multiple>
                        <option value="0">الرجاء الاختيار</option>
                
                        @php
                            $fixedDays = [
                                1 => 'الإثنين',
                                2 => 'الثلاثاء',
                                3 => 'الأربعاء',
                                4 => 'الخميس',
                                5 => 'الجمعة',
                                6 => 'السبت',
                                7 => 'الأحد',
                            ];
                        @endphp
                        
                        @foreach ($fixedDays as $id => $name)
                            @if (in_array($id, $workDays))
                                <option value="{{ $id }}" selected>{{ $name }}</option>
                            @else
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endif
                        @endforeach
                        
                    </select>
                </div>
                

                <div class="form-row">
                    <label>بداية الدوام</label>
                    <input type="time" name="duty_start" value="{{ $doctors->duty_start }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>نهاية الدوام</label>
                    <input type="time" name="duty_end" value="{{ $doctors->duty_end }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>تاريخ التوظيف</label>
                    <input type="text" name="join_date" value="{{ $doctors->join_date }}" class="form-control">
                </div>

                <div class="form-row">
                    <label>الاختصاص</label>

                    <!-- <input type="text" name="specialization_id" value="{{ $doctors->specialization_id }}" class="form-control"> -->

                    <select name="specialization_id" class="form-control">
                   
                        @foreach($specialization as $item2)
                        <option value="{{ $item2->id }}" {{ $doctors->specialization_id == $item2->id ? 'selected' : '' }}>
                            {{ $item2->specialization_name }}
                        </option>
                        @endforeach
                    </select>

                </div>









                @if ($doctors->facility_type === 1 && $doctors->hospital)
                <div class="form-row">
                    <label>المشفى</label>
                    <select name="Establishment_id" class="form-control">
                        @foreach($hospitals as $item1)
                        <option value="{{ $item1->id }}" {{ $doctors->Establishment_id == $item1->id ? 'selected' : '' }}>
                            {{ $item1->hospital_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            @elseif ($doctors->facility_type === 2 && $doctors->clinic)


                <div class="form-row">
                    <label>العيادة</label>
                    <select name="Establishment_id" class="form-control">
                        @foreach($clinics as $item1)
                        <option value="{{ $item1->id }}" {{ $doctors->Establishment_id == $item1->id ? 'selected' : '' }}>
                            {{ $item1->clinic_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            @endif






            </div>

            <div style="display: flex; justify-content: center; margin-top: 2%;">
                <input type="submit" value="Update" class="btn btn-success">
            </div>
        </form>


    </div>
</div>

@stop