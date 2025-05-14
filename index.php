<?php include 'includes/header.php'; ?>
   
    <!-- Banner -->

<div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="istockphoto-2196933783-2048x2048.jpg" class="d-block w-100 banner-img" alt="Banner 1">
    </div>
    <div class="carousel-item">
      <img src="istockphoto-1468573664-2048x2048.jpg" class="d-block w-100 banner-img" alt="Banner 2">
    </div>
  </div>

    
    <!-- Felcha-->
  <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
    <span class="visually-hidden">Siguiente</span>
  </button>
</div>


<div class="container mt-5">
    <h1 class="text-center">Bienvenida a la mejor Escuela de Fútbol</h1>
    <p class="text-center">¡Únete a nosotros y diviértete!</p>
</div>

<div class="container mt-5">
    <h2 class="text-center mb-4">Conviértete en un verdadero profesional</h2>
    
    <!-- Categorías -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="photo-1579952363873-27f3bade9f55.jpg" class="card-img-top" alt="Jugadores">
                <div class="card-body">
                    <h5 class="card-title">Jugadores</h5>
                    <p class="card-text">Revisa tus estadísticas</p>
                    <a href="administrar/jugadores.php" class="stretched-link"></a>

                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="photo-1603796846097-bee99e4a601f.jpg" class="card-img-top" alt="Padres">
                <div class="card-body">
                    <h5 class="card-title">Padres</h5>
                    <p class="card-text">Registra a tu hijo en solo un clic</p>
                    <a href="administrar/registro_jugador.php" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="premium_photo-1661962978096-9d03e3a43e97.jpg" class="card-img-top" alt="Entrenadores">
                <div class="card-body">
                    <h5 class="card-title">Entrenadores</h5>
                    <p class="card-text">Gestiona tu equipo</p>
                    <a href="administrar/entrenador.php" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón -->
    <div class="text-center mt-4 mb-5">
        <a href="administrar/registro_jugador.php" class="btn btn-lg btn-primary">¡ÚNETE A NOSOTROS!</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
