<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
        <img src="<?= base_url('assets/dist/img/AdminLTELogo.png') ?>" 
             alt="AdminLTE Logo" 
             class="brand-image img-circle elevation-3" 
             style="opacity: .8">
        <span class="brand-text font-weight-light">Administración</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('documents') ?>" class="nav-link">
                        <i class="nav-icon fas fa-file-pdf"></i>
                        <p>Documentos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('categories') ?>" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Categorías</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('reports') ?>" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Reportes</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</aside>