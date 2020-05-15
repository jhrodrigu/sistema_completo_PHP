<?php 

  require_once "../modelos/Categoria.php";

  $categoria = new Categoria();

  $idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]): "";
  $idcategoria=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]): "";
  $idcategoria=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]): "";

  switch($_GET["op"]){
    case 'guardaryeditar':
      if(empty($idcategoria)){
        $rspta=$categoria->insertar($nombre,$descripcion);
        echo $rspta ? "Categoria registrada" : "Categoria no se pudo registrar";
      }else{
        $rspta=$categoria->editar($idcategoria,$nombre,$descripcion);
        echo $rspta ? "Categoria actualizar" : "Categoria no se pudo actualizar";
      }

    break;

    case 'desactivar':
      $rspta=$categoria->desactivar($nombre,$descripcion);
        echo $rspta ? "Categoria Desactivada" : "Categoria no se pudo Desactivada";
    break;

    case 'activar':
      $rspta=$categoria->activar($nombre,$descripcion);
        echo $rspta ? "Categoria activada" : "Categoria no se pudo activar";
    break;

    case 'mostrar':
      $rspta=$categoria->mostrar($idcategoria);
      //  Codificar el resultado utilizando Json
      echo json_encode($rspta);
    break;

    case 'listar':
      $rspta=$categoria->listar();
      // Vamos a declarar un array
      $data = Array();

      while ($reg=$rspta->fetch_object()){
        $data[]=array(
          "0"=>$reg->idcategoria,
          "1"=>$reg->nombre,
          "2"=>$reg->descripcion,
          "3"=>$reg->condicion
        );
      }
      $results = array(
        "sEcho"=>1, //Informacion para la base de datos
        "iTotalRecords"=>count($data), //Enviamos el total registros al datatable
        "iTotalDisplayRecords"=>count($data), //Enviamos el total registros a visualizar
        "aaData"=>$data);

        echo json_encode($results);
    break;
  }

?> 