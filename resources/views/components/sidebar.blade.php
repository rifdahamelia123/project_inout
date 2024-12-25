<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">InOutWarehouse</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">InOut</a>
        </div>
        
        <ul class="sidebar-menu">
            <!-- Link ke Dashboard -->
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>

            <!-- Link ke Data Barang -->
            <li class="nav-item">
                <a href="{{ route('barang.index') }}" class="nav-link">
                    <i class="fas fa-box"></i><span>Data Barang</span>
                </a>
            </li>
             <!-- Link ke Log Barang -->
             <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-book"></i><span>Trafic Barang</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('barang_masuk.index') }}">Barang Masuk</a>
                    </li>
                    <li>
                    <li><a class="nav-link" href="{{ route('barang_keluar.index') }}">Barang Keluar</a>
                    </li>
</ul>

            <!-- Link ke Traffic Barang -->
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-chart-line"></i><span>Log </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                    <a class="nav-link" href="{{ route('log_masuk.index') }}">Log Barang Masuk</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('log_keluar.index') }}">Log Barang Keluar</a>
                    </li>
                </ul>
            </li>
            </li>
        </ul>
    </aside>
</div>
