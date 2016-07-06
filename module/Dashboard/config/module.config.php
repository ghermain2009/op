<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /dashboard/:controller/:action
            'dashboard' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'dash_login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'login',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'login',
                        'action' => 'logout',
                    ),
                ),
            ),
            'dash_index' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'index',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_user' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'user',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_user_list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/user/list/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'user',
                        'action' => 'list',
                    ),
                ),
            ),
            'dash_user_edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/user/edit/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'user',
                        'action' => 'edit',
                    ),
                ),
            ),
            'dash_user_del' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/user/delete/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'user',
                        'action' => 'delete',
                    ),
                ),
            ),
            'dash_role' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/role',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'role',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_role_list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/role/list/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'role',
                        'action' => 'list',
                    ),
                ),
            ),
            'dash_role_edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/role/edit/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'role',
                        'action' => 'edit',
                    ),
                ),
            ),
            'dash_role_del' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/role/delete/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'role',
                        'action' => 'delete',
                    ),
                ),
            ),
            'dash_tipohospedaje' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/tipohospedaje',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'tipohospedaje',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_tipohospedaje_list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/tipohospedaje/list/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'tipohospedaje',
                        'action' => 'list',
                    ),
                ),
            ),
            'dash_tipohospedaje_edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/tipohospedaje/edit/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'tipohospedaje',
                        'action' => 'edit',
                    ),
                ),
            ),
            'dash_tipohospedaje_del' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/tipohospedaje/delete/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'tipohospedaje',
                        'action' => 'delete',
                    ),
                ),
            ),
            'dash_hospedaje' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/hospedaje',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'hospedaje',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_hospedaje_list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/hospedaje/list/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'hospedaje',
                        'action' => 'list',
                    ),
                ),
            ),
            'dash_hospedaje_edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/hospedaje/edit/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'hospedaje',
                        'action' => 'edit',
                    ),
                ),
            ),
            'dash_hospedaje_del' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/hospedaje/delete/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'hospedaje',
                        'action' => 'delete',
                    ),
                ),
            ),
            'dash_voucher' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/voucher',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'voucher',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_voucher_list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/voucher/list/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'voucher',
                        'action' => 'list',
                    ),
                ),
            ),
            'dash_voucher_edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/voucher/edit/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'voucher',
                        'action' => 'edit',
                    ),
                ),
            ),
            'dash_voucher_del' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/voucher/delete/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'voucher',
                        'action' => 'delete',
                    ),
                ),
            ),
            'dash_categoriahabitacion' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/categoriahabitacion',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'categoriahabitacion',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_categoriahabitacion_list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/categoriahabitacion/list/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'categoriahabitacion',
                        'action' => 'list',
                    ),
                ),
            ),
            'dash_categoriahabitacion_edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/categoriahabitacion/edit/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'categoriahabitacion',
                        'action' => 'edit',
                    ),
                ),
            ),
            'dash_categoriahabitacion_del' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/categoriahabitacion/delete/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'categoriahabitacion',
                        'action' => 'delete',
                    ),
                ),
            ),
            'dash_adicionales' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/adicionales',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'adicionales',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_adicionales_list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/adicionales/list/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'adicionales',
                        'action' => 'list',
                    ),
                ),
            ),
            'dash_adicionales_edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/adicionales/edit/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'adicionales',
                        'action' => 'edit',
                    ),
                ),
            ),
            'dash_adicionales_del' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/adicionales/delete/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'adicionales',
                        'action' => 'delete',
                    ),
                ),
            ),
            'dash_contrato_edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/campana/editarcontrato',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'campana',
                        'action' => 'editarcontrato',
                    ),
                ),
            ),
            
            //campana
            'dash_campana' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/campana[/:action]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'campana',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_campana_list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/campana/list/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'campana',
                        'action' => 'list',
                    ),
                ),
            ),
            'dash_campana_edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/campana/edit/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'campana',
                        'action' => 'edit',
                    ),
                ),
            ),
            //empresa
            'dash_empresa' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/empresa',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'empresa',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_empresa_list' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/empresa/list/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'empresa',
                        'action' => 'list',
                    ),
                ),
            ),
            'dash_empresa_edit' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/empresa/edit/id[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'empresa',
                        'action' => 'edit',
                    ),
                ),
            ),
            //campana
            /*'dash_campana' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/campana',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'campana',
                        'action' => 'index',
                    ),
                ),
            ),*/
            //mi campana
            'dash_micampana' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/micampana[/:empresa]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'micampana',
                        'action' => 'index',
                    ),
                ),
            ),
            'dash_micampanacupon' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/dashboard/micampana/cupon',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'micampana',
                        'action' => 'cupon',
                    ),
                ),
            ),
            'dash_detallevalidado' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/micampana/detallevalidado[/:empresa]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'micampana',
                        'action' => 'detallevalidado',
                    ),
                ),
            ),
            'dash_detalleliquidacion' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/micampana/detalleliquidacion[/:empresa]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'micampana',
                        'action' => 'detalleliquidacion',
                    ),
                ),
            ),
            'dash_historiacampanas' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/micampana/historiacampanas[/:empresa]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'micampana',
                        'action' => 'historiacampanas',
                    ),
                ),
            ),
            'dash_resumenliquidacion' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/dashboard/micampana/resumenliquidacion[/:empresa[/:liquidacion]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Controller',
                        'controller' => 'micampana',
                        'action' => 'resumenliquidacion',
                    ),
                ),
            ),
            'dash_cron' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/cron/generaliquidacion',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Dashboard\Cron\Controller',
                        'controller' => 'generaliquidacion',
                        'action' => 'generaliquidacion',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Dashboard\Controller\Index' => 'Dashboard\Controller\IndexController',
            'Dashboard\Controller\Login' => 'Dashboard\Controller\LoginController',
            'Dashboard\Controller\User' => 'Dashboard\Controller\UserController',
            'Dashboard\Controller\Role' => 'Dashboard\Controller\RoleController',
            'Dashboard\Controller\Tipohospedaje' => 'Dashboard\Controller\TipohospedajeController',
            'Dashboard\Controller\Adicionales' => 'Dashboard\Controller\AdicionalesController',
            'Dashboard\Controller\Categoriahabitacion' => 'Dashboard\Controller\CategoriahabitacionController',
            'Dashboard\Controller\Hospedaje' => 'Dashboard\Controller\HospedajeController',
            'Dashboard\Controller\Voucher' => 'Dashboard\Controller\VoucherController',
            'Dashboard\Controller\Campana' => 'Dashboard\Controller\CampanaController',
            'Dashboard\Controller\Empresa' => 'Dashboard\Controller\EmpresaController',
            'Dashboard\Controller\Reporte' => 'Dashboard\Controller\ReporteController',
            'Dashboard\Controller\Micampana' => 'Dashboard\Controller\MicampanaController',
            'Dashboard\Controller\Pagobancario' => 'Dashboard\Controller\PagobancarioController',
            'Dashboard\Cron\Controller\Generaliquidacion' => 'Dashboard\Cron\Controller\GeneraliquidacionController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layoutDashboard' => __DIR__ . '/../view/layout/layout.phtml',
            'dashboard/index/index' => __DIR__ . '/../view/dashboard/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    //Layouts to module
    'module_layouts' => array(
        'Dashboard' => 'layout/layoutDashboard',
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'Authentication' => 'Dashboard\Plugin\Authentication',
            'RouteHelper' => 'Dashboard\Helper\RouteHelper',
            'Privileges' => 'Dashboard\Plugin\Privileges',
            
        )
    ),
);
