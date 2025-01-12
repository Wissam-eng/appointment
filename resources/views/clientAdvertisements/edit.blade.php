@extends('hospitals.layout')
@section('content')


    <style>
        form {
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
        }

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



    <div class="card" style="    margin: 20px auto;
    width: 69%;">
        <div class="card-header">Create New Ads</div>
        <div class="card-body">

            <form action="{{ route('clientAdvertisements.update', $clientAdvertisement->id) }}" method="post"
                enctype="multipart/form-data">
                {!! csrf_field() !!}
                @method('PUT')

                <input type="file" name="image_url" value="default_profile.png" id="image_url" style="display: none;">

                <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;" src="{{ $clientAdvertisement->image_url ? asset($clientAdvertisement->image_url) : asset('storage/images/default_profile.png') }}" name="first_name" value="" class="form-control" disabled>



                <script>
                    $(document).ready(function() {
                        $('#clickableImage').on('click', function() {
                            $('#image_url').click();
                        });

                        $('#image_url').on('change', function(event) {
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



                <div class="form-row">
                    <label for="ad_type">Type of Ads</label><br>
                    <select name="ad_type" id="ad_type" class="form-control">
                        <option value="0">Please choose</option>
                        <option value="1" {{ $clientAdvertisement->ad_type == 'text' ? 'selected' : '' }}>Text</option>
                        <option value="2" {{ $clientAdvertisement->ad_type == 'image' ? 'selected' : '' }}>Image
                        </option>
                    </select>
                </div>



                <div class="form-row">
                    <label>title </label></br>
                    <input type="text" name="title" value="{{ $clientAdvertisement->title }}" id="title"
                        class="form-control">
                </div>

                <div class="form-row">
                    <label>content </label>
                    <textarea type="text" name="content" id="content" class="form-control">{{ $clientAdvertisement->content }}</textarea>
                </div>

                <div class="form-row">
                    <label for="start_date">start_date</label>
                    <input type="text" name="start_date" value="{{ $clientAdvertisement->start_date }}" id="start_date"
                        class="form-control currentDate">
                </div>

                <div class="form-row">
                    <label for="end_date">end_date</label><br>
                    <input type="text" name="end_date" value="{{ $clientAdvertisement->end_date }}" id="end_date"
                        class="form-control dateAfterOneMonth">
                </div>


                <br>



                <div class="form-row">
                    <label for="clients">Clients</label><br>
                    <select name="client_id" id="client_id" class="form-control">
                        <option value="0">Please choose</option>
                        @foreach ($clients as $c)
                            <option value="{{ $c->id }}"
                                {{ $c->id == $clientAdvertisement->client_id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>



                <div class="form-row">
                    <label for="status">status</label><br>
                    <select name="status" id="status" class="form-control">
                        <option value="0">please choose</option>
                        <option value="active" {{ $clientAdvertisement->status == 'active' ? 'selected' : '' }}>active
                        </option>
                        <option value="inactive" {{ $clientAdvertisement->status == 'inactive' ? 'selected' : '' }}>inactive
                        </option>
                    </select>
                </div>


                <div class="form-row">
                    <label for="cost">cost</label><br>
                    <input type="text" name="cost" value="{{ $clientAdvertisement->cost }}" id="cost"
                        class="form-control">
                </div>
                <input type="hidden" value="{{ session('user_id') }}" name="created_by">

                <br>





                <input type="submit" value="Save" class="btn btn-success"></br>
            </form>

        </div>
    </div>

@stop
