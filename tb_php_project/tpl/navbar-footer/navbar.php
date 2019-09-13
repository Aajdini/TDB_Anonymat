<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a class="nav-link" href="#">Espace public</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">Espace privée</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="#">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2 dropleft">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Connecté
                </a>
                <div class="dropdown-menu text-center" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"><i class="fas fa-user"></i><?php echo " ".$name_session_usr ?></a>
                    <a class="dropdown-item" href="#"><i class="fas fa-user-cog"></i></a>
                    <div class="dropdown-divider"></div>
                    <a href="../../inc/db/deconnexion.php" class="btn btn-danger active" role="button" aria-pressed="true"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </li>
        </ul>
    </div>

</nav>