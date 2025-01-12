@extends('hospitals.layout')
@section('content')
    <style>
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

        .trash_it,
        .delete_it {
            cursor: pointer;
        }

        .edit_it,
        .restor_it {
            color: green;
            cursor: pointer;
        }

        a {
            text-decoration: auto;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            padding: 1rem;
            justify-content: center;
        }


        .card-header {
            position: relative;
        }

        .card-img {
            width: 100%;
            height: 200px;
            margin-top: 8%;
            object-fit: cover;
        }

        .card-actions {
            position: absolute;
            top: 2px;
            right: 10px;
            display: flex;
            gap: 0.5rem;
            align-items: flex-end;
        }

        .card-actions a,
        .card-actions i {
            color: #315883;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            margin: 0;
            font-size: 1.2rem;
        }

        .card-text {
            margin: 0.5rem 0;
        }

        .search-container {
            display: flex;
            align-items: center;
        }

        .search-form {
            display: none;
            margin-left: 10px;
        }

        .search-icon {
            cursor: pointer;
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
    </style>







    <nav class="navbar navbar-expand-lg bg-body-tertiary"
        style="    position: sticky;top: 0px;z-index: 33;    padding: 0px;        ">
        <div class="container-fluid" style="    padding: 0px;">


            <div class="collapse navbar-collapse" id="navbarSupportedContent"
                style="justify-content: space-around;;background-color:white;">
                <div class="icon">
                    <i class="fa-solid fa-trash " style="font-size: 400%;    color: #3061bc;"></i>
                </div>
                <div class="search-container">
                    <i class="fas fa-search search-icon" style="margin-top:10px;margin-right: 20px;"></i>
                    <form class="search-form" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>

            </div>
        </div>
    </nav>



    <div class="d-flex">
        <div class="container" style="margin-top: 2%;">
            <div class="card-body">

                @if (session('flash_message'))
                    <div class="alert alert-success">
                        {{ session('flash_message') }}
                    </div>
                @endif

                <div class="card-container">
                    @foreach ($doctor_deleted as $item)
                        <div class="card">
                            <div class="card-header">
                                <div class="card-actions">
                                    <form id="restore-form-{{ $item->id }}" method="POST"
                                        action="{{ route('profile.restore', $item->id) }}" accept-charset="UTF-8"
                                        style="display:inline">
                                        @csrf
                                        @method('POST')
                                        <i class="fa-solid fa-rotate-left restor_it" style="cursor:pointer"
                                            data-form-id="restore-form-{{ $item->id }}"></i>
                                    </form>



                                    <form id="delete-form-{{ $item->id }}" method="POST"
                                        action="{{ route('profile.delete', $item->id) }}" accept-charset="UTF-8"
                                        style="display:inline">
                                        {{ Method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <i class="fa-solid fa-trash delete_it"
                                            data-form-id="delete-form-{{ $item->id }}"></i>
                                    </form>
                                </div>
                                <img src="{{ $item->profile_pic ? asset($item->profile_pic) : asset('storage/images/default_profile.png') }}"
                                    alt="Profile Picture" class="card-img">
                            </div>

                            <div class="card-body">
                                <h5 class="card-title"><i class="fa-solid fa-user-doctor"></i>
                                    {{ $item->first_name . ' ' . $item->last_name }}</h5>
                                <p class="card-text"><i class="fa-solid fa-phone"></i> {{ $item->mobile }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>


                <script>
                    $(document).ready(function() {
                        handleDeleteConfirmation('.delete_it', 'This will Delete doctor file!', 'Yes, Do it!');
                        handleDeleteConfirmation('.restor_it', 'Do you want to restore this item?', 'Restore');

                    });
                </script>


            </div>
        </div>
    </div>
@endsection
