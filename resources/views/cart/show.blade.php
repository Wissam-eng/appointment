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
        <div class="card-header" style="direction: rtl;">الطبيب {{ $doctors->first_name }}</div>
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
                    margin-bottom: 15px;
                }
            </style>






            @if ($doctors->profile_pic)
                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                    src="{{ asset($doctors->profile_pic) }}" name="first_name" class="form-control">
            @else
                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                    src="https://global.discourse-cdn.com/bubble/original/3X/1/2/12e944afd917d123319c9074a7e72581785a3b38.png"
                    name="first_name" value="" class="form-control" disabled>
            @endif



            <form class="frm">




                <div class="form-row">
                    <label>الاسم الأول</label>
                    <input type="text" name="first_name" value="{{ $doctors->first_name }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>الاسم الثاني</label>
                    <input type="text" name="second_name" value="{{ $doctors->second_name }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>الاسم الثالث</label>
                    <input type="text" name="third_name" value="{{ $doctors->third_name }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>الاسم الأخير</label>
                    <input type="text" name="last_name" value="{{ $doctors->last_name }}" class="form-control" disabled>
                </div>

                <div class="form-row">
                    <label>تاريخ الميلاد</label>
                    <input type="date" name="date_birth" value="{{ $doctors->date_birth }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>الموبايل</label>
                    <input type="number" name="mobile" value="{{ $doctors->mobile }}" class="form-control" disabled>
                </div>

                <div class="form-row">
                    <label>العمر</label>
                    <input type="number" name="old" value="{{ $doctors->old }}" class="form-control" disabled>
                </div>

                <div class="form-row">
                    <label>الجنس</label>
                    <select name="gender" class="form-control" disabled>
                        <option value="1" {{ $doctors->gender == 1 ? 'selected' : '' }}>ذكر</option>
                        <option value="2" {{ $doctors->gender == 2 ? 'selected' : '' }}>أنثى</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>الحالة الاجتماعية</label>
                    <select name="martial_status" class="form-control" disabled>
                        <option value="1" {{ $doctors->martial_status == 1 ? 'selected' : '' }}>أعزب</option>
                        <option value="2" {{ $doctors->martial_status == 2 ? 'selected' : '' }}>متزوج</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>الجنسية</label>
                    <input type="text" name="nationality" value="{{ $doctors->nationality }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>الشهادة العلمية</label>
                    <input type="text" name="certification" value="{{ $doctors->certification }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>الراتب الأساسي</label>
                    <input type="text" name="basic_salary" value="{{ $doctors->basic_salary }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>النسبة</label>
                    <input type="text" name="commission" value="{{ $doctors->commission }}" class="form-control"
                        disabled>
                </div>



                <div class="form-row">
                    <label>الفترة</label>
                    <select name="period" id="period"  disabled class="form-control">


                        <option value="1" {{ $doctors->period == 1 ? 'selected' : '' }}>صباحي</option>
                        <option value="2" {{ $doctors->period == 2 ? 'selected' : '' }}>مسائي</option>
                    </select>
                </div>


                <div class="form-row">
                    <label for="work_days">الأيام</label>
                    <select name="work_days[]" id="work_days" class="form-control" disabled multiple>
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
                    <input type="time" name="duty_start" value="{{ $doctors->duty_start }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>نهاية الدوام</label>
                    <input type="time" name="duty_end" value="{{ $doctors->duty_end }}" class="form-control" disabled>
                </div>

                <div class="form-row">
                    <label>تاريخ التوظيف</label>
                    <input type="text" name="join_date" value="{{ $doctors->join_date }}" class="form-control" disabled>
                </div>

                <div class="form-row">
                    <label>الاختصاص</label>
                    <input type="text" name="join_date" value="{{ $doctors->specialization->specialization_name }}" class="form-control"
                        disabled>

                </div>





                @if ($doctors->facility_type === 1 && $doctors->hospital)
                <div class="form-row">
                    <label>المشفى</label>
                    <input type="text" name="join_date" value="{{ $doctors->hospital->hospital_name }}" class="form-control" disabled>
                </div>
            @elseif ($doctors->facility_type === 2 && $doctors->clinic)
                <div class="form-row">
                    <label>العيادة</label>
                    <input type="text" name="join_date" value="{{ $doctors->clinic->clinic_name }}" class="form-control" disabled>
                </div>
            @endif
            

            </form>

        </div>
    </div>

@stop
