<div class="hero-welcome w-100" style="background: url('{{ get_my_app_config('hero_bg') }}'); background-size:cover; background-position: center;">
    <div class="content text-light" style="left:20px;">
        <h1 class="fw-bold text-capitalize">{{ get_my_app_config('nama_web') }}
        </h1>
        <h4 class="mb-5 pe-5">Selamat Datang di Website {{ get_my_app_config('nama_web') }} </h4>
        <p class="p-2  text-justify fw-bold h4 mt-4">
            {{ get_my_app_config('nama') }}
        </p>
        <p class="p-2 text-justify">
            {{ get_my_app_config('alamat') }}
        </p>
    </div>
</div>
