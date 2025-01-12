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
        <div class="card-header" style="direction: rtl;">الطبيب {{ $profile->first_name }}</div>
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






            @if ($profile->profile_pic)
                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                    src="{{ asset($profile->profile_pic) }}" name="first_name" class="form-control">
            @else
                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                    src="https://global.discourse-cdn.com/bubble/original/3X/1/2/12e944afd917d123319c9074a7e72581785a3b38.png"
                    name="first_name" value="" class="form-control" disabled>
            @endif



            <form class="frm">




                <div class="form-row">
                    <label>الاسم الأول</label>
                    <input type="text" name="first_name" value="{{ $profile->first_name }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>الاسم الثاني</label>
                    <input type="text" name="second_name" value="{{ $profile->second_name }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>الاسم الثالث</label>
                    <input type="text" name="third_name" value="{{ $profile->third_name }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>الاسم الأخير</label>
                    <input type="text" name="last_name" value="{{ $profile->last_name }}" class="form-control" disabled>
                </div>

                <div class="form-row">
                    <label>تاريخ الميلاد</label>
                    <input type="date" name="date_birth" value="{{ $profile->date_birth }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>الموبايل</label>
                    <input type="number" name="mobile" value="{{ $profile->mobile }}" class="form-control" disabled>
                </div>

                <div class="form-row">
                    <label>العمر</label>
                    <input type="number" name="old" value="{{ $profile->old }}" class="form-control" disabled>
                </div>

                <div class="form-row">
                    <label>الجنس</label>
                    <select name="gender" class="form-control" disabled>
                        <option value="1" {{ $profile->gender == 1 ? 'selected' : '' }}>ذكر</option>
                        <option value="2" {{ $profile->gender == 2 ? 'selected' : '' }}>أنثى</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>الحالة الاجتماعية</label>
                    <select name="martial_status" class="form-control" disabled>
                        <option value="1" {{ $profile->martial_status == 1 ? 'selected' : '' }}>أعزب</option>
                        <option value="2" {{ $profile->martial_status == 2 ? 'selected' : '' }}>متزوج</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>الجنسية</label>
                    <input type="text" name="nationality" value="{{ $profile->nationality }}" class="form-control"
                        disabled>
                </div>

                <div class="form-row">
                    <label>الشهادة العلمية</label>
                    <input type="text" name="certification" value="{{ $profile->certification }}" class="form-control"
                        disabled>
                </div>


























            </form>

        </div>
    </div>

@stop
