<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("modelos/conexion.php");
include_once("lib/functions.php");


/*
Título de la ventana ()<title></title>).
Si se deja vacio se utilizará el valor predeterminado de master.php
*/
$tituloHTML = "";

/*
Clase para el body. Opcional, dejar vacio si no se necesita.
*/
$claseBody = "";

/* AQUÍ VA EL MODELO */



/* AQUÍ VA LA LÓGICA PHP */



ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */

.aside {
  /* min-height: 100%;
  width: 240px;
  position: absolute;
  border-right: 2px solid #9d9d9d;
  box-sizing: border-box;
  text-align: center; */
}

.enlace-aside {
  color: #9d9d9d;
  font-size: 20px;
  background-color: transparent;
  text-decoration: none;

}

.pag-ayuda-contenido {
  padding-left: 250px;
}

.pag-ayuda-box {
  color: rgb(10,52,66);
  background-color: #f5f5f5;
  width: 100%;
}

.pag-ayuda-lista li {
  color: rgb(10,52,66);
  background-color: #f5f5f5;
}

</style>

<div class="container-fluid contenido-main">
  <!-- AQUÍ VA EL CONTENIDO -->

  <aside class="aside col-md-4">
    <!-- Este es el boton desplegable de CATEGORIAS que va en el aside -->
    <ul class="list-group pag-ayuda-lista">
      <li class="list-group-item"><a href="#1">Solucionar problemas relacionados con la reproducción de vídeos</a></li>
      <li class="list-group-item"><a href="#2">Solucionar problemas relacionados con la conexión a Internet o la del dispositivo</a></li>
      <li class="list-group-item"><a href="#3">El vídeo se entrecorta o termina antes de tiempo</a></li>
      <li class="list-group-item"><a href="#4">Barras negras en los vídeos</a></li>
      <li class="list-group-item"><a href="#5">Vídeo no disponible en mi país</a></li>
      <li class="list-group-item"><a href="#6">Pantalla completa inhabilitada</a></li>
      <li class="list-group-item"><a href="#7">Este navegador no ofrece todas las opciones de calidad disponibles para los vídeos de Olrait</a></li>
      <li class="list-group-item"><a href="#8">Borrar la caché y las cookies</a></li>
    </ul>
  </aside>



  <div class="box col-md-8">
    <div class="row">
      <a id="1"></a>
      <div class="col-md-10 pag-ayuda-box"><br/>
        <h2>Solucionar problemas relacionados con la reproducción de vídeos</h2>
        <p>Los problemas de reproducción de vídeos de Olrait pueden deberse a muchos motivos. Es posible que puedas verlos solo con arreglar la conexión a Internet o la del dispositivo. Si aparece alguna de estas notificaciones, es posible que se trate de un problema de carga del vídeo:</p>
        <ul>
          <li>Se ha producido un error.</li>
          <li>Error de reproducción. Toca para volver a intentarlo.</li>
          <li>Se ha perdido la conexión al servidor.</li>
          <li>Este vídeo no está disponible.</li>
        </ul>

        <br/>
        <a id="2"></a>
        <br/>

        <h2>Solucionar problemas relacionados con la conexión a Internet o la del dispositivo</h2>
        <p> Sigue estos pasos relacionados con la conexión a Internet o la del dispositivo para poder ver vídeos en Olrait.</p>
        <p>Velocidad de internet: </p>
        <ul>
          <li>La calidad de la conexión a Internet de tu casa o la red móvil puede afectar en gran medida a la reproducción de los vídeos. Para ver vídeos de Olrait, necesitas una conexión a Internet o móvil con una velocidad de descarga de 500 Kbps como mínimo. Para ver vídeos de alta definición, la velocidad de descarga debe ser como mínimo de 7 Mbps. </li>
        </ul>
        <p>Ordenadores:</p>
        <ul>
          <li>Si tienes muchas pestañas abiertas en el navegador, prueba a cerrarlas todas menos la que estás usando para Olrait.</li>
          <li>Reinicia el navegador.</li>
          <li>Reinicia el router.</li>
          <li>Reinicia el ordenador.</li>
          <li>Actualiza el navegador a la última versión.</li>
        </ul>

        <br/>
        <a id="3"></a>
        <br/>

        <h2>El vídeo se entrecorta o termina antes de tiempo</h2>
        <p>Si un vídeo no se reproduce de forma continua (se detiene e inicia mientras lo ves) o termina antes de tiempo, prueba con estos pasos para resolver el problema:</p>
        <ul>
          <li>Comprueba la conexión a Internet. Necesitas una conexión de banda ancha con una velocidad mínima de 500 Kbps para conseguir la mejor experiencia de visualización.</li>
          <li>Pon en pausa el vídeo. Deja que se cargue la barra gris de la parte inferior del reproductor. Prueba a ver el vídeo de nuevo.</li>
          <li>Cambia la calidad del vídeo a una más baja para ver si el vídeo se carga.</li>
          <li>Si el vídeo sigue sin cargarse, borra la caché y las cookies del navegador y prueba a ver el vídeo de nuevo.</li>
        </ul>

        <br/>
        <a id="4"></a>
        <br/>

        <h2>Barras negras en los vídeos</h2>
        <p>Tal vez veas algunos vídeos panorámicos con barras negras alrededor. Aquí te explicamos por qué pueden aparecer así:</p>
        <ul>
          <li>El archivo de vídeo incluye unas barras negras horizontales (formato de buzón) en la parte superior e inferior del reproductor de vídeo para presentar una relación de aspecto de 4:3.</li>
          <li>Nuestro reproductor de 16:9 añade barras verticales (formato de pilares) para ajustar un vídeo de formato 4:3 a las dimensiones del reproductor de Olrait.</li>
          <li>El resultado final es que aparecen barras negras alrededor del vídeo (formato de ventana)</li>
        </ul>

        <br/>
        <a id="5"></a>
        <br/>

        <h2>Vídeo no disponible en mi país</h2>
        <p>Es posible que algunos vídeos de Olrait no puedan verse en tu país por las siguientes razones:</p>
        <ul>
          <li>El propietario ha decidido que su vídeo solo se vea en determinados países (normalmente por los derechos de licencia).</li>
          <li>Olrait puede bloquear determinados contenidos para cumplir con las leyes locales.</li>
        </ul><br/><br/>

        <br/>
        <a id="6"></a>
        <br/>

        <h2>Pantalla completa inhabilitada</h2>
        <p>Si tienes problemas para abrir el modo de pantalla completa en Olrait, aquí tienes algunos trucos que puedes seguir:</p>
        <h4>Comprueba los permisos del navegador</h4>
        <p>Si aparece el botón de pantalla completa pero al pinchar en él no pasa nada, es posible que tengas los permisos de pantalla completa inhabilitados para Olrait. Comprueba la configuración y permisos de tu navegador para asegurarte de que la pantalla completa está disponible en las páginas donde podrías usar Olrait.</p>
        <h4>Comprueba las extensiones y complementos del navegador</h4>
        <p>Algunas extensiones y complementos podrían bloquear el modo de pantalla completa. Comprueba los de tu navegador y cambia los ajustes como corresponda.</p>
        <h4>Otros motivos por los que la pantalla completa podría estar inhabilitada</h4>
        <p>Este problema también puede deberse a lo siguiente:</p>
        <ul>
          <li>El navegador podría no ser compatible con la pantalla completa.</li>
          <li>El propietario del sitio web que ha insertado un reproductor de Olrait ha inhabilitado la pantalla completa.</li>
        </ul>

        <br/>
        <a id="7"></a>
        <br/>

        <h2>Este navegador no ofrece todas las opciones de calidad disponibles para los vídeos de Olrait</h2>
        <p>Los vídeos de Olrait están disponibles en varios formatos y resoluciones. No obstante, algunos navegadores no son compatibles con los nuevos formatos de vídeo y solo permiten elegir entre uno o dos formatos. Si quieres disfrutar de la mejor experiencia de visualización, te recomendamos actualizar el navegador o el sistema operativo.</p>
        <p>A continuación se muestran algunas combinaciones de navegadores y sistemas operativos compatibles con los formatos de vídeo de mayor calidad de Olrait:</p>
        <ul>
          <li>Google Chrome (todos los sistemas operativos)</li>
          <li>Internet Explorer o Edge en Windows 8.1 o una versión posterior</li>
          <li>Safari en Mac OS X 10.10 o una versión posterior</li>
          <li>Firefox en Windows 7 o una versión posterior y en Mac OS X 10.10 o una versión posterior</li>
        </ul><br/><br/>

        <br/>
        <a id="8"></a>
        <br/>

        <h2>Borrar la caché y las cookies</h2>
        <p>Las cookies son archivos que crean los sitios web que visitas, mientras que la caché de tu navegador ayuda a que las páginas se carguen más rápido para que puedas navegar por Internet más fácilmente.</p>
        <p>Si borras las cookies y la caché del navegador, se eliminará la configuración de los sitios web (como los nombres de usuario y las contraseñas), lo que puede provocar que algunos de ellos funcionen más lentamente debido a que tienen que volver a cargar todas las imágenes.</p>
        <h4>Cómo borrar la caché y las cookies en Google Chrome</h4>
        <ul>
          <li>Abre Chrome</li>
          <li>En la barra de herramientas del navegador, toca Más</li>
          <li>Ve a Más herramientas y, a continuación, haz clic en Borrar datos de navegación.</li>
          <li>En el cuadro "Borrar datos de navegación", marca las casillas Cookies y otros datos de sitios y de complementos y Archivos e imágenes almacenados en caché.</li>
          <li>Usa el menú de la parte superior para seleccionar la cantidad de datos que quieres eliminar. Selecciona el origen de los tiempos para eliminar todo.</li>
          <li>Haz clic en Eliminar datos de navegación.</li>
        </ul><br/><br/>

      </div>
    </div>
  </div>

</div>

<script type="text/javascript">
/* AQUÍ VA EL JAVASCRIPT */

</script>

<?php
/* NO TOCAR ESTO */
$contenidoPagina = ob_get_clean();
include_once("master.php");
?>
