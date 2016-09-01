<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Dashboard\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\In;
use Zend\Db\Sql\Predicate\Between;
use Zend\Stdlib\ArrayUtils;

/**
 * Description of CupcuponTable
 *
 * @author Administrador
 */
class CupcuponTable {

    //put your code here
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getTableGateway() {
        return $this->tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getCupon($orden) {

        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();

        $select->columns(array(
            'id_cupon',
            'email_cliente',
            'id_campana',
            'id_campana_opcion',
            'cantidad',
            'precio_total',
            'fecha_compra' => new Expression("date_format(fecha_compra,'%d-%m-%Y')")
        ))
        ->from('cup_cupon')
        ->join('cup_cupon_detalle', new Expression("cup_cupon.id_cupon = cup_cupon_detalle.id_cupon"),
                array('codigo_cupon'))
        ->join('cup_campana', new Expression("cup_cupon.id_campana = cup_campana.id_campana"),
                array(
                   'sobre_campana',
                   'saber' => 'observaciones',
                   'fecha_validez' => new Expression("date_format(fecha_validez,'%d-%m-%Y')")
                ))
        ->join('cup_campana_opcion', new Expression("cup_cupon.id_campana = cup_campana_opcion.id_campana and "
                                                  . "cup_cupon.id_campana_opcion = cup_campana_opcion.id_campana_opcion"),
                array('campana_descripcion' => 'descripcion'
                    ))
        ->join('gen_empresa', new Expression("cup_campana.id_empresa = gen_empresa.id_empresa"),
                array('razon_social',
                      'ubicacion_gps',
                      'horario',
                      'web_site',
                      'descripcion_empresa' => 'descripcion',
                      'direccion' => new Expression("case when ifnull(direccion_comercial,'') = '' then direccion_facturacion else direccion_comercial end ")
                    ))
        ->where(array('cup_cupon.id_cupon' => $orden));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }

    public function addCupon($datos,$sl,$datos_carrito = null ) {


        if (isset($datos)) {

            $sql = new Sql($this->tableGateway->adapter);
            
            $insert_carrito = $sql->insert('cup_cupon_carrito')->values(array(
                'cantidad_carrito' => (isset($datos['cantidad'])) ? $datos['cantidad'] : null,
                'precio_total' => (isset($datos['PriceTotal'])) ? $datos['PriceTotal'] : null,
                'id_tarjeta' => (isset($datos['metodo'])) ? $datos['metodo'] : null,
                'id_estado_compra' => '1',
                'fecha_registro' => new Expression("NOW()"),
                'id_empresa' => (isset($datos['ruc_empresa'])) ? $datos['ruc_empresa'] : null,
                'user_id' => (isset($datos['user_empresa'])) ? $datos['user_empresa'] : null
            ));

            $statement = $sql->prepareStatementForSqlObject($insert_carrito);

            $id_carrito = $statement->execute()->getGeneratedValue();
            
            if(count($datos_carrito) > 0) {
                
                $carrito = $datos_carrito['carrito'];
                $carrito_nombres = $datos_carrito['carrito_nombres'];

                for($i=0; $i<count($carrito); $i++){
                    
                    $id_campana = $carrito[$i]['id'];
                    $id_campana_opcion = $carrito[$i]['op'];
                    $total_opcion = $carrito[$i]['total-opcion'.base64_decode($id_campana_opcion)];  
                            
                    $insert_cupon = $sql->insert('cup_cupon')->values(array(
                        'email_cliente' => (isset($datos['email'])) ? $datos['email'] : null,
                        'id_campana' => (isset($id_campana)) ? base64_decode($id_campana) : null,
                        'id_campana_opcion' => (isset($id_campana_opcion)) ? base64_decode($id_campana_opcion) : null,
                        'cantidad' => '1',
                        'precio_unitario' => (isset($total_opcion)) ? $total_opcion : null,
                        'precio_total' => (isset($total_opcion)) ? $total_opcion : null,
                        'id_tarjeta' => (isset($datos['metodo'])) ? $datos['metodo'] : null,
                        'id_estado_compra' => '1',
                        'fecha_registro' => new Expression("NOW()"),
                        'id_cupon_carrito' => $id_carrito
                    ));
                    
                    $statement = $sql->prepareStatementForSqlObject($insert_cupon);
                    $id_cuponera = $statement->execute()->getGeneratedValue();
                    
                    //genero cupon
                    $codigo_cupon = $this->_getCodigoCupon($sl);

                    $insert_cupon_detalle = $sql->insert('cup_cupon_detalle')->values(array(
                        'codigo_cupon' => $codigo_cupon,
                        'id_cupon' => $id_cuponera,
                        'precio_unitario' => $total_opcion,
                        'id_estado_cupon' => '1',
                        'fecha_cancelacion' => new Expression("NOW()")
                    ));

                    $statement = $sql->prepareStatementForSqlObject($insert_cupon_detalle);
                    $statement->execute();
                    
                    //opcion = 1 , label = 2, cantidad = 3, key = 4
                    $opcion        = $carrito[$i]['opcion-seleccion'];
                    $label         = $carrito[$i]['label-opcion-seleccion'];
                    $cantidad      = $carrito[$i]['cantidad-opcion-seleccion'] + $carrito[$i]['cantidad-ninos-opcion-seleccion'] + $carrito[$i]['cantidad-infantes-opcion-seleccion'];
                    $keyseleccion  = $carrito[$i]['keyseleccion-opcion-seleccion'];
                    $carrito_extra = $carrito[$i]['extra-reserva'];
                    
                    for($j=0; $j< count($opcion); $j++) {
                        
                        $insert_cupon_detalle_opcion = $sql->insert('cup_cupon_detalle_opcion')->values(array(
                            'id_cupon' => $codigo_cupon,
                            'id_tipo_opcion_detalle' => '1',
                            'indice_extra' => '-1',
                            'indice' => $j,
                            'valor' => $opcion[$j]
                        ));
                        
                        $statement = $sql->prepareStatementForSqlObject($insert_cupon_detalle_opcion);
                        $statement->execute();
                        
                    }
                    
                    for($j=0; $j< count($label); $j++) {
                        
                        $insert_cupon_detalle_opcion = $sql->insert('cup_cupon_detalle_opcion')->values(array(
                            'id_cupon' => $codigo_cupon,
                            'id_tipo_opcion_detalle' => '2',
                            'indice_extra' => '-1',
                            'indice' => $j,
                            'valor' => strip_tags($label[$j])
                        ));
                        
                        $statement = $sql->prepareStatementForSqlObject($insert_cupon_detalle_opcion);
                        $statement->execute();
                        
                    }
                    
                    for($j=0; $j<count($cantidad); $j++) {

                        $insert_cupon_detalle_opcion = $sql->insert('cup_cupon_detalle_opcion')->values(array(
                            'id_cupon' => $codigo_cupon,
                            'id_tipo_opcion_detalle' => '3',
                            'indice_extra' => '-1',
                            'indice' => $j,
                            'valor' => $cantidad[$j]
                        ));
                        
                        $statement = $sql->prepareStatementForSqlObject($insert_cupon_detalle_opcion);
                        $id_cupon_detalle_opcion = $statement->execute()->getGeneratedValue();
                        
                        for($k=0; $k<count($carrito_nombres); $k++) {
                            if($carrito_nombres[$k]['indice_padre'] == $i && $carrito_nombres[$k]['indice_hijo'] == $j ) {
                                $opciones_nombres = $carrito_nombres[$k]['opciones_nombre'];
                                for($l=0;$l<count($opciones_nombres);$l++) {
                                    
                                    $insert_cupon_detalle_identidad = $sql->insert('cup_cupon_detalle_identidad')->values(array(
                                        'id_cupon_detalle_opcion' => $id_cupon_detalle_opcion,
                                        'indice' => $l,
                                        'apellidos' => $opciones_nombres[$l]['apellido'],
                                        'nombres' => $opciones_nombres[$l]['nombre']
                                    ));
                                    
                                    $statement = $sql->prepareStatementForSqlObject($insert_cupon_detalle_identidad);
                                    $statement->execute();
                                    
                                }
                            }
                        }
                    }
                    
                    for($j=0; $j< count($keyseleccion); $j++) {
                        
                        $insert_cupon_detalle_opcion = $sql->insert('cup_cupon_detalle_opcion')->values(array(
                            'id_cupon' => $codigo_cupon,
                            'id_tipo_opcion_detalle' => '4',
                            'indice_extra' => '-1',
                            'indice' => $j,
                            'valor' => $keyseleccion[$j]
                        ));
                        
                        $statement = $sql->prepareStatementForSqlObject($insert_cupon_detalle_opcion);
                        $statement->execute();
                        
                    }
                    
                    for($j=0; $j< count($carrito_extra); $j++){
                        $opcion_extra        = $carrito_extra[$j]['opcion-seleccion'];
                        $label_extra         = $carrito_extra[$j]['label-opcion-seleccion'];
                        $cantidad_extra      = $carrito_extra[$j]['cantidad-opcion-seleccion'] + $carrito_extra[$j]['cantidad-ninos-opcion-seleccion'] + $carrito_extra[$j]['cantidad-infantes-opcion-seleccion'];
                        $keyseleccion_extra  = $carrito_extra[$j]['keyseleccion-opcion-seleccion'];

                        for($k=0; $k< count($opcion_extra); $k++) {

                            $insert_cupon_detalle_opcion = $sql->insert('cup_cupon_detalle_opcion')->values(array(
                                'id_cupon' => $codigo_cupon,
                                'id_tipo_opcion_detalle' => '1',
                                'indice_extra' => $j,
                                'indice' => $k,
                                'valor' => $opcion_extra[$k]
                            ));

                            $statement = $sql->prepareStatementForSqlObject($insert_cupon_detalle_opcion);
                            $statement->execute();

                        }

                        for($k=0; $k< count($label_extra); $k++) {

                            $insert_cupon_detalle_opcion = $sql->insert('cup_cupon_detalle_opcion')->values(array(
                                'id_cupon' => $codigo_cupon,
                                'id_tipo_opcion_detalle' => '2',
                                'indice_extra' => $j,
                                'indice' => $k,
                                'valor' => strip_tags($label_extra[$k])
                            ));

                            $statement = $sql->prepareStatementForSqlObject($insert_cupon_detalle_opcion);
                            $statement->execute();

                        }

                        for($k=0; $k<count($cantidad_extra); $k++) {

                            $insert_cupon_detalle_opcion = $sql->insert('cup_cupon_detalle_opcion')->values(array(
                                'id_cupon' => $codigo_cupon,
                                'id_tipo_opcion_detalle' => '3',
                                'indice_extra' => $j,
                                'indice' => $k,
                                'valor' => $cantidad_extra[$k]
                            ));

                            $statement = $sql->prepareStatementForSqlObject($insert_cupon_detalle_opcion);
                            $id_cupon_detalle_opcion = $statement->execute()->getGeneratedValue();

                            for($l=0; $l<count($carrito_nombres); $l++) {
                                if($carrito_nombres[$l]['indice_padre'] == $j && $carrito_nombres[$l]['indice_hijo'] == $k ) {
                                    $opciones_nombres = $carrito_nombres[$l]['opciones_nombre'];
                                    for($m=0;$m<count($opciones_nombres);$m++) {

                                        $insert_cupon_detalle_identidad = $sql->insert('cup_cupon_detalle_identidad')->values(array(
                                            'id_cupon_detalle_opcion' => $id_cupon_detalle_opcion,
                                            'indice' => $m,
                                            'apellidos' => $opciones_nombres[$m]['apellido'],
                                            'nombres' => $opciones_nombres[$m]['nombre']
                                        ));

                                        $statement = $sql->prepareStatementForSqlObject($insert_cupon_detalle_identidad);
                                        $statement->execute();

                                    }
                                }
                            }
                        }

                        for($k=0; $k< count($keyseleccion_extra); $k++) {

                            $insert_cupon_detalle_opcion = $sql->insert('cup_cupon_detalle_opcion')->values(array(
                                'id_cupon' => $codigo_cupon,
                                'id_tipo_opcion_detalle' => '4',
                                'indice_extra' => $j,
                                'indice' => $k,
                                'valor' => $keyseleccion_extra[$k]
                            ));

                            $statement = $sql->prepareStatementForSqlObject($insert_cupon_detalle_opcion);
                            $statement->execute();

                        }
                    }
                }

            } else {
                
                $insert = $sql->insert('cup_cupon')->values(array(
                    'email_cliente' => (isset($datos['email'])) ? $datos['email'] : null,
                    'id_campana' => (isset($datos['IdCampana'])) ? base64_decode($datos['IdCampana']) : null,
                    'id_campana_opcion' => (isset($datos['IdOpcion'])) ? base64_decode($datos['IdOpcion']) : null,
                    'cantidad' => (isset($datos['cantidad'])) ? $datos['cantidad'] : null,
                    'precio_unitario' => (isset($datos['PriceUnit'])) ? $datos['PriceUnit'] : null,
                    'precio_total' => (isset($datos['PriceTotal'])) ? $datos['PriceTotal'] : null,
                    'id_tarjeta' => (isset($datos['metodo'])) ? $datos['metodo'] : null,
                    'id_estado_compra' => '1',
                    'fecha_registro' => new Expression("NOW()"),
                    'id_cupon_carrito' => $id_carrito
                ));

                $statement = $sql->prepareStatementForSqlObject($insert);

                $id_cuponera = $statement->execute()->getGeneratedValue();

                $cantidad_cupones = $datos['cantidad'];

                for($i=0;$i<$cantidad_cupones;$i++) {
                    $codigo_cupon = $this->_getCodigoCupon($sl);

                    $insert = $sql->insert('cup_cupon_detalle')->values(array(
                        'codigo_cupon' => $codigo_cupon,
                        'id_cupon' => $id_cuponera,
                        'precio_unitario' => $datos['PriceUnit'],
                        'id_estado_cupon' => '1',
                        'fecha_cancelacion' => new Expression("NOW()")
                    ));

                    $statement = $sql->prepareStatementForSqlObject($insert);

                    $statement->execute();

                }

            }
            
            return $id_carrito;
        }
    }
    
    public function updDatosPayme($set, $where) {
        
        $rs = $this->tableGateway->update($set, $where);
        
        return $rs;
    }

    public function updEstadoVenta($orden, $estado) {

        $set = array('id_estado_compra' => $estado,
                     'fecha_compra' => new Expression("NOW()")
                    );
        $where = array('id_cupon' => $orden);

        $rs = $this->tableGateway->update($set, $where);

        $sql = new Sql($this->tableGateway->getAdapter());
        
        $update = $sql->update('cup_cupon_detalle');
        $update->set(array('id_estado_cupon' => $estado,
                           'fecha_cancelacion' => new Expression("NOW()")));
        $update->where(array('id_cupon' => $orden));
        
        $sql->prepareStatementForSqlObject($update)->execute();

        $select = $sql->select();

        $select->columns(array('id_campana', 'id_campana_opcion', 'cantidad'))
                ->from(array('c' => 'cup_cupon'))
                ->where(array('c.id_cupon' => $orden));

        $stmt = $sql->prepareStatementForSqlObject($select);

        $results = $stmt->execute();

        $cantidad = array();
        foreach ($results as $cupon) {
            $cantidad = $cupon;
        }

        return $cantidad;
    }

    private function _getCodigoCupon($sl) {
        
        if(!empty($sl)) {
            $config = $sl->get('Config');
            $prefijo = $config['constantes']['prefijo'];
        } else {
            $prefijo = 'OPT';
        }
        
        $codigo = $prefijo .
                  '-' .
                  $this->_desordenarNumero(date('YmdHis')) .
                  '-' .
                  str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);
                  
        return $codigo;
    }
    
