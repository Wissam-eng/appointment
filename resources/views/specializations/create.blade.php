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
  <div class="card-header">Create New Hospital</div>
  <div class="card-body">
  <form action="{{ url('specializations') }}" method="post" dir="rtl" enctype="multipart/form-data">
    {!! csrf_field() !!}

    <!-- Hidden input to send the default image -->
    <input type="hidden" name="specialization_pic" value="default_profile.png">

    <input type="file" name="specialization_pic" id="specialization_pic" style="display: none;">
    
    <img id="clickableImage" style="width: 15%; margin: 1% auto; cursor: pointer;"
        src="{{ asset('storage/images/default_profile.png') }}"
        alt="Specialization Image" class="form-control">

    <label for="specialization_name">الاختصاص</label></br>
    <input type="text" name="specialization_name" id="specialization_name" class="form-control"></br>
    <input type="hidden" name="facility_id" id="facility_id" value="{{ session('facility_id') }}" class="form-control"></br>

    <input type="submit" value="Save" class="btn btn-success">
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#clickableImage').on('click', function() {
            $('#specialization_pic').click();
        });

        $('form').on('submit', function(e) {
            var fileInput = $('#specialization_pic');
            if (!fileInput.val()) {
                // If no image is selected, set a default image value
                fileInput.attr('name', 'default_image');
            }
        });
    });
</script>


  </div>
</div>

<script>
  $(document).ready(function() {
    $('#clickableImage').on('click', function() {
      $('#specialization_pic').click();
    });

    $('#specialization_pic').on('change', function(event) {
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

@stop