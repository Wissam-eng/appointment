@extends('hospitals.layout')
@section('content')



<style>
    .content {
        margin: 20px auto;
        width: 69%;
    }

    #AddHospital,
    #DeleteHospital,
    #AddDoctor,
    #DeleteDoctor,
    #TrashDoctor,

    #TrashHospital {
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







<div class="card" style="margin:20px;width:100%">
    <div class="card-header"><i class="fa-regular fa-square-plus"></i></div>
    <div class="card-body">

        <form action="{{ route('hospitals.update', $hospital->id) }}" method="post" style="    display: flex;flex-direction: column;align-items: center;" enctype="multipart/form-data">
            {!! csrf_field() !!}
            @method("PATCH")

            <input type="file" id="fileInput" name="profile_pic" style="display: none;">

            <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                src="{{ $hospital->profile_pic ? asset($hospital->profile_pic) : asset('storage/images/default_profile.png') }}" />

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

            <div class="frm">
                <input type="hidden" name="id" id="id" value="{{$hospital->id}}" id="id" />

                <div class="form-row">
                    <label>الاسم</label>
                    <input class="form-control" type="text" name="id" id="id" value="{{$hospital->hospital_name}}" id="id" />
                </div>


                <div class="form-row">
                    <label>العنوان</label>
                    <input type="text" name="hospital_address" value="{{$hospital->hospital_address}}" id="address" class="form-control">
                </div>

                <div class="form-row">
                    <label>الموبايل</label>
                    <input type="text" name="mobile" id="mobile" value="{{$hospital->mobile}}" class="form-control">
                </div>
                <div class="form-row">
                    <label>number of room</label>
                    <input type="text" name="room_num" id="room_num" value="{{$hospital->room_num}}" class="form-control">
                  </div>





            </div>
            <input type="submit" value="update" class="btn btn-success">
        </form>

    </div>
</div>

@stop