@extends('hospitals.layout')
@section('content')

<style>
    .content {
        margin: 20px auto;
        width: 69%;
    }

    li a{
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
</style>



<nav class="navbar navbar-expand-lg bg-body-tertiary" style="    position: sticky;top: 0px;z-index: 33;    padding: 0px;        ">
    <div class="container-fluid" style="    padding: 0px;">


        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="justify-content: space-around;;background-color:white;">
            <div class="icon">
                <i class="fa-solid fa-square-h" style="font-size: 400%;    color: #3061bc;"></i>
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


<div class="d-flex" style="    flex-direction: column;justify-content: space-around;height: 100%;">










    <div class="card-container" style="flex-direction: column;">
        <div class="icon">
            <a href="{{ url('/doctors.show_doctors/' . $hospital->id) }}">
                <i class="fa-solid fa-user-doctor" style="font-size: 400%;    color: #3061bc;cursor:pointer"></i>
            </a>
        </div>
        <div class="card-wrapper">
            @foreach($hospital->doctors as $item2)
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        <a href="{{ url('doctors/' . $item2->id) }}" title="View Student"><i class="fa-solid fa-circle-info"></i></a>
                        <a href="{{ url('/doctors/' . $item2->id . '/edit') }}" title="Edit Student"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form id="delete-form-{{ $item2->id }}" method="POST" action="{{ route('doctors.destroy', $item2->id) }}" accept-charset="UTF-8" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <i class="fa-solid fa-trash-can trash_it" style="cursor:pointer" data-form-id="delete-form-{{ $item2->id }}"></i>
                        </form>
                    </div>
                    <img src="{{ asset('storage/images/a.webp') }}" alt="Profile Picture" class="card-img">
                </div>

                <div class="card-body">
                    <p class="card-text"><i class="fa-solid fa-circle-h"></i> {{ $item2->first_name}}</p>
                    <p class="card-text"><i class="fa-solid fa-phone"></i> {{ $item2->first_name }}</p>
                    <p class="card-title"><i class="fa-solid fa-location-dot"></i>{{ $item2->first_name }} </p>
                    <p class="card-text"><i class="fa-solid fa-stethoscope"></i> {{ $item2->first_name }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>




    <div class="card-container" style="flex-direction: column;">
        <div class="icon">
            <i class="fa-solid fa-door-closed" style="font-size: 400%;    color: #3061bc;"></i>
        </div>
        <div class="card-wrapper">
            @foreach($hospital->doctors as $item2)
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        <a href="{{ url('/doctors/' . $item2->id) }}" title="View Student"><i class="fa-solid fa-circle-info"></i></a>
                        <a href="{{ url('/hospitals/' . $item2->id . '/edit') }}" title="Edit Student"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form id="delete-form-{{ $item2->id }}" method="POST" action="{{ route('hospitals.destroy', $item2->id) }}" accept-charset="UTF-8" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <i class="fa-solid fa-trash-can trash_it" style="cursor:pointer" data-form-id="delete-form-{{ $item2->id }}"></i>
                        </form>
                    </div>
                    <img src="{{ asset('storage/images/a.webp') }}" alt="Profile Picture" class="card-img">
                </div>

                <div class="card-body">
                    <p class="card-text"><i class="fa-solid fa-circle-h"></i> {{ $item2->first_name}}</p>
                    <p class="card-text"><i class="fa-solid fa-phone"></i> {{ $item2->first_name }}</p>
                    <p class="card-title"><i class="fa-solid fa-location-dot"></i>{{ $item2->first_name }} </p>
                    <p class="card-text"><i class="fa-solid fa-stethoscope"></i> {{ $item2->first_name }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>



    <div class="card-container" style="flex-direction: column;">
        <div class="icon">
            <i class="fa fa-baby" style="font-size: 400%;    color: #3061bc;"></i>
        </div>
        <div class="card-wrapper">
            @foreach($hospital->doctors as $item2)
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        <a href="{{ url('/doctors/' . $item2->id) }}" title="View Student"><i class="fa-solid fa-circle-info"></i></a>
                        <a href="{{ url('/hospitals/' . $item2->id . '/edit') }}" title="Edit Student"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form id="delete-form-{{ $item2->id }}" method="POST" action="{{ route('hospitals.destroy', $item2->id) }}" accept-charset="UTF-8" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <i class="fa-solid fa-trash-can trash_it" style="cursor:pointer" data-form-id="delete-form-{{ $item2->id }}"></i>
                        </form>
                    </div>
                    <img src="{{ asset('storage/images/a.webp') }}" alt="Profile Picture" class="card-img">
                </div>

                <div class="card-body">
                    <p class="card-text"><i class="fa-solid fa-circle-h"></i> {{ $item2->first_name}}</p>
                    <p class="card-text"><i class="fa-solid fa-phone"></i> {{ $item2->first_name }}</p>
                    <p class="card-title"><i class="fa-solid fa-location-dot"></i>{{ $item2->first_name }} </p>
                    <p class="card-text"><i class="fa-solid fa-stethoscope"></i> {{ $item2->first_name }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>


    <div class="card-container" style="flex-direction: column;">
        <div class="icon">
            <!-- <i class="fa fa-baby" style="font-size: 400%;    color: #3061bc;"></i> -->
            <i class="fa-solid fa-building" style="font-size: 400%;    color: #3061bc;"></i>
        </div>
        <div class="card-wrapper">
            @foreach($hospital->doctors as $item2)
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        <a href="{{ url('/doctors/' . $item2->id) }}" title="View Student"><i class="fa-solid fa-circle-info"></i></a>
                        <a href="{{ url('/hospitals/' . $item2->id . '/edit') }}" title="Edit Student"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form id="delete-form-{{ $item2->id }}" method="POST" action="{{ route('hospitals.destroy', $item2->id) }}" accept-charset="UTF-8" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <i class="fa-solid fa-trash-can trash_it" style="cursor:pointer" data-form-id="delete-form-{{ $item2->id }}"></i>
                        </form>
                    </div>
                    <img src="{{ asset('storage/images/a.webp') }}" alt="Profile Picture" class="card-img">
                </div>

                <div class="card-body">
                    <p class="card-text"><i class="fa-solid fa-circle-h"></i> {{ $item2->first_name}}</p>
                    <p class="card-text"><i class="fa-solid fa-phone"></i> {{ $item2->first_name }}</p>
                    <p class="card-title"><i class="fa-solid fa-location-dot"></i>{{ $item2->first_name }} </p>
                    <p class="card-text"><i class="fa-solid fa-stethoscope"></i> {{ $item2->first_name }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="card-container" style="flex-direction: column;">
        <div class="icon">
            <i class="fa-solid fa-user-injured" style="font-size: 400%;    color: #3061bc;"></i>
            <!-- <i class="fa-solid fa-building" style="font-size: 400%;    color: #3061bc;"></i> -->
        </div>
        <div class="card-wrapper">
            @foreach($hospital->doctors as $item2)
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        <a href="{{ url('/doctors/' . $item2->id) }}" title="View Student"><i class="fa-solid fa-circle-info"></i></a>
                        <a href="{{ url('/hospitals/' . $item2->id . '/edit') }}" title="Edit Student"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form id="delete-form-{{ $item2->id }}" method="POST" action="{{ route('hospitals.destroy', $item2->id) }}" accept-charset="UTF-8" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <i class="fa-solid fa-trash-can trash_it" style="cursor:pointer" data-form-id="delete-form-{{ $item2->id }}"></i>
                        </form>
                    </div>
                    <img src="{{ asset('storage/images/a.webp') }}" alt="Profile Picture" class="card-img">
                </div>

                <div class="card-body">
                    <p class="card-text"><i class="fa-solid fa-circle-h"></i> {{ $item2->first_name}}</p>
                    <p class="card-text"><i class="fa-solid fa-phone"></i> {{ $item2->first_name }}</p>
                    <p class="card-title"><i class="fa-solid fa-location-dot"></i>{{ $item2->first_name }} </p>
                    <p class="card-text"><i class="fa-solid fa-stethoscope"></i> {{ $item2->first_name }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="card-container" style="flex-direction: column;">
        <div class="icon">
            <!-- <i class="fa-solid fa-user-injured" style="font-size: 400%;    color: #3061bc;"></i> -->
            <i class="fa-regular fa-calendar-check" style="font-size: 400%;    color: #3061bc;"></i>
        </div>
        <div class="card-wrapper">
            @foreach($hospital->doctors as $item2)
            <div class="card">
                <div class="card-header">
                    <div class="card-actions">
                        <a href="{{ url('/doctors/' . $item2->id) }}" title="View Student"><i class="fa-solid fa-circle-info"></i></a>
                        <a href="{{ url('/hospitals/' . $item2->id . '/edit') }}" title="Edit Student"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form id="delete-form-{{ $item2->id }}" method="POST" action="{{ route('hospitals.destroy', $item2->id) }}" accept-charset="UTF-8" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <i class="fa-solid fa-trash-can trash_it" style="cursor:pointer" data-form-id="delete-form-{{ $item2->id }}"></i>
                        </form>
                    </div>
                    <img src="{{ asset('storage/images/a.webp') }}" alt="Profile Picture" class="card-img">
                </div>

                <div class="card-body">
                    <p class="card-text"><i class="fa-solid fa-circle-h"></i> {{ $item2->first_name}}</p>
                    <p class="card-text"><i class="fa-solid fa-phone"></i> {{ $item2->first_name }}</p>
                    <p class="card-title"><i class="fa-solid fa-location-dot"></i>{{ $item2->first_name }} </p>
                    <p class="card-text"><i class="fa-solid fa-stethoscope"></i> {{ $item2->first_name }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>



    <style>
        .card-container {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .card-wrapper {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 10px;
        }

        .card {
            flex: 0 0 auto;
            /* Prevent cards from shrinking */
            width: 300px;
            /* Width of each card */
            margin-right: 10px;
            /* Space between cards */
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            position: relative;
        }

        .card-img {
            width: 100%;
            height: auto;
        }

        .card-actions i {
            margin: 0 5px;
            cursor: pointer;
        }
    </style>

    <script>
        $(document).ready(function() {
            let isDown = false;
            let startX;
            let scrollLeft;

            const container = $('.card-wrapper')[0];

            container.addEventListener('mousedown', (e) => {
                isDown = true;
                container.classList.add('active');
                startX = e.pageX - container.offsetLeft;
                scrollLeft = container.scrollLeft;
            });

            container.addEventListener('mouseleave', () => {
                isDown = false;
                container.classList.remove('active');
            });

            container.addEventListener('mouseup', () => {
                isDown = false;
                container.classList.remove('active');
            });

            container.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - container.offsetLeft;
                const scroll = (x - startX) * 2;
                container.scrollLeft = scrollLeft - scroll;
            });
        });
    </script>






























</div>





<script>
    $(document).ready(function() {
        handleDeleteConfirmation('.trash_it', 'Do you want to Trash this item?', 'Trash');
    });
</script>




@stop