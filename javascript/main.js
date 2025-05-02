document.addEventListener("DOMContentLoaded", () => {
    const carousel = document.querySelector('.carousel');
    if (carousel) {
        const bsCarousel = new bootstrap.Carousel(carousel, {
            interval: 5000,
            ride: 'carousel'
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    console.log("JavaScript cargado correctamente.");

    // Ejemplo: animación simple al hacer hover en las filas de tabla
    const filas = document.querySelectorAll("table tbody tr");
    filas.forEach(fila => {
        fila.addEventListener("mouseenter", () => fila.style.backgroundColor = "#e2e6ea");
        fila.addEventListener("mouseleave", () => fila.style.backgroundColor = "");
    
    });
});
