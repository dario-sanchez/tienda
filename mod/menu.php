<header class="bg-white shadow">
    <div class="container-fluid">
        <div class="row  bg-tsplus">
            <div class="container p-2 text-center text-white">
                <a href="/tienda/" class="text-white text-decoration-none">
                    <h4 class="fw-bold">
                        Tienda
                    </h4>
                </a>
            </div>
        </div>
        <div class="row px-5">
            <div class="col-auto p-3">
                <img src="/image/logo.png" alt="TSPlus" style="width: 370px; height: auto;">
            </div>
            <div class="col">
                <nav class="navbar navbar-expand-lg navbar-light bg-light h-100">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-bold">
                                <li class="nav-item px-4">
                                    <a class="nav-link" href="https://tsplus.mx/">Inicio</a>
                                </li>
                                <li class="nav-item px-4 dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-bs-toggle="dropdown">
                                        Soluciones
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="https://tsplus.mx/remote-access-2022/">
                                                <img src="/tienda/img/Remote-Access.png" alt="Remote access" style="width: 210px; height: auto;">
                                            </a>
                                            <a class="dropdown-item" href="https://tsplus.mx/advanced-security-2022/">
                                                <img src="/tienda/img/ADVANCE-SEC.png" alt="Advanced Security" style="width: 210px; height: auto;">
                                            </a>
                                            <a class="dropdown-item" href="https://tsplus.mx/2fa-2022/">
                                                <img src="/tienda/img/2FA.png" alt="Two Factor Authentication" style="width: 210px; height: auto;">
                                            </a>
                                            <a class="dropdown-item" href="https://tsplus.mx/server-monitoring-2022/">
                                                <img src="/tienda/img/SERVER-MON.png" alt="Server monitoring" style="width: 210px; height: auto;">
                                            </a>
                                            <a class="dropdown-item" href="https://tsplus.mx/remote-work-2022/">
                                                <img src="/tienda/img/REMOTE-WORK.png" alt="Remote work" style="width: 210px; height: auto;">
                                            </a>
                                            <a class="dropdown-item" href="https://tsplus.mx/remote-support-2022/">
                                                <img src="/tienda/img/REMOTE-SUPPORT.png" alt="Remote support" style="width: 210px; height: auto;">
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item px-4">
                                    <a class="nav-link" href="https://tsplus.mx/descarga-2022/">Descargas</a>
                                </li>
                                <li class="nav-item px-4">
                                    <a class="nav-link" href="https://tsplus.mx/recursos-2022/">Recursos</a>
                                </li>
                                <li class="nav-item px-4">
                                    <a class="nav-link" href="https://tsplus.mx/contacto-2022/">Contacto</a>
                                </li>
                                <?php if (isset($_SESSION['usuario_id'])) : ?>
                                    <li class="nav-item px-4">
                                        <button class="btn btn-link text-tsplus float-end" id='btnLogout'>Salir</button>
                                    </li>
                                <?php endif; ?>


                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<div class="bg-dark shadow" style="background: url(/tienda/img/tech-bg.jpg) no-repeat center center fixed; background-size: cover;">
    <div class="container px-3 py-5 text-tsplus  text-center">
        <div class="py-5">
            <h1 class="fw-bolder">TERMINAL SERVICE PLUS</h1>
            <h5 class="text-white">All-in-one solution for Remote Access and Web Portal</h5>
        </div>
    </div>
</div>
<!---------
<div class="container mt-3">
    <swiper-container slides-per-view="1" speed="500" loop="true" autoplay='true'>
        <swiper-slide><a href="https://hotsale.tsplus.neogenesys.com/"><img src="./img/hot-sale-1.png" class="img-fluid" alt=""></a></swiper-slide>
        <swiper-slide><a href="https://hotsale.tsplus.neogenesys.com/"><img src="./img/hot-sale2.png" class="img-fluid" alt=""></a></swiper-slide>
        >
    </swiper-container>
</div>
--->
