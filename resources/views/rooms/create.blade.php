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

    @if (session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif


    <div class="card" style="    margin: 20px auto;width: 100%;">
        <div class="card-header">Create New room</div>
        <div class="card-body">

            <form action="{{ url('rooms') }}" method="post" dir="rtl"
                style="     display: flex;flex-direction: column;align-items: center;">
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
                        <label>الطابق</label>
                        <input type="text" name="floor_num" id="floor_num" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>القسم</label>
                        <input type="text" name="dep_id" id="dep_id" class="form-control">
                    </div>

   


                    <div class="form-row">
                        <label>الدرجة</label>
                        <select name="room_class" id="room_class" class="form-control">
                            <option value="0">الرجاء الاختيار</option>
                            @foreach ($roomsClass as $item)
                                <option value="{{ $item->id }}">{{ $item->roomsClass_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="form-row">
                        <label>نوع المنشاة</label>
                        <select name="facility_type" id="facility_type" class="form-control">
                            <option value="0">الرجاء الاختيار</option>
                            <option value="1">مستشفى</option>
                            <option value="2">عيادة</option>
                        </select>
                    </div> --}}

                    <input type="hidden" name="facility_id" id="facility_id" value="{{ session('facility_id') }}">

    


                    <script>
                        $(document).ready(function() {
                            $('#facility_type').on('change', function() {
                                var selectedType = $(this).val();

                                if (selectedType == '1') { // مستشفى
                                    $('#hospital_row').show();
                                    $('#clinic_row').hide();
                                    $('#facility_type').val('1');
                                } else if (selectedType == '2') { // عيادة
                                    $('#clinic_row').show();
                                    $('#hospital_row').hide();
                                    $('#facility_type').val('2');

                                } else { // الرجاء الاختيار
                                    $('#hospital_row').hide();
                                    $('#clinic_row').hide();
                                }
                            });
                        });
                    </script>


                    <div class="form-row">
                        <label>نوع الغرفة</label>
                        <select name="room_type" id="room_type" class="form-control">
                            <option value="0">الرجاء الاختيار</option>
                            <option value="1">  اقامة</option>
                            <option value="2">عمليات </option>
                            <option value="3"> حضانة</option>
                            <option value="3"> عناية مشددة</option>
                        </select>
                    </div>





                </div>


                <input type="submit" value="Save" class="btn btn-success" style="margin-top: 2%;"></br>
            </form>

        </div>
    </div>

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

@stop