    private function _desordenarNumero($cadena) {
        $posi = 0;
        $cadenanueva = substr($cadena, $posi + 10, 2) .
                       substr($cadena, $posi , 2) .
                       substr($cadena, $posi + 8, 2) .
                       substr($cadena, $posi + 6, 2) .
                       substr($cadena, $posi + 2, 1) .
                       '-' .
                       substr($cadena, $posi + 3, 1) .
                       substr($cadena, $posi + 12, 2) .
                       substr($cadena, $posi + 4, 2);
        
        return $cadenanueva;
    }
    

    public function validarCupon($id_empresa, $cadena, $tipo) {
        $aCupones = explode(",", $cadena);
        $aValidar = array();
        foreach ($aCupones as $cupon) {

            $sql = new Sql($this->tableGateway->getAdapter());

            $select = $sql->select();

            $select->columns(array('estado' => 'id_estado_cupon'))
                    ->from('cup_cupon_detalle')
                    ->join('cup_cupon', new
                            Expression("cup_cupon.id_cupon = cup_cupon_detalle.id_cupon"),
                            array())        
                    ->join('cup_campana', new
                            Expression("cup_cupon.id_campana = cup_campana.id_campana and "
                            . "cup_campana.id_empresa = ".$id_empresa),
                            array())        
                    ->where(array('cup_cupon_detalle.codigo_cupon' => $cupon));

            $stmt = $sql->prepareStatementForSqlObject($select);

            $results = $stmt->execute();

            $valido = 0;
            foreach ($results as $exito) {
                if($exito['estado'] == '3' ) { $valido = 1; }
                if($exito['estado'] == '5' ) { $valido = 2; }
            }

            if ($valido == 1 && $tipo == 'V') {
                
                $fecha_validacion = date("Y-m-d H:i:s");
                
                $sql = new Sql($this->tableGateway->getAdapter());
                $select = $sql
                        ->update()
                        ->table('cup_cupon_detalle')
                        ->set(array('id_estado_cupon' => '5',
                                    'fecha_validacion' => $fecha_validacion))
                        ->where(array('codigo_cupon' => $cupon));

                $stmt = $sql->prepareStatementForSqlObject($select);

                $results = $stmt->execute();

            }

            $aValidar[] = array('cupon' => $cupon, 'valido' => $valido, 'tipo' => $tipo);
        }

        return $aValidar;
    }
    
