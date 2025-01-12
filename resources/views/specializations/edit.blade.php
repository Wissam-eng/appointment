@extends('hospitals.layout')
@section('content')



    <style>
        .content {
            margin: 20px auto;
            width: 69%;
        }

        #Addspecialization,
        #Deletespecialization,
        #AddDoctor,
        #DeleteDoctor,
        #TrashDoctor,

        #Trashspecialization {
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

            <form action="{{ route('specializations.update', $specialization->id) }}" method="post"
                style="    display: flex;
    flex-direction: column;
    align-items: center;" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @method('PATCH')

                <input type="file" id="fileInput" name="specialization_pic" style="display: none;">

                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                    src="{{ $specialization->specialization_pic ? asset($specialization->specialization_pic) : asset('storage/images/default_profile.png') }}" />

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
                        width: 50%;

                    }

                    .form-row {
                        width: 30%;
                        margin-bottom: 15px;
                    }
                </style>

                <div class="frm">
                    <input type="hidden" name="id" id="id" value="{{ $specialization->id }}" id="id" />

                    <div class="form-row">
                        <label>الاختصاص</label>
                        <input class="form-control" type="text" name="specialization_name" id="specialization_name"
                            value="{{ $specialization->specialization_name }}" id="id" />
                    </div>

                </div>
                <input type="submit" value="update" class="btn btn-success">
            </form>

        </div>
    </div>

@stop
