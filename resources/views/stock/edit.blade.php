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
        <div class="card-header" style="direction: rtl;">المنتج {{ $stock->product_name }}</div>
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




            <form style="display: flex;flex-direction: column;" action="{{ route('stock.update', $stock->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <input type="file" id="fileInput" name="product_img" style="display: none;">

                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                    src="{{ $stock->product_img ? asset($stock->product_img) : asset('storage/images/default_profile.png') }}" />


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
                        <label> product</label>
                        <input type="text" value="{{ $stock->product_name }}" name="product_name" id="product_name"
                            class="form-control">
                    </div>

                    <div class="form-row">
                        <label> qty</label>
                        <input type="text" value="{{ $stock->qty }}" name="qty" id="qty"
                            class="form-control">
                    </div>


                    <div class="form-row">
                        <label> price</label>
                        <input type="text" value="{{ $stock->price }}" name="price" id="price"
                            class="form-control">
                    </div>




                    <input type="hidden" name="facility_id" id="facility_id" value="{{ session('facility_id') }}"
                        class="form-control">
           







                    <div class="form-row">
                        <label for="note">Note</label>
                        <textarea name="note" id="note" class="form-control">{{ $stock->note }}</textarea>
                    </div>




                    <div class="form-row">
                        <label>الفئة</label>
                        <select name="category_id" id="category_type_{{ $stock->category_id }}" class="form-control">
                            @foreach ($categories as $cat)
                                <option value="1" {{ $cat->id == $stock->category_id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>






                    <div class="form-row">
                        <label> expire date</label>
                        <input type="date" value="{{ $stock->exp_date }}" name="exp_date" id="exp_date"
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
