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
        <div class="card-header" style="direction: rtl;"> {{ $profile->first_name }}</div>
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





            <form class="frm" action="{{ route('profile.update', $profile->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <input type="file" id="fileInput" name="profile_pic" style="display: none;">

                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                    src="{{ $profile->profile_pic ? asset($profile->profile_pic) : asset('storage/images/default_profile.png') }}" />


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
                        <input type="text" name="first_name" value="{{ $profile->first_name }}" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>الاسم الثاني</label>
                        <input type="text" name="second_name" value="{{ $profile->second_name }}" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>الاسم الثالث</label>
                        <input type="text" name="third_name" value="{{ $profile->third_name }}" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>الاسم الأخير</label>
                        <input type="text" name="last_name" value="{{ $profile->last_name }}" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>تاريخ الميلاد</label>
                        <input type="date" name="date_birth" value="{{ $profile->date_birth }}" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>الموبايل</label>
                        <input type="number" name="mobile" value="{{ $profile->mobile }}" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>العمر</label>
                        <input type="number" name="old" value="{{ $profile->old }}" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>الجنس</label>
                        <select name="gender" class="form-control">
                            <option value="1" {{ $profile->gender == 1 ? 'selected' : '' }}>ذكر</option>
                            <option value="2" {{ $profile->gender == 2 ? 'selected' : '' }}>أنثى</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <label>الحالة الاجتماعية</label>
                        <select name="martial_status" class="form-control">
                            <option value="1" {{ $profile->martial_status == 1 ? 'selected' : '' }}>أعزب</option>
                            <option value="2" {{ $profile->martial_status == 2 ? 'selected' : '' }}>متزوج</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <label>الجنسية</label>
                        <input type="text" name="nationality" value="{{ $profile->nationality }}" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>الشهادة العلمية</label>
                        <input type="text" name="certification" value="{{ $profile->certification }}"
                            class="form-control">
                    </div>

             

                    @if ($profile->user->user_type == 2)

                        <div class="form-row facility_id" ">
                            <label> المنشاة</label><br>
                            <select name="facility_id" id="facility_id" class="form-control">
                                <option value="0">الرجاء الاختيار</option>
                                @foreach ($facilities as $facility)
                                    <option value="{{ $facility->id }}" {{ $profile->user->facility_id == $facility->id ? 'selected' : '' }}>{{ $facility->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    @endif




                    <fieldset style="display: flex; flex-wrap: wrap;justify-content: space-around;">
                        <legend>معلومات المستخدم</legend>

                        <div class="form-row">
                            <label> email</label>
                            <input type="text" name="email" value="{{ $profile->user->email }}" class="form-control">
                        </div>
                        <div class="form-row">
                            <label> password</label>
                            <input type="text" name="password" class="form-control">
                        </div>
                    </fieldset>




















                </div>

                <div style="display: flex; justify-content: center; margin-top: 2%;">
                    <input type="submit" value="Update" class="btn btn-success">
                </div>
            </form>


        </div>
    </div>

@stop
