<div class="sticky-top">

    <nav class="shadow my-navbar navbar navbar-expand-lg navbar-dark my-bg py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center w-100">
                <!-- Logo -->
                <div class="col-lg-4 col-sm-4 logo d-flex align-items-center gap-3 mb-3 mb-lg-0 mb-md-0">
                    <img src="{{ asset(get_my_app_config('logo')) }}" alt="logo" style="width: 60px; height: 60px;">
                    <div class="d-flex flex-column">
                        <h1 class="text-white">
                            <a href="{{ route('home') }}" class="text-decoration-none fw-bold text-white">
                                {!! get_my_app_config('nama_web') !!}
                            </a>
                        </h1>
                    </div>
                </div>
                <!-- Navbar Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <!-- Navbar Menu -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light my-btn btn-rounded p-2 px-4"
                            href="{{ route('login') }}">Masuk</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


</div>