    public function getCuponValidado($id_empresa, $cantidad = 0, $inicio = 0) {

        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();

        $select->columns(array(
            'id_cupon',
            'cantidad' => new Expression("1"),
            'precio_total' => 'precio_unitario',
            'comision_total' => new Expression("cup_cupon_detalle.precio_unitario - (round(((100 - ifnull(cup_campana.comision_campana,0)) * cup_cupon_detalle.precio_unitario) / 100,2))"),
            'total_apagar' => new Expression("round(((100 - ifnull(cup_campana.comision_campana,0)) * cup_cupon_detalle.precio_unitario) / 100,2)"),
            'codigo_cupon',
            'fecha_compra' => new Expression("date_format(fecha_compra,'%d-%m-%Y')"),
            'fecha_validacion' => new Expression("date_format(fecha_validacion,'%d-%m-%Y')"),
            'fecha_liquidacion' => new Expression("date_format(CASE WHEN DAYOFWEEK(fecha_validacion) > 1 THEN ADDDATE(fecha_validacion, 20 - DAYOFWEEK(fecha_validacion)) ELSE ADDDATE(fecha_validacion, 12) END,'%d-%m-%Y')")
        ))
        ->from('cup_cupon_detalle');
        
        if( $cantidad > 0 ) { 
            $select->limit($cantidad); 
        }
        
        if( $inicio > 0 ) { 
            $select->offset($inicio); 
        }
        
        $select->join('cup_cupon', new Expression("cup_cupon_detalle.id_cupon = cup_cupon.id_cupon "),
                array(
                    'id_campana',
                    'id_campana_opcion'
                ))        
        ->join('cup_campana', new Expression("cup_cupon.id_campana = cup_campana.id_campana and "
                                           . "cup_campana.id_empresa = ".$id_empresa),
                array(
                   'sobre_campana',
                   'saber' => 'observaciones',
                   'fecha_validez' => new Expression("date_format(fecha_validez,'%d-%m-%Y')"),
                   'fecha_inicio' => new Expression("date_format(fecha_inicio,'%d-%m-%Y')")
                ))        
        ->join('cup_campana_opcion', new Expression("cup_cupon.id_campana = cup_campana_opcion.id_campana and "
                                                  . "cup_cupon.id_campana_opcion = cup_campana_opcion.id_campana_opcion"),
                array('campana_descripcion' => 'descripcion'
                    ))
        ->join('gen_empresa', new Expression("cup_campana.id_empresa = gen_empresa.id_empresa"),
                array('razon_social',
                      'ubicacion_gps',
                      'horario',
                      'web_site',
                      'descripcion_empresa' => 'descripcion',
                      'direccion' => new Expression("case when ifnull(direccion_comercial,'') = '' then direccion_facturacion else direccion_comercial end ")
                    ))
        ->where(new In('id_estado_cupon', array('5','7')));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
    public function getCuponesxLiquidar() {

        $fecha = '24/05/2015';
        
        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();
        
        $select->columns(array(
            'fecha_validacion',
            'codigo_cupon', 
            'cantidad' => new Expression("1"), 
            'precio_unitario', 
            'precio_total' => 'precio_unitario'
        ))->from('cup_cupon_detalle')
        ->join('cup_cupon', new Expression("cup_cupon_detalle.id_cupon = cup_cupon.id_cupon "),
                array('id_campana', 
                      'id_campana_opcion'))       
        ->where(array('cup_cupon_detalle.id_estado_cupon' => '5'))
        ->where->addPredicate(new Between('fecha_validacion', new Expression("STR_TO_DATE('".$fecha." 00:00:00','%d/%m/%Y %H:%i:%s')"), new Expression("STR_TO_DATE('".$fecha." 23:59:59','%d/%m/%Y %H:%i:%s')")));

        $select->order(array('cup_cupon.id_campana', 'cup_cupon.id_campana_opcion', 'cup_cupon_detalle.fecha_validacion'));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
        
    }
    
    public function updCupon($set, $where) {
        
        $rs = $this->tableGateway->update($set, $where);
        
        return $rs;
        
    }
    
    public function updCuponDetalle($set, $where) {
        
        $sql = new Sql($this->tableGateway->adapter);
        
        $update = $sql->update('cup_cupon_detalle');
        $update->set($set);
        $update->where($where);
        
        $rs = $sql->prepareStatementForSqlObject($update)->execute();
        
        return $rs;
        
    }
    
    public function getHistorialValidadosEmpresa($id_empresa) {
        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();
        $select->columns(array(
            'validados' => new Expression("count(1)"),
            'cantidad_pagados' => new Expression("sum(case when id_estado_cupon = '7' then 1 else 0 end)"),
            'total_pagados' => new Expression("sum(case when id_estado_cupon = '7' then cup_cupon_detalle.precio_unitario else 0 end)")
        ))
        ->from('cup_cupon_detalle')
        ->join('cup_cupon', new Expression("cup_cupon_detalle.id_cupon = cup_cupon.id_cupon "),
                array()) 
        ->join('cup_campana', new Expression("cup_cupon.id_campana = cup_campana.id_campana and "
                                           . "cup_campana.id_empresa = $id_empresa"),
                array())
        ->where(new In('id_estado_cupon', array('5','7')));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return ArrayUtils::iteratorToArray($result);
    }
    
    public function getHistorialPagadosEmpresa($id_empresa) {
        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();
        $select->columns(array(
            'cantidad_pagados' => new Expression("sum(cup_liquidacion.cantidad_cupones)"),
            'total_pagados' => new Expression("sum(total_liquidacion)")
        ))
        ->from('cup_liquidacion')
        ->join('cup_campana', new Expression("cup_liquidacion.id_campana = cup_campana.id_campana and "
                                           . "cup_campana.id_empresa = $id_empresa"),
                array())
        ->where(new In('estado_liquidacion', array('1')));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return ArrayUtils::iteratorToArray($result);
    }
    
    public function getHistorialpordiaEmpresa($id_empresa) {
        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();
        $select->columns(array(
            'periodo' => new Expression("DATE_FORMAT(fecha_cancelacion,'%M %Y')"), 
            'dia' => new Expression("DATE_FORMAT(fecha_cancelacion,'%d')"),
            'vendidos' => new Expression("count(1)"),
            'validados' => new Expression("sum(case when id_estado_cupon in ('5','7') then 1 else 0 end)")
        ))
        ->from('cup_cupon_detalle')
        ->join('cup_cupon', new Expression("cup_cupon_detalle.id_cupon = cup_cupon.id_cupon "),
                array()) 
        ->join('cup_campana', new Expression("cup_cupon.id_campana = cup_campana.id_campana and "
                                           . "cup_campana.id_empresa = $id_empresa"),
                array())
        ->where(new In('id_estado_cupon', array('3','5','7')));
        
        $select->group(array(new Expression("DATE_FORMAT(fecha_cancelacion,'%M %Y')")));
        $select->group(array(new Expression("DATE_FORMAT(fecha_cancelacion,'%d')")));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return ArrayUtils::iteratorToArray($result);
    }
    
    public function getPagobancarioList() {

        $sql = new Sql($this->tableGateway->adapter);
                
        $select = $sql->select();

        $select->columns(array(
            'id_cupon',
            'transaccion' => 'id_cupon',
            'id_campana',
            'id_campana_opcion',
            'cantidad',
            'precio_total',
            'fecha_compra' => new Expression("date_format(fecha_compra,'%d-%m-%Y')"),
            'tipo' => new Expression("case when id_estado_compra = '1' then '0' else '1' end"),
            'fec_operacion' => new Expression("date_format(fecha_operacion,'%d-%m-%Y')"),
            'num_operacion' => 'observacion'
        ))
        ->from('cup_cupon')
        ->join('cup_campana', new Expression("cup_cupon.id_campana = cup_campana.id_campana"),
                array(
                   'sobre_campana',
                   'saber' => 'observaciones',
                   'fecha_validez' => new Expression("date_format(fecha_validez,'%d-%m-%Y')")
                ))
        ->join('cup_campana_opcion', new Expression("cup_cupon.id_campana = cup_campana_opcion.id_campana and "
                                                  . "cup_cupon.id_campana_opcion = cup_campana_opcion.id_campana_opcion"),
                array('campana_descripcion' => 'descripcion'
                    ))
        ->join('gen_empresa', new Expression("cup_campana.id_empresa = gen_empresa.id_empresa"),
                array('razon_social',
                      'ubicacion_gps',
                      'horario',
                      'web_site',
                      'descripcion_empresa' => 'descripcion',
                      'direccion' => new Expression("case when ifnull(direccion_comercial,'') = '' then direccion_facturacion else direccion_comercial end ")
                    ))
        ->where(new In('cup_cupon.id_estado_compra', array('1','3')))
        ->where(array('cup_cupon.id_tarjeta' => '999'));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return ArrayUtils::iteratorToArray($result);
    }
    
    public function getCuponPrepagado($id_cupon) {
    
            $sql = new Sql($this->tableGateway->getAdapter());
    
            $select = $sql->select();

            $select->columns(array('operacion' => 'observacion',
                                   'fecha_operacion' => new Expression("DATE_FORMAT(fecha_operacion,'%d-%m-%Y')")),
                                   'id_campana',
                                   'id_campana_opcion',
                                   'cantidad'
                            )
                    ->from('cup_cupon')
                    ->where(array('cup_cupon.id_cupon' => $id_cupon))
                    ->where(new In('cup_cupon.id_estado_compra', array('3','5','7')));

            $stmt = $sql->prepareStatementForSqlObject($select);

            $result = $stmt->execute();
            
            return ArrayUtils::iteratorToArray($result);
    
    }
    
    public function getCuponPromocion($email, $id_campana, $id_opcion) {
    
            $sql = new Sql($this->tableGateway->getAdapter());
    
            $select = $sql->select();

            $select->columns(array('operacion' => 'observacion',
                                   'fecha_operacion' => new Expression("DATE_FORMAT(fecha_operacion,'%d-%m-%Y')")),
                                   'id_campana',
                                   'id_campana_opcion',
                                   'cantidad'
                            )
                    ->from('cup_cupon')
                    ->where(array('cup_cupon.email_cliente' => $email,
                                  'cup_cupon.id_campana' => $id_campana,
                                  'cup_cupon.id_campana_opcion' => $id_opcion))
                    ->where(new In('cup_cupon.id_estado_compra', array('3','5','7')));

            $stmt = $sql->prepareStatementForSqlObject($select);

            $result = $stmt->execute();
            
            return ArrayUtils::iteratorToArray($result);
    
    }
       
    public function getDatosOrden($id_cupon) {
    
            $sql = new Sql($this->tableGateway->getAdapter());
    
            $select = $sql->select();

            $select->columns(array('id_campana', 'id_campana_opcion', 'cantidad'))
                    ->from(array('c' => 'cup_cupon'))
                    ->where(array('c.id_cupon' => $id_cupon));

            $stmt = $sql->prepareStatementForSqlObject($select);

            $results = $stmt->execute();
            
            return ArrayUtils::iteratorToArray($results);
    
    }
    
}
