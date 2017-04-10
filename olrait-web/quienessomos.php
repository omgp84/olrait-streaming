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
/*Aquí definimos la separación del titulo del texto inferior*/
.texto-quienes-somos {
  margin: 20px 0 60px 0;
  text-align: center
}

/*La forma y el tamaño del texto inferior*/
.letra-texto {
  font-family: 'Euphorigenic';
  font-size: 20px;
  text-align: center;
}

/*El tamaño y la posición de la imagen con respecto al texto a su izquierda
.imagen-gafas {
  border:7px solid black;
}*/

/*Titulo del bloque de contactos*/
.titulo-contactos-quienes-somos{
  text-align: center;
  margin: 50px 0 10px 0;
}

/*Separación del bloque de contactos con respecto al título*/
.estructura-contacto-nosotros {
  margin-top: 20px;
  padding: 0;
}

/*Tamaño y forma de las imagenes de los creadores*/
.imagen-nosotros{
  border-radius: 100%;
  width: 400px;
  height: 100%;
  padding: 0 15px;
}
/*Datos de los creadores*/
.datos-nosotros {
	position: absolute;
  opacity: 0;
	top: 0;
  right: 0;
  left: 0;
  bottom: 0;
	background-color: rgba(0,0,0,0.5);
	color: #fff;
  border-radius: 100%;
  margin: 0 15px;
}
/*Opacidad en los datos de los creadores*/
.datos-nosotros:hover {
  opacity: 1;
}
/*Separación de este con respecto al bloque superior*/
.contactos-quienes-somos{
  margin: 20px;
}

/*Texto del hover de los creadores*/
.texto-nosotros {
  width: 100%;
  height: 100%;
  text-align: center;
  padding-top: 50px;
}
/*Texto tipo cabecera del hover de los creadores*/
.texto-nosotros h4 {
  line-height: 20px;
  font-weight: bolder;
  font-family: inmAdam;
}
/*Color del enlace que aparece en el texto del hover de los creadores*/
.texto-nosotros a {
  color: #fff;
}
/*Color y formas del ancla*/
.ancla-nosotros{
  color: #e8e8e8;
}
.ancla-nosotros:hover{
  text-decoration: none;
  color:#e8e8e8;
}

/*Tipo de fuente especial utilizada en esta página*/
@font-face {
  font-family: Euphorigenic;
  src: url(css/fonts/Euphorigenic/Euphorigenic.ttf);
}

/*Estructura de la pagina al reducir la ventana a cierto tamaño, el cual lo se puede modificar cuando sea necesario*/
@media screen and (max-width:800px){
  .texto-quienes-somos{
    margin: 0 0 0 0;
  }
  /*
  .imagen-gafas{
    display: none;
  }
  */
  .imagen-nosotros{
    width: 400px;
    height: 100%;
  }

  .contactos-quienes-somos{
    margin: 0;
  }
}

</style>

<div class="container-fluid contenido-main">
  <!-- AQUÍ VA EL CONTENIDO -->

<!---->
  <div class="container">
    <div class="pull-left contenido-texto" >
      <h1 class="texto-quienes-somos" >¿Quiénes somos?</h1>
      <div class="letra-texto">
        <p>Olrait Streming! es una empresa fundada en 2017 con sede en Badajoz.</p>
        <p>Está compuesta por seis jóvenes apasionados de la programación.</p>
        <p>Entre nosotros hay programadores, electricistas, administrativos, documentalistas y periodistas.</p><br/>
        <p>Nuestro objetivo es retransmitir videos y audios para poner en comunicación</p>
        <p> a todos nuestros usuarios. </p>
        <p>Gracias a Fundación Telefónica nos hemos juntado y creado</p>
        <p>este maravilloso proyecto con ilusión y ganas.</p>
        <p>Si os gusta, no dudeis en poneros en contacto con nosotros :) Olrait!.</p>
      </div>

    <!--</div>
    <img class="pull-right imagen-gafas" SRC="img/landing/mesa1.png">
  </div>-->

