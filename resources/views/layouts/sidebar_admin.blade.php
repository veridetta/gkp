 <nav id="sidebar" class="sidebar js-sidebar fixed my-bg-secondary">
     <div class="sidebar-content js-simplebar my-bg-secondary">
         <a class="sidebar-brand" href="#">
            {{-- <img src="{{ asset('img/logo.png') }}" alt="logo" class="img-fluid" width="50"> --}}
            <span class="align-middle">{{ get_my_app_config('nama_web') }}</span>
         </a>

         <ul class="sidebar-nav">
             <li class="sidebar-item @if (request()->routeIs('admin.dashboard')) active @endif">
                 <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.dashboard') }}">
                     <i class="align-middle fa fa-home"></i> <span class="align-middle">Dashboard</span>
                 </a>
             </li>

                <li class="sidebar-item @if (request()->routeIs('admin.residence.*')) active @endif">
                    <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.residence.index') }}">
                        <i class="align-middle fa fa-building"></i> <span class="align-middle">Data Warga</span>
                    </a>
                </li>
                <li class="sidebar-divider"></li>

                <li class="sidebar-item @if (request()->routeIs('admin.category.*')) active @endif">
                    <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.category.index') }}">
                        <i class="align-middle fa fa-list"></i> <span class="align-middle">Kategori Iuran</span>
                    </a>
                </li>
                <li class="sidebar-item @if (request()->routeIs('admin.payment.*')) active @endif">
                    <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.payment.index') }}">
                        <i class="align-middle fa fa-file"></i> <span class="align-middle">Iuran Warga</span>
                    </a>
                </li>
                <li class="sidebar-divider"></li>
                <li class="sidebar-item @if (request()->routeIs('admin.cashflow.*')) active @endif">
                    <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.cashflow.index') }}">
                        <i class="align-middle fa fa-money-bill"></i> <span class="align-middle">Data Kas</span>
                    </a>
                </li>
                <li class="sidebar-divider"></li>
                <li class="sidebar-item @if (request()->routeIs('admin.position.*')) active @endif">
                    <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.position.index') }}">
                        <i class="align-middle fa fa-user"></i> <span class="align-middle">Data Jabatan</span>
                    </a>
                </li>
                <li class="sidebar-item @if (request()->routeIs('admin.pengurus.*')) active @endif">
                    <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.pengurus.index') }}">
                        <i class="align-middle fa fa-user"></i> <span class="align-middle">Data Petugas</span>
                    </a>
                </li>


         </ul>
     </div>
 </nav>
