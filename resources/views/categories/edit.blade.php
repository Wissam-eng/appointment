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
        <div class="card-header" style="direction: rtl;">الطبيب {{ $categorys->category_name }}</div>
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

                .frm2 {
                    display: flex;
                    flex-direction: column;
                    align-items: stretch;

                }
            </style>





            <form class="frm2" action="{{ route('categories.update', $categorys->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <input type="file" id="fileInput" name="img" style="display: none;">

                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                    src="{{ $categorys->img ? asset($categorys->img) : asset('storage/images/default_profile.png') }}" />


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
                        <label> الفئة</label>
                        <input type="text" value="{{ $categorys->category_name }}" name="category_name"
                            id="category_name" class="form-control">
                    </div>

                    <div class="form-row">
                        <label>النوع</label>
                        <select name="category_type" id="category_type" class="form-control">
                            <option value="1" {{ $categorys->category_type == 1 ? 'selected' : '' }}>طبي</option>
                            <option value="2" {{ $categorys->category_type == 2 ? 'selected' : '' }}>انتاجي</option>
                        </select>
                    </div>
                    

                </div>

                <div style="display: flex; justify-content: center; margin-top: 2%;">
                    <input type="submit" value="Update" class="btn btn-success">
                </div>
            </form>


        </div>
    </div>

@stop
