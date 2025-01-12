@extends('hospitals.layout')
@section('content')

<style>
    .content {
        margin: 20px auto;
        width: 69%;
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

<div class="card" style="margin: 20px auto; width: 69%;">
    <div class="card-header">Create New Facility</div>
    <div class="card-body">
        <form action="{{ url('facilities') }}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="file" name="profile_pic" id="profile_pic" style="display: none;">
            <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
                src="{{ asset('storage/images/default_profile.png') }}" alt="Profile Picture">

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

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" required>
            </div>


            <div class="form-group">
                <label for="emergency">ambulance</label>
                <input type="text" name="ambulance" id="ambulance" class="form-control" >
            </div>
            <div class="form-group">
                <label for="emergency">emergency</label>
                <input type="text" name="emergency" id="emergency" class="form-control" >
            </div>

            <div id="mobile-container">
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" name="mobile[]" class="form-control mobile-input">
                    <button type="button" id="add-mobile" class="btn btn-primary">Add Another</button>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    // Add a new mobile input field
                    $("#add-mobile").on("click", function() {
                        $("#mobile-container").append(`
                            <div class="form-group">
                                <input type="text" name="mobile[]" class="form-control mobile-input">
                                <button type="button" class="btn btn-danger remove-mobile">Remove</button>
                            </div>
                        `);
                    });

                    // Remove a mobile input field
                    $(document).on("click", ".remove-mobile", function() {
                        $(this).closest(".form-group").remove();
                    });
                });
            </script>

            <div class="form-group">
                <label for="room_num">Number of Rooms</label>
                <input type="text" name="room_num" id="room_num" class="form-control">
            </div>

            <div class="form-group">
                <label for="suggested">Suggested</label>
                <select name="suggested" id="suggested" class="form-control">
                    <option value="0">Please Select</option>
                    <option value="suggested">Suggested</option>
                    <option value="unsuggested">Not Suggested</option>
                </select>
            </div>

            <div class="form-group">
                <label for="facility_type">Facility Type</label>
                <select name="facility_type" id="facility_type" class="form-control">
                    <option value="0">Please Select</option>
                    <option value="1">Hospital</option>
                    <option value="2">Clinic</option>
                    <option value="3">Center</option>
                    <option value="4">Pharmacy</option>
                    <option value="5">Company</option>
                </select>
            </div>

            <div class="form-group">
                <label for="location">Geographic Location</label>
                <div>
                    <input type="text" id="latitude" placeholder="Latitude" class="form-control" readonly>
                    <input type="text" id="longitude" placeholder="Longitude" class="form-control" readonly>
                </div>
            </div>

            <input type="submit" value="Save" class="btn btn-success">
        </form>
    </div>
</div>

<div id="map" style="margin: 20px; width: 100%; height: 400px;"></div>

<script>
    $(document).ready(function() {
        let map, marker;

        function initMap(lat, lng) {
            map = L.map('map').setView([lat, lng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            marker = L.marker([lat, lng], { draggable: true }).addTo(map);

            // Update coordinates on drag
            marker.on('dragend', function() {
                const position = marker.getLatLng();
                $('#latitude').val(position.lat);
                $('#longitude').val(position.lng);
            });

            // Update coordinates on map click
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                $('#latitude').val(e.latlng.lat);
                $('#longitude').val(e.latlng.lng);
            });
        }

        // Geolocation or default to Riyadh
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    initMap(position.coords.latitude, position.coords.longitude);
                    $('#latitude').val(position.coords.latitude);
                    $('#longitude').val(position.coords.longitude);
                },
                function() {
                    initMap(24.774265, 46.738586); // Riyadh default
                }
            );
        } else {
            initMap(24.774265, 46.738586);
        }
    });
</script>
@stop
