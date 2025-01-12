@extends('hospitals.layout')
@section('content')

    <style>
        .content {
            margin: 20px auto;
            width: 69%;
        }

        #Addfacility,
        #Deletefacility,
        #AddDoctor,
        #DeleteDoctor,
        #TrashDoctor,

        #Trashfacility {
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

            <form action="{{ route('facilities.update', $facility->id) }}" method="post"
                style="display: flex; flex-direction: column; align-items: center;" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @method('PATCH')

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
                    <input type="hidden" name="id" id="id" value="{{ $facility->id }}" />

                    <div class="form-row">
                        <label>الاسم</label>
                        <input class="form-control" type="text" name="name" value="{{ $facility->name }}" />
                    </div>

                    <div class="form-row">
                        <label>العنوان</label>
                        <input type="text" name="address" value="{{ $facility->address }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="emergency">ambulance</label>
                        <input type="text" name="ambulance" value="{{ $facility->ambulance }}" id="ambulance" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="emergency">emergency</label>
                        <input type="text" name="emergency" value="{{ $facility->emergency }}" id="emergency" class="form-control" >
                    </div>

                    <?php
                    // تحويل النص المفصول بفواصل إلى مصفوفة
                    $mobileNumbers = explode(',', $facility->mobile);
                    ?>




      



                    <div class="form-row">
                        <label>suggested</label>
                        <select type="text" name="suggested" id="suggested" class="form-control">
                            <option value="0">الرجاء الاختيار</option>
                            <option value="suggested" {{ $facility->suggested == 'suggested' ? 'selected' : '' }}>مقترح
                            </option>
                            <option value="unsuggested" {{ $facility->suggested == 'unsuggested' ? 'selected' : '' }}>غير
                                مقترح</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <label>الموقع الجغرافي</label>
                        <div>

                            <input type="text" id="latitude" name="latitude" placeholder="Latitude"
                                value="{{ $facility->latitude }}" class="form-control" readonly>
                            <input type="text" id="longitude" name="longitude" placeholder="Longitude"
                                value="{{ $facility->longitude }}" class="form-control" readonly>

                        </div>
                    </div>




             

                        <div id="mobile-numbers-container" style="display: flex;">
                            <label>أرقام الهواتف</label>
                            @foreach ($mobileNumbers as $index => $mobileNumber)
                                <div class="form-row mobile-row">
                                    <input type="text" name="mobile[]" value="{{ $mobileNumber }}"
                                        class="form-control mobile-input">
                                    <button type="button" class="btn btn-danger remove-mobile">حذف</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-mobile" class="btn btn-primary">إضافة رقم جديد</button>
               
                




                </div>

                <input type="submit" value="update" class="btn btn-success">
            </form>







        </div>
    </div>

    <div id="map" style="margin: 20px; width: 100%; height: 400px;"></div>



    <script>
        $(document).ready(function() {
            // إضافة حقل جديد لرقم الهاتف
            $("#add-mobile").on("click", function() {
                $("#mobile-numbers-container").append(`
            <div class="form-row mobile-row">
                <input type="text" name="mobile[]" class="form-control mobile-input">
                <button type="button" class="btn btn-danger remove-mobile">حذف</button>
            </div>
        `);
            });

            // حذف حقل رقم الهاتف
            $(document).on("click", ".remove-mobile", function() {
                $(this).closest(".mobile-row").remove();
            });

            // عند الإرسال، دمج الأرقام في حقل واحد (إذا كان الخادم يحتاج ذلك)
            $("form").on("submit", function() {
                var mobiles = [];
                $(".mobile-input").each(function() {
                    if ($(this).val().trim() !== "") {
                        mobiles.push($(this).val().trim());
                    }
                });
                // إعداد قيمة الحقل المخفي
                $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "mobile_combined")
                    .val(mobiles.join(","))
                    .appendTo("form");
            });
        });

        $(document).ready(function() {
            // Default Riyadh location
            var defaultLat = {{ $facility->latitude ?? '24.774265' }};
            var defaultLng = {{ $facility->longitude ?? '46.738586' }};

            console.log("Default Latitude:", defaultLat, "Default Longitude:", defaultLng);

            // Initialize map
            var map = L.map('map').setView([defaultLat, defaultLng], 6);

            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // Add draggable marker
            var marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            // Update coordinates on marker drag
            // marker.on('dragend', function() {
            //     var position = marker.getLatLng();
            //     $('#latitude').val(position.lat.toFixed(6));
            //     $('#longitude').val(position.lng.toFixed(6));
            // });

            // Update marker position on map click
            map.on('click', function(event) {
                marker.setLatLng(event.latlng);
                $('#latitude').val(event.latlng.lat.toFixed(6));
                $('#longitude').val(event.latlng.lng.toFixed(6));
            });

            // Set map view to user's current location if geolocation is available
            // if (navigator.geolocation) {
            //     navigator.geolocation.getCurrentPosition(function(position) {
            //         var userLat = position.coords.latitude;
            //         var userLng = position.coords.longitude;

            //         map.setView([userLat, userLng], 13);
            //         marker.setLatLng([userLat, userLng]);
            //         $('#latitude').val(userLat.toFixed(6));
            //         $('#longitude').val(userLng.toFixed(6));
            //     }, function(error) {
            //         console.warn("Geolocation failed:", error.message);
            //     });
            // }
        });
    </script>


@stop
