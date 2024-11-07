<?php

session_start();

?>


<?php 
/* PRINCIPIO DRY
o	No repitas el código en distintas partes del sistema. Cualquier lógica repetida debería encapsularse en un solo lugar.
o	Esto facilita el mantenimiento, ya que los cambios se realizan en un solo lugar.

En este caso hice un archivo con el header por aparte para simplemente importarlo en cada vista
*/
include 'header.php'; 

?>




    <div id="in" class="container">
        <div class="content row">
            <div class="about-text col-lg-6 col-sm-12">
                <h2>Acerca</h2>
                <p>¿Quiénes somos?</p>
                <p>Somos una empresa nacional con siete años de trayectoria en el mercado, especializada en ofrecer de manera responsable una amplia gama de accesorios para fumar, como pipas de cristal, bongs, bubblers y otros productos similares. Nuestro compromiso se refleja en la calidad y variedad de nuestro catálogo, diseñado para satisfacer las necesidades de nuestros clientes más exigentes.</p>
                <p>Actualmente, estamos presentes en dos puntos de venta físicos estratégicamente ubicados y contamos con una plataforma de comercio electrónico. Esta plataforma no solo te permite explorar y adquirir nuestros productos desde la comodidad de tu hogar, sino que también ofrece la opción de apartarlos para recogerlos posteriormente en cualquiera de nuestras tiendas físicas. Así, aseguramos una experiencia de compra flexible y conveniente para todos nuestros clientes.</p>
            </div>
            <div class="about-img col-lg-6 col-sm-12"><img src="../IMG/img-inicio.jpg" alt="img descriptiva"></div>
        </div>
        <div class="brands">
            <div class="row">
                <div class="brand col-lg-4 col-sm-6"><a href="../SCRIPTS/cdss.php?marca=Blazy%20Susan"><img src="../IMG/blazy-susann.jpg" alt="blazy-susan"></a></div>
                <div class="brand col-lg-4 col-sm-6"><a href="../SCRIPTS/cdss.php?marca=Raw"><img src="../IMG/raww.jpg" alt="raw"></a></div>
                <div class="brand col-lg-4 col-sm-6"><a href="../SCRIPTS/cdss.php?marca=OCB"><img src="../IMG/ocbb.jpg" alt="ocb"></a></div>
                <div class="brand col-lg-4 col-sm-6"><a href="../SCRIPTS/cdss.php?marca=Rolling%20Circus"><img src="../IMG/lion-rolling-circuss.jpg" alt="lion-rolling-circus"></a></div>
                <div class="brand col-lg-4 col-sm-6"><a href="../SCRIPTS/cdss.php?marca=Hornet"><img src="../IMG/hornett.jpg" alt="hornet"></a></div>
                <div class="brand col-lg-4 col-sm-6"><a href="../SCRIPTS/cdss.php?marca=Cookies"><img src="../IMG/cookiess.jpg" alt="cookies"></a></div>
                <div class="brand col-lg-4 col-sm-6"><a href="../SCRIPTS/cdss.php?marca=Blunt%20Wrap"><img src="../IMG/blunt-wrapp.jpg" alt="blunt-wrap"></a></div>
                <div class="brand col-lg-4 col-sm-6"><a href="../SCRIPTS/cdss.php?marca=King%20Palm"><img src="../IMG/king-palmm.jpg" alt="king-palm"></a></div>
                <div class="brand col-lg-4 col-sm-6"><a href="../SCRIPTS/cdss.php?marca=G-rollz"><img src="../IMG/g-rollzzz.jpg" alt="g-roolz"></a></div>
            </div>
        </div>
        <div class="sucursales" id="suc">
            <h2>Nuestras Sucursales</h2>
            <div class="sucursal row">
                <div class="col-lg-6 col-sm-12">
                    <h3>Sucursal Nazas</h3>
                <p>Blvrd la Libertad 415B, Amp Valles del Nazas, 27083 Torreón, Coah.</p>
                <p>Horario:</p>
                    <p> Lunes a viernes de 10am - 8pm</p>
                    <p>Domingo de 12pm - 5pm</p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <img src="../IMG/s-trc.png" alt="Sucursal Nazas">
                </div>
                <div class="map col-12 col-sm-12">
                    <a href="https://www.google.com.mx/maps/place/La+Sombra+Trc+Smoke+shop/@25.5405521,-103.3611749,17z/data=!3m1!4b1!4m6!3m5!1s0x868fc51a3f557257:0x25ad69b0f36282d9!8m2!3d25.5405473!4d-103.3586!16s%2Fg%2F11q9g5qt61?entry=ttu" target="_blank"><img src="../IMG/maps-trc.png" alt="La Sombra Nazas"></a>
                </div>
            </div>
            <div class="sucursal row">
                <div class="col-lg-6 col-sm-12">
                    <h3>Sucursal Matamoros</h3>
                    <p>C. Lerdo, Vegas de Marrufo Poniente, 27440 Matamoros, Coah.</p>
                    <p>Horario:</p>
                    <p> Lunes a viernes de 12pm - 8pm</p>
                    <p>Domingo de 12pm - 5pm</p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <img src="../IMG/s-mt.jpeg" alt="Sucursal Matamoros">
                </div>
                <div class="map col-12 col-sm-12">
                    <a href="https://www.google.com.mx/maps/place/La+Sombra+matamoros+Smoke+shop/@25.5311862,-103.2340876,17z/data=!3m1!4b1!4m6!3m5!1s0x868fc7dbb1fe0731:0xc83e6cff72866461!8m2!3d25.5311862!4d-103.2315127!16s%2Fg%2F11sbd_9b99?entry=ttu" target="_blank"><img src="../IMG/maps-mt.png" alt="La Sombra Matamoros"></a>
                </div>
            </div>
        </div>
        <footer class="footer row">
            <div class="col-lg-11 text">
                <p>Somos una empresa nacional con una trayectoria de 7 años en el mercado, especializada en ofrecer de manera responsable una amplia gama de accesorios para fumar, como pipas de cristal, bongs, bubblers y otros productos similares. Nuestro compromiso se refleja en la calidad y variedad de nuestro catálogo, diseñado para satisfacer las necesidades de nuestros clientes más exigentes.</p>
            </div>
            <div class="col-lg-1 rs"><a href="https://www.facebook.com/people/La-Sombra-trc/100072525601731/" target="_blank"><img src="../ICONS/facebookwhite.png" alt="facebook"></a></div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>