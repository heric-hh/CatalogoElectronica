<?php

CONST CARPETA_IMAGENES = __DIR__ . "/../views/assets/img_productos/";
const IMAGENES_DIR = "./views/assets/img_productos/";

function debug(mixed $var) : never {
  echo "<pre>";
  var_dump($var);
  echo "</pre>";
  exit;
}

function mostrarMensajes(int $codigo) : string {
  $mensaje = "";
  switch($codigo) {
    case 1: 
      $mensaje = "Creado Correctamente";
      break;
    case 2:
      $mensaje = "Actualizado Correctamente";
      break;
    case 3:
      $mensaje = "Eliminado Correctamente";
      break;
    default:
      $mensaje = false;
      break;
  }
  return $mensaje;
}

function validarORedireccionar(string $ruta) : int {
  $id = $_GET["id"];
  $id = filter_var($id, FILTER_VALIDATE_INT);
  if(!$id) {
    header("Location: $ruta");
  }
  return $id;
}
