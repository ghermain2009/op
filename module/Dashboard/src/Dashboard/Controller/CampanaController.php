<?php

namespace Dashboard\Controller;

use Dashboard\Form\CampanaForm;
use Dashboard\Form\CampanaseleccionopcionForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcDatagrid\Column;
use Zend\Session\Container;
use Zend\Json\Json;

class CampanaController extends AbstractActionController {

    public function indexAction() {
        $viewmodel = new ViewModel();
        $sl = $this->getServiceLocator();
        $empresaTable = $sl->get('Dashboard/Model/GenempresaTable');
        $form = new CampanaForm($empresaTable);
        $request = $this->getRequest();
        $serviceLocator = $this->getServiceLocator();
        $form->get('submit');
        $message = ""; //Message

        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                //echo $data['id_campana'];
                $data = $form->getData();
                $campanaTable = $serviceLocator->get('Dashboard\Model\CupcampanaTable');
                unset($data['submit']);
                $rs = $campanaTable->addCampana($data);
                if ($rs) {
                    //$form = new CampanaForm($empresaTable);
                    $this->redirect()->toRoute('dash_campana_edit', array('id' => $rs));
                }
            }
        }
        $viewmodel->form = $form;
        $viewmodel->message = $message;
        return $viewmodel;
    }

    public function listAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $postData = $request->getPost();
            if ($postData->btnAdd === 'add') {
                $this->redirect()->toRoute('dash_campana');
            }
        }

        $sl = $this->getServiceLocator();
        $dbAdapter = $sl->get('Zend\Db\Adapter\Adapter');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(5);
        $grid->setToolbarTemplate('layout/list-toolbar');
        $grid->setDataSource($sl->get('Dashboard\Model\CupcampanaTable')
                        ->getCampanaList(), $dbAdapter);

        $col = new Column\Select('id_campana', 'c');
        $col->setLabel('id');
        $col->setWidth(20);
        $col->setIdentity(true);
        $col->setSortDefault(1, 'ASC');
        $grid->addColumn($col);
        
        /*$col = new Column\Select('id_contrato');
        $col->setLabel('id_contrato');
        $col->setWidth(20);
        $col->setHidden(true);
        $grid->addColumn($col);*/
        
        $col = new Column\Select('subtitulo', 'c');
        $col->setLabel('Titulo Portada');
        $col->setWidth(20);
        $grid->addColumn($col);

        $col = new Column\Select('titulo', 'c');
        $col->setLabel('Titulo Detalle');
        $col->setWidth(20);
        $grid->addColumn($col);

        $col = new Column\Select('nombre_comercial', 'e');
        $col->setLabel('Empresa');
        $col->setWidth(15);
        $grid->addColumn($col);

        $editBtn = new Column\Action\Button();
        $editBtn->setLabel(' ');
        $editBtn->setAttribute('class', 'btn btn-success glyphicon glyphicon-edit');
        $editBtn->setAttribute('href', '/dashboard/campana/edit/id/' . $editBtn->getRowIdPlaceholder());
        $editBtn->setAttribute('data-toggle', 'tooltip');
        $editBtn->setAttribute('data-placement', 'left');
        $editBtn->setAttribute('title', 'Modificar Campaña');

        $preBtn = new Column\Action\Button();
        $preBtn->setLabel(' ');
        $preBtn->setAttribute('class', 'btn btn-warning glyphicon glyphicon-eye-close');
        $preBtn->setAttribute('href', 'javascript:visualizar(' . $preBtn->getRowIdPlaceholder().');');
        $preBtn->setAttribute('data-toggle', 'tooltip');
        $preBtn->setAttribute('data-placement', 'left');
        $preBtn->setAttribute('title', 'Preview Campaña');
        
        $conBtn = new Column\Action\Button();
        $conBtn->setLabel(' ');
        $conBtn->setAttribute('class', 'btn btn-info glyphicon glyphicon-list-alt');
        $conBtn->setAttribute('href', 'javascript:registraranexocontrato('. $conBtn->getRowIdPlaceholder().');');
        $conBtn->setAttribute('data-toggle', 'tooltip');
        $conBtn->setAttribute('data-placement', 'left');
        $conBtn->setAttribute('title', 'Contrato Campaña');
        
        $col = new Column\Action();
        $col->setWidth(7);
        $col->addAction($editBtn);
        $col->addAction($preBtn);
        $col->addAction($conBtn);
        $grid->addColumn($col);

        return $grid->getResponse();
        
    }

    public function editAction() {
        $serviceLocator = $this->getServiceLocator();

        $config = $serviceLocator->get('Config');
        $simbolo_moneda = $config['moneda']['simbolo'];
        $dir_image = $config['constantes']['dir_image'];
        $sep_path = $config['constantes']['sep_path'];

        $dir_imagenes = $config['rutas']['dir_principal'] .
                        $sep_path .
                        $config['rutas']['dir_imgcampanas'];
        
        $campanaId = $this->params('id');
        
        $ruta_imagenes = $dir_image . 
                    $sep_path . 
                    ".." .
                    $sep_path .
                    ".." .
                    $sep_path .
                    $dir_imagenes .
                    $sep_path .
                    $campanaId .
                    $sep_path;

        $edit_campana = new Container('edit_campana');
        $edit_campana->id = $campanaId;

        $request = $this->getRequest();
        $viewmodel = new ViewModel(array('dir_image' => $dir_image,
                                         'sep_path' => $sep_path,
                                         'simbolo_moneda' => $simbolo_moneda));
        $sl = $this->getServiceLocator();
        $empresaTable = $sl->get('Dashboard\Model\GenempresaTable');
        $campanaTable = $sl->get('Dashboard\Model\CupcampanaTable');
        $campanaOpcionTable = $sl->get('Dashboard\Model\CupcampanaopcionTable');
        $campanaCategoriaTable = $sl->get('Dashboard\Model\CupcampanacategoriaTable');

        $form = new CampanaForm($empresaTable);

        if ($request->isPost()) {
            // @TODO addfilters
            //$form->setInputFilter($filters);
            $dataPost = $request->getPost();
            $form->setData($dataPost);
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                $dataId = array('id_campana' => $campanaId);
                $campanaTable->editCampana($data, $dataId);

                if (trim($dataPost["id_categoria"]) != '') {
                    $campanaCategoriaTable->savecategorias($dataPost["id_categoria"], $campanaId);
                }
            }
        } else {
            $campanaData = $campanaTable->getCampana($campanaId);
            foreach ($campanaData as $campana) {
                $form->get('id_campana')->setValue($campana['id_campana']);
                $form->get('titulo')->setValue($campana['titulo']);
                $form->get('subtitulo')->setValue($campana['subtitulo']);
                $form->get('descripcion')->setValue($campana['descripcion']);
                $form->get('sobre_campana')->setValue($campana['sobre_campana']);
                $form->get('observaciones')->setValue($campana['observaciones']);
                $form->get('id_empresa')->setValue($campana['id_empresa']);
                $form->get('fecha_inicio')->setValue($campana['fecha_inicio']);
                $form->get('hora_inicio')->setValue($campana['hora_inicio']);
                $form->get('fecha_final')->setValue($campana['fecha_final']);
                $form->get('hora_final')->setValue($campana['hora_final']);
                $form->get('fecha_validez')->setValue($campana['fecha_validez']);
                $form->get('cantidad_cupones')->setValue($campana['cantidad_cupones']);
                $form->get('tiempo_online')->setValue($campana['tiempo_online']);
                $form->get('tiempo_offline')->setValue($campana['tiempo_offline']);
                $form->get('comision_campana')->setValue($campana['comision_campana']);
            }
        }

        $opciones = $campanaOpcionTable->getOpcionxCampanaAll($campanaId);
        $opcionCampana = array();
        foreach ($opciones as $opcion) {
            $opcionCampana[] = $opcion;
        }

        $categorias = $campanaCategoriaTable->getcategoriaxcampana($campanaId);
        $categoriaCampana = array();
        foreach ($categorias as $categoria) {
            $categoriaCampana[] = $categoria;
        }

        $viewmodel->form = $form;
        $viewmodel->setVariable('opciones', $opcionCampana);
        $viewmodel->setVariable('categorias', $categoriaCampana);
        $viewmodel->setVariable('ruta_imagenes', $ruta_imagenes);

        return $viewmodel;
    }

    /* public function deleteAction()
      {
      $sl = $this->getServiceLocator();
      $userId = $this->params('id');
      $userTable = $sl->get('Dashboard\Model\CampanaTable');
      $userTable->deleteCampana($userId);
      $this->redirect()->toRoute('dash_user_list');
      } */

    

    public function editopcionAction() {

        $opcion = $this->params()->fromPost("opcion", null);
        $campana = $this->params()->fromPost("campana", null);


        $serviceLocator = $this->getServiceLocator();
        $campanaOpcionTable = $serviceLocator->get('Dashboard\Model\CupcampanaopcionTable');

        $opciones = $campanaOpcionTable->getOpcionxCampanaId($opcion, $campana);

        $datos = array();
        foreach ($opciones as $opc) {
            $datos[] = $opc;
        }

        //$datos = array('opcion' => $opcion, 'campana' => $campana);

        return $this->getResponse()->setContent(Json::encode($datos));
    }
    
    public function deleteopcionAction() {

        $opcion = $this->params()->fromPost("opcion", null);
        $campana = $this->params()->fromPost("campana", null);


        $serviceLocator = $this->getServiceLocator();
        $campanaSeleccionTable = $serviceLocator->get('Dashboard\Model\CupopcionseleccionTable');
        $campanaOpcionTable = $serviceLocator->get('Dashboard\Model\CupcampanaopcionTable');

        $campanaSeleccionTable->delSeleccionxOpcionxCampanaId($opcion, $campana);
        $campanaOpcionTable->delOpcionxCampanaId($opcion, $campana);

        return $this->getResponse()->setContent(Json::encode(array('data' => '1')));
    }

    public function saveopcionAction() {

        $id_campana_opcion = $this->params()->fromPost("id_campana_opcion", null);
        $id_campana = $this->params()->fromPost("id_campana", null);
        $descripcion = $this->params()->fromPost("descripcion", null);
        $precio_regular = $this->params()->fromPost("precio_regular", null);
        $precio_especial = $this->params()->fromPost("precio_especial", null);
        $comision = $this->params()->fromPost("comision", null);

        $data = array('id_campana_opcion' => $id_campana_opcion,
            'id_campana' => $id_campana,
            'descripcion' => $descripcion,
            'precio_regular' => $precio_regular,
            'precio_especial' => $precio_especial,
            'comision' => $comision
        );

        $serviceLocator = $this->getServiceLocator();
        $campanaOpcionTable = $serviceLocator->get('Dashboard\Model\CupcampanaopcionTable');

        $datos = $campanaOpcionTable->addOpcionxCampana($data);


        return $this->getResponse()->setContent(Json::encode($datos));
    }
    
    
    public function grabarseleccionAction() {

        $id_opcion_seleccion = $this->params()->fromPost("pks_opcion_seleccion", null);
        $id_campana_opcion = $this->params()->fromPost("pks_campana_opcion", null);
        $id_campana = $this->params()->fromPost("pks_campana", null);
        $tipo_seleccion = $this->params()->fromPost("tipo_seleccion", null);
        $descripcion_primaria = $this->params()->fromPost("descripcion_primaria", null);
        $descripcion_secundaria = $this->params()->fromPost("descripcion_secundaria", null);
        $dias_bloqueo = $this->params()->fromPost("dias_bloqueo", null);
        $valor_inicial = $this->params()->fromPost("valor_inicial", null);
        $valor_final = $this->params()->fromPost("valor_final", null);
        $incremento = $this->params()->fromPost("incremento", null);
        $importe_seleccion = $this->params()->fromPost("importe_seleccion", null);
        $descripcion_interna = $this->params()->fromPost("descripcion_interna", null);
        $utiliza_descripcion_precio = $this->params()->fromPost("utiliza_descripcion_precio", null);
        $cantidad_seleccionar = $this->params()->fromPost("cantidad_seleccionar", null);
        $opcion_seleccionar = $this->params()->fromPost("opcion_seleccionar", null);
        
        if($tipo_seleccion == '1') {
            $dias_bloqueo = null;
        } else {
            $valor_inicial = null;
            $valor_final = null;
            $incremento = null;
            $importe_seleccion = null;
            $descripcion_interna = null;
            $utiliza_descripcion_precio = null;
        }
        
        $data = array(  'id_opcion_seleccion' => $id_opcion_seleccion,
                        'id_campana_opcion' => $id_campana_opcion,
                        'id_campana' => $id_campana,
                        'tipo_seleccion' => $tipo_seleccion,
                        'descripcion_primaria' => $descripcion_primaria,
                        'descripcion_secundaria' => $descripcion_secundaria,
                        'dias_bloqueo' => $dias_bloqueo,
                        'valor_inicial' => $valor_inicial,
                        'valor_final' => $valor_final,
                        'incremento' => $incremento,
                        'importe_seleccion' => $importe_seleccion,
                        'descripcion_interna' => $descripcion_interna,
                        'utiliza_descripcion_precio' => $utiliza_descripcion_precio
        );

        $serviceLocator = $this->getServiceLocator();
        
        $config = $serviceLocator->get('Config');
        $simbolo_moneda = $config['moneda']['simbolo'];
        $campanaSeleccionTable = $serviceLocator->get('Dashboard\Model\CupopcionseleccionTable');
        $campanaSeleccionDetalleTable = $serviceLocator->get('Dashboard\Model\CupopcionselecciondetalleTable');
        
        $datos = $campanaSeleccionTable->addSeleccionxOpcion($data);
        if(empty($id_opcion_seleccion)) $id_opcion_seleccion = $datos['id'];
        $t_opcion_seleccion_det = "<td>";
        $t_opcion_seleccion_det.= "<div class='form-group'>";
        $t_opcion_seleccion_det.= "<label for='categoria' class='col-lg-5 control-label'><b>".$descripcion_primaria."</b> ".$descripcion_secundaria." :</label>";
        $t_opcion_seleccion_det.= "<div class='col-lg-5'>";
        switch ($tipo_seleccion) {
            case '1':
                if(!empty($id_opcion_seleccion)) $campanaSeleccionDetalleTable->delSeleccionOpcionDetalleId($id_opcion_seleccion);
                
                
                $t_opcion_seleccion_det.= "<select id='' class='form-control input-sm'>";
                $cantidad = 0;
                foreach( $opcion_seleccionar as $item => $value) {
                    $cantidad_item = $cantidad_seleccionar[$item];
                    $datos_item = array('id_opcion_seleccion_detalle' => '' ,
                                        'id_opcion_seleccion' => $id_opcion_seleccion,
                                        'cantidad_seleccion' => $cantidad_item,
                                        'importe_seleccion' => $value);
                    
                    $campanaSeleccionDetalleTable->addSeleccionOpcionDetalle($datos_item);
                    
                    if($cantidad == 0 && $cantidad_item == 1 ) {
                        $t_opcion_seleccion_det.= "<option value='-1'>Seleccionar</option>";
                    }
                    if($cantidad == 0 && $cantidad_item == 0 ) {
                        $t_opcion_seleccion_det.= "<option value='0'>0</option>";
                    } else {
                        $t_opcion_seleccion_det.= "<option value='".$cantidad_item."'>";
                        if($utiliza_descripcion_precio == '1') {
                            $t_opcion_seleccion_det.= $cantidad_item." x ".$simbolo_moneda." ".$value;
                        } else {
                            $t_opcion_seleccion_det.= $cantidad_item." ".$descripcion_interna." ( x ".$simbolo_moneda." ".$value." )";
                        }
                        $t_opcion_seleccion_det.= "</option>";
                    }
                    $cantidad++;
                }
                $t_opcion_seleccion_det.= "</select>";
                 
                break;
            case '2':
                if(!empty($id_opcion_seleccion)) $campanaSeleccionDetalleTable->delSeleccionOpcionDetalleId($id_opcion_seleccion);
                $t_opcion_seleccion_det.= "<input id='calendargroup' class='form-control input-sm' value='dd/mm/yyyy + ".$dias_bloqueo." días' readonly>";
                break;
        }
        
        $t_opcion_seleccion_det.= "</div>";
        $t_opcion_seleccion_det.= "</div>";
        $t_opcion_seleccion_det.= "</td>";
        $t_opcion_seleccion_det.= "<td><div class='btn btn-primary' id-opcion-seleccion-editar='".$id_opcion_seleccion."'  title='Modificar selección'><span class='glyphicon glyphicon-edit'></span></div>";
        $t_opcion_seleccion_det.= "<div class='btn btn-default' id-opcion-seleccion-borrar='".$id_opcion_seleccion."' id-fila='filaSeleccion".$id_opcion_seleccion."' title='Eliminar selección'><span class='glyphicon glyphicon-trash'></span></div>";
        $t_opcion_seleccion_det.= "</td>";
        
        $datos['preview'] = $t_opcion_seleccion_det;

        return $this->getResponse()->setContent(Json::encode($datos));
    }
    
    public function nuevaseleccionAction() {
        
        $campana = $this->params()->fromPost("campana", null);
        $campana_opcion = $this->params()->fromPost("campana_opcion", null);

        $viewmodel = new ViewModel();
        $viewmodel->setTerminal(true);
        
        $form = new CampanaseleccionopcionForm();

        $form->get('pks_opcion_seleccion')->setValue('');
        $form->get('pks_campana_opcion')->setValue($campana_opcion);
        $form->get('pks_campana')->setValue($campana);
        $form->get('tipo_seleccion')->setValue('1');
        $form->get('descripcion_primaria')->setValue('');
        $form->get('descripcion_secundaria')->setValue('');
        $form->get('dias_bloqueo')->setValue('');
        $form->get('valor_inicial')->setValue('0');
        $form->get('valor_final')->setValue('-1');
        $form->get('incremento')->setValue('1');
        $form->get('importe_seleccion')->setValue('0.00');
        $form->get('descripcion_interna')->setValue('');
        $form->get('utiliza_descripcion_precio')->setValue('1');
        
        $viewmodel->form = $form;
        
        return $viewmodel;
        
    }
    
    public function editarseleccionAction() {

        $opcionseleccion = $this->params()->fromPost("opcion_seleccion", null);

        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('Config');
        $simbolo_moneda = $config['moneda']['simbolo'];
        $campanaOpcionTable = $serviceLocator->get('Dashboard\Model\CupopcionseleccionTable');
        $campanaOpcionSeleccionDetalleTable = $serviceLocator->get('Dashboard\Model\CupopcionselecciondetalleTable');

        $seleccionData = $campanaOpcionTable->getSeleccionOpcionId($opcionseleccion);
        $selecciondetalleData = $campanaOpcionSeleccionDetalleTable->getSeleccionOpcionDetalleId($opcionseleccion);
        
        $viewmodel = new ViewModel();
        $viewmodel->setTerminal(true);
        
        $form = new CampanaseleccionopcionForm();

        foreach ($seleccionData as $seleccion) {
            $form->get('pks_opcion_seleccion')->setValue($seleccion['id_opcion_seleccion']);
            $form->get('pks_campana_opcion')->setValue($seleccion['id_campana_opcion']);
            $form->get('pks_campana')->setValue($seleccion['id_campana']);
            $form->get('tipo_seleccion')->setValue($seleccion['tipo_seleccion']);
            $form->get('descripcion_primaria')->setValue($seleccion['descripcion_primaria']);
            $form->get('descripcion_secundaria')->setValue($seleccion['descripcion_secundaria']);
            $form->get('dias_bloqueo')->setValue($seleccion['dias_bloqueo']);
            $form->get('valor_inicial')->setValue($seleccion['valor_inicial']);
            $form->get('valor_final')->setValue($seleccion['valor_final']);
            $form->get('incremento')->setValue($seleccion['incremento']);
            $form->get('importe_seleccion')->setValue($seleccion['importe_seleccion']);
            $form->get('descripcion_interna')->setValue($seleccion['descripcion_interna']);
            $form->get('utiliza_descripcion_precio')->setValue($seleccion['utiliza_descripcion_precio']);
        }
                
        $viewmodel->form = $form;
        $viewmodel->setVariable('selecciondetalle', $selecciondetalleData);
        $viewmodel->setVariable('simbolo_moneda', $simbolo_moneda);
        
        return $viewmodel;
        
    }
    
    public function borrarseleccionAction() {

        $opcionseleccion = $this->params()->fromPost("opcion_seleccion", null);

        $serviceLocator = $this->getServiceLocator();
        $campanaSeleccionTable = $serviceLocator->get('Dashboard\Model\CupopcionseleccionTable');

        $campanaSeleccionTable->delSeleccionxOpcionId($opcionseleccion);

        return $this->getResponse()->setContent(Json::encode(array('data' => '1')));
    }
    
}
