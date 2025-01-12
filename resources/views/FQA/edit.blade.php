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
        <div class="card-header" style="direction: rtl;"></div>
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




            <form style="display: flex;flex-direction: column;" action="{{ route('FQA.update', $fQA->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <input type="file" id="fileInput" name="product_img" style="display: none;">



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
                        <label> question</label>
                        <input type="text" value="{{ $fQA->question }}" name="question" id="question"
                            class="form-control">
                    </div>

                    <div class="form-row">
                        <label> answer</label>
                        <input type="text" value="{{ $fQA->answer }}" name="answer" id="answer"
                            class="form-control">
                    </div>


   





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

                <div style="display: flex; justify-content: center; margin-top: 2%;">
                    <input type="submit" value="Update" class="btn btn-success">
                </div>
            </form>


        </div>
    </div>

@stop