<!--FIN CONTENIDO MITAD SUPERIOR-->
<!--COMIENZO CONTENIDO CONTACTOS-->
  <a class="ancla-nosotros" href="#contactos"><h1 class="titulo-contactos-quienes-somos">PERSONAS INVOLUCRADAS</h1></a>
  <div></div>
  <div class="row contactos-quienes-somos">
    <div class="estructura-contacto-nosotros col-md-3 col-lg-3 col-xs-6 col-sm-6">
      <img src="img/sobre/nosotros1.jpg" class="imagen-nosotros img-responsive img-circle"/>
      <div class="datos-nosotros">
        <div class="texto-nosotros">
          <h4>Oscar Miguel Gonzalez</h4>
          <h4><a href="https://www.linkedin.com/in/oscar-miguel-gonzalez-perez/" target="_blank">Linkedin</a></h4>
        </div>
      </div>
    </div>
    <div class="estructura-contacto-nosotros col-md-3 col-lg-3 col-xs-6 col-sm-6">
      <img src="img/sobre/nosotros2.jpg" class="imagen-nosotros img-responsive img-circle"/>
      <div class="datos-nosotros">
        <div class="texto-nosotros">
          <h4>Alberto Cabrera</h4>
          <h4><a href="https://www.linkedin.com/in/acabcen/" target="_blank">Linkedin</a></h4>
        </div>
      </div>
    </div>
    <div class="estructura-contacto-nosotros col-md-3 col-lg-3 col-xs-6 col-sm-6">
      <img src="img/sobre/nosotros3.jpg" class="imagen-nosotros img-responsive img-circle"/>
      <div class="datos-nosotros">
        <div class="texto-nosotros">
          <h4>Pablo Fernández</h4>
          <h4><a href="https://www.linkedin.com/in/pablo-fern%C3%A1ndez-navarro-103baa124/" target="_blank">Linkedin</a></h4>
        </div>
      </div>
    </div>
    <div class="estructura-contacto-nosotros col-md-3 col-lg-3 col-xs-6 col-sm-6">
      <img src="img/sobre/nosotros4.jpg" class="imagen-nosotros img-responsive img-circle"/>
      <div class="datos-nosotros">
        <div class="texto-nosotros">
          <h4>Jose Manuel Granadero</h4>
          <h4><a href="https://www.linkedin.com/in/jos%C3%A9-manuel-granadero-estrada/" target="_blank">Linkedin</a></h4>
        </div>
      </div>
    </div>

    <div class="row contactos-quienes-somos">
    <div class="estructura-contacto-nosotros col-md-offset-3 col-md-3 col-lg-3 col-xs-6 col-sm-6">
      <img src="img/sobre/nosotros6.jpg" class="imagen-nosotros img-responsive img-circle"/>
      <div class="datos-nosotros">
        <div class="texto-nosotros">
          <h4>Eva Pérez</h4>
          <h4><a href="https://www.linkedin.com/in/eva-p%C3%A9rez-gonz%C3%A1lez/" target="_blank">Linkedin</a></h4>
        </div>
      </div>
    </div>
    <div class="estructura-contacto-nosotros col-md-3 col-lg-3 col-xs-6 col-sm-6">
      <img src="img/sobre/nosotros5.jpg" class="imagen-nosotros img-responsive img-circle"/>
      <div class="datos-nosotros">
        <div class="texto-nosotros">
          <h4>Violeta Macías</h4>
          <h4><a href="https://www.linkedin.com/in/violeta-macias-montero-735703131/" target="_blank">Linkedin</a></h4>
        </div>
      </div>
    </div>
    </div>
  </div>
<!--FIN CONTENIDO CONTACTOS-->

  <a id="contactos"></a>
<!---->
  <div class="clearfix"></div>
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
