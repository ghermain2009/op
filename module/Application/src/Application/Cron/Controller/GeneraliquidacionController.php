<?php

namespace Application\Cron\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Expression;

class GeneraliquidacionController extends AbstractActionController
{
    public function generaliquidacionAction()
    {
       $view = new ViewModel();
       //$view->setTerminal(true);
       
       $serviceLocator = $this->getServiceLocator();
       $cuponTable = $serviceLocator->get('Dashboard\Model\CupcuponTable');
       $liquidacionTable = $serviceLocator->get('Dashboard\Model\CupliquidacionTable');
       $liquidacioncuponTable = $serviceLocator->get('Dashboard\Model\CupliquidacioncuponTable');
       
       $datosCuponV = $cuponTable->getCuponesxLiquidar();
       
       $cantidad = count($datosCuponV);
       $id_campana = -1;
       $id_campana_opcion = -1;
       $pre_liquidacion = 0;
       $impuesto_pais = 12;
       $cantidad_cupones_liquidar = 0;
       $total_cupones_liquidar = 0;
       $total_comision_liquidar = 0;
       $total_cliente_liquidar = 0;
       
       if( $cantidad > 0 ) {
           for( $i=0; $i<$cantidad; $i++) {
               
               if($id_campana != $datosCuponV[$i]['id_campana'] || $id_campana_opcion != $datosCuponV[$i]['id_campana_opcion']) {
                   
                   if( $pre_liquidacion > 0 ){
                       
                        $total_impuesto_liquidar = round($total_comision_liquidar * $impuesto_pais / 100,2);
                        
                        $set = array('cantidad_cupones' => $cantidad_cupones_liquidar,
                                       'total_importe' =>  $total_cupones_liquidar,
                                       'comision' => $total_comision_liquidar,
                                       'impuesto' => $total_impuesto_liquidar,
                                       'total_liquidacion' => $total_cliente_liquidar);
                        
                        $where = array('id_liquidacion' => $pre_liquidacion);
                        
                   }
                   
                   $pre_liquidacion = $liquidacionTable->addPreLiquidacion($datosCuponV[$i]['id_campana']);
                   $cantidad_cupones_liquidar = 0;
                   $total_cupones_liquidar = 0;
                   $total_comision_liquidar = 0;
                   $total_cliente_liquidar = 0;
               }
               
               $cantidad_cupones_liquidar++;
               
               $insert_liquidacion_cupon = array('id_liquidacion' => $pre_liquidacion,
                                            'codigo_cupon' => $datosCuponV[$i]['codigo_cupon']);
               
               $liquidacioncuponTable->addLiquidacionCupon($insert_liquidacion_cupon);
               
               $cantidad_ofertas = $datosCuponV[$i]['cantidad'];
               $precio_unitario = $datosCuponV[$i]['precio_unitario'];
               $precio_total = $datosCuponV[$i]['precio_total'];
               $comision = 28;
               
               $total_cupones_liquidar += $precio_total;
               $comision_unitaria = round($precio_unitario * $comision / 100,2);
               $total_comision_liquidar += $cantidad_ofertas * $comision_unitaria;
               $total_cliente_liquidar += $precio_total - ($cantidad_ofertas * $comision_unitaria);
               
               $set = array('id_estado_cupon' => '7',
                            'fecha_liquidacion' => new Expression("NOW()"));
               
               $where = array('codigo_cupon' => $datosCuponV[$i]['codigo_cupon'] );
               
               $cuponTable->updCuponDetalle($set, $where);
               
               $id_campana = $datosCuponV[$i]['id_campana'];
               $id_campana_opcion = $datosCuponV[$i]['id_campana_opcion'];
               
               
           }
           
           if( $pre_liquidacion > 0 ){
                       
                $total_impuesto_liquidar = round($total_comision_liquidar * $impuesto_pais / 100,2);

                $set = array('cantidad_cupones' => $cantidad_cupones_liquidar,
                               'total_importe' =>  $total_cupones_liquidar,
                               'comision' => $total_comision_liquidar,
                               'impuesto' => $total_impuesto_liquidar,
                               'total_liquidacion' => $total_cliente_liquidar);

                $where = array('id_liquidacion' => $pre_liquidacion);
                
                $liquidacionTable->updPreLiquidacion($set, $where);

           }
       }
       
       exit();
       
       return $view;
    }
    
    public function aumentarPromocionesAction()
    {
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('Config');
        $promociones = $config['promociones'];
        
        $campanaopcionTable = $serviceLocator->get('Dashboard\Model\CupcampanaopcionTable');
        
        foreach( $promociones as $promocion) {
            $id = $promocion['id_promocion'];
            $cantidad = $promocion['cantidad_aumento'];
            $campanaopcionTable->setIncremenarApertura($id, $cantidad);
        } 
        
        return new ViewModel();
    }
}
