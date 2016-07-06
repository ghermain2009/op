<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Services;

use DOMPDFModule\View\Model\PdfModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Mime;
use Zend\Mail\Transport\SmtpOptions;
use QRCode\Service\QRCode;
use Zend\Barcode\Barcode;
use Zend\Session\Container;
/**
 * Description of Variados
 *
 * @author Administrador
 */
class Variados {
    //put your code here
    public $serviceLocator;

    function __construct($seviceLocator)
    {
        $this->serviceLocator = $seviceLocator;
    }
    
    public function obtenerCuponPdf($datos)
    {
        $sl = $this->serviceLocator;
        
        $config = $sl->get('Config');
        $localhost = $config['constantes']['localhost'];
        
        $dir_image = $config['constantes']['dir_image'];
        $sep_path = $config['constantes']['sep_path'];
        $dir_imagenes = $config['rutas']['dir_principal'] .
                        $sep_path .
                        $config['rutas']['dir_imgcampanas'];
        
        $directorio = $dir_image . 
                    $sep_path . 
                    ".." .
                    $sep_path .
                    ".." .
                    $sep_path .
                    $dir_imagenes .
                    $sep_path;
        
        $is_https = $config['is_https'];
        
        $body = new MimeMessage();
        
        $this->renderer = $sl->get('ViewRenderer');  
        $contenido = $this->renderer->render('application/email-template/cupon-rebueno-tpl', array('localhost' => $localhost)); 
        
        $html = new MimePart($contenido);
        $html->type = Mime::TYPE_HTML;
        $html->disposition = Mime::DISPOSITION_INLINE;
        $html->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
        $html->charset = 'iso-8859-1';
        
        $body->addPart($html);
        
        $email = '';

        for($i=0;$i<count($datos);$i++) {
            //for($i=0;$i<1;$i++) {
                if($i==0) {
                    $email = $datos[$i]['email_cliente'];
                }
                
                $ruta_imagen_pro = $directorio.$datos[$i]['id_campana'].$sep_path .'small2'.$sep_path.'image1.jpg';
                if (file_exists($ruta_imagen_pro)){
                    ob_start();
                    $resource_image = imagecreatefromjpeg($ruta_imagen_pro);
                    imagejpeg($resource_image);
                    $imagedata = ob_get_clean();
                    $image = 'data:image/jpeg;base64,'.base64_encode($imagedata);
                } else {
                    $image = '';
                }
                
                /*********Codigo de Barra Code128****************/
                $barcodeOptions = array('text' => $datos[$i]["codigo_cupon"]);
                $rendererOptions = array('imageType' => 'jpg');
                $img128 = Barcode::factory('code128', 'image', $barcodeOptions, $rendererOptions)->draw();
                ob_start();
                imagejpeg($img128);
                $data128 = ob_get_clean();
                
                /*********Codigo QR ****************************/
                $qr = new QRCode();
                if ($is_https) {
                    $qr->isHttps();
                } else {
                    $qr->isHttp();
                }
                $dataSerializadaQR = $datos[$i]["codigo_cupon"];
                $qr->setData($dataSerializadaQR);
                $qr->setDimensions(90, 90);
                $qrImg = $qr->getResult();
                
                $documentoPdf = new PdfModel();
                $documentoPdf->setOption('filename', 'cupon-'.$datos[$i]["codigo_cupon"].'.pdf');
                $documentoPdf->setOption('paperOrientation', 'portrait');
                $documentoPdf->setVariables(array(
                    'codigo_cupon' => $datos[$i]["codigo_cupon"],
                    'cantidad' => $datos[$i]["cantidad"],
                    'id_campana' => $datos[$i]["id_campana"],
                    'campana_descripcion' => $datos[$i]["campana_descripcion"],
                    'fecha_compra' => $datos[$i]["fecha_compra"],
                    'fecha_validez' => $datos[$i]["fecha_validez"],
                    'sobre_campana' => $datos[$i]["sobre_campana"],
                    'razon_social' => $datos[$i]["razon_social"],
                    'descripcion_empresa' => $datos[$i]["descripcion_empresa"],
                    'ubicacion_gps' => $datos[$i]["ubicacion_gps"],
                    'web_site' => $datos[$i]["web_site"],
                    'direccion' => $datos[$i]["direccion"],
                    'horario' => $datos[$i]["horario"],
                    'localhost' => $localhost,
                    'barras_img' => 'data:jpeg;base64,' . base64_encode($data128),
                    'qr_img' => $qrImg,
                    'imagen_campana' => $image
                ));

                $documentoPdf->setTerminal(true);
                $documentoPdf->setTemplate('application/campana/cuponbuenaso-pdf.phtml');
                $htmlPdf = $sl->get('viewPdfrenderer')->getHtmlRenderer()->render($documentoPdf);
                //$engine = $sl->get('viewPdfrenderer')->getEngine();
                $engine = new \DOMPDF();
                // Cargamos el HTML en DOMPDF
                $engine->load_html($htmlPdf);
                $engine->render();
                // Obtenemos el PDF en memoria
                $pdfCode = $engine->output(array("compress" => 0));
                //unset($documentoPdf);
                //$documentoPdf->clearOptions();
            //}
            
            $attachment = new MimePart($pdfCode);
            $attachment->type = 'application/pdf';
            $attachment->filename = 'cupon-'.$datos[$i]["codigo_cupon"].'.pdf';
            $attachment->disposition = Mime::DISPOSITION_ATTACHMENT;
            $attachment->encoding = Mime::ENCODING_BASE64;
            
            $body->addPart($attachment);

        }
        
        $excepcionDominios = $config['correo']['excepcion'];
        
        if( count($excepcionDominios) > 0) {
            $dominioCompleto = explode('@', $email);   
            $dominio = explode('.', $dominioCompleto[1]);
            $verifica = strtolower($dominio[0]);

            if (in_array($verifica, $excepcionDominios)) {
                $fuente = 'cuenta-gmail';
            } else {
                $fuente = 'envio-cupones';
            }
        } else {
            $fuente = 'envio-cupones';
        }
        
        $activo   = $config['correo'][$fuente]['activo'];
        $name     = $config['correo'][$fuente]['name'];
        $host     = $config['correo'][$fuente]['host'];
        $port     = $config['correo'][$fuente]['port'];
        $tls      = $config['correo'][$fuente]['tls'];
        $username = $config['correo'][$fuente]['username'];
        $password = $config['correo'][$fuente]['password'];
        $cuenta   = $config['correo'][$fuente]['alias'];

        if($activo == '1') {
            
            $message = new Message();
            $message->addTo($email)
                    ->addFrom($cuenta)
                    ->setSubject('Felicidades acaba de recibir un cupón Rebueno ...‏');

            $transport = new SmtpTransport();
            
            if( $tls ) {
                $connection_config = array(
                    'ssl' => 'tls',
                    'username' => $username,
                    'password' => $password
                );
            } else {
                $connection_config = array(
                    'username' => $username,
                    'password' => $password
                );
            }
            
            $options   = new SmtpOptions(array(
                'name' => $name,
                'host' => $host,
                'port' => $port,
                'connection_class' => 'login',
                'connection_config' => $connection_config
            ));

            $message->setBody($body);

            $transport->setOptions($options);
            $transport->send($message);

        }

        return 1;
    }
    
    public function datosLayout($layout, $config, $pedir) {
        
        $sl = $this->serviceLocator;
        
        $user_session = new Container('user');
        
        $pais             = $config['id_pais'];
        $capital          = $config['id_capital'];
        $telefono_empresa = $config['empresa']['telefono'];
        $display_empresa   = $config['empresa']['nombre'];
        $dominio_empresa   = $config['empresa']['dominio'];
        
        $departamentoTable = $sl->get('Dashboard\Model\UbidepartamentoTable');
        $departamentos     = $departamentoTable->getDepartamentosxPaisFavoritos($pais);
        
        $provinciaTable    = $sl->get('Dashboard\Model\UbiprovinciaTable');
        $provincias        = $provinciaTable->getProvinciasxDepartamento($pais, $capital);
        
        $layout->pais             = $pais;
        $layout->capital          = $capital;
        $layout->telefono_empresa = $telefono_empresa;
        $layout->display_empresa = $display_empresa;
        $layout->dominio_empresa = $dominio_empresa;
        $layout->departamentos    = $departamentos;
        $layout->provincias       = $provincias;
        if( !empty($user_session->username) && $pedir == '1' ) {
            $layout->pedir_registro   = '2';
        } else {
            $layout->pedir_registro   = $pedir;
        }
        
        return 1;
    }


    /**
     *  Accepts a signature created by signature pad in Json format
     *  Converts it to an image resource
     *  The image resource can then be changed into png, jpg whatever PHP GD supports
     *
     *  To create a nicely anti-aliased graphic the signature is drawn 12 times it's original size then shrunken
     *
     *  @param string|array $json
     *  @param array $options OPTIONAL; the options for image creation
     *    imageSize => array(width, height)
     *    bgColour => array(red, green, blue) | transparent
     *    penWidth => int
     *    penColour => array(red, green, blue)
     *    drawMultiplier => int
     *
     *  @return object
     */
    public function _sigJsonToImage ($json, $options = array()) {
      $defaultOptions = array(
        'imageSize' => array(298, 110)
        ,'bgColour' => array(0xff, 0xff, 0xff)
        ,'penWidth' => 2
        ,'penColour' => array(0x14, 0x53, 0x94)
        ,'drawMultiplier'=> 12
      );

      $options = array_merge($defaultOptions, $options);

      $img = imagecreatetruecolor($options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][1] * $options['drawMultiplier']);

      if ($options['bgColour'] == 'transparent') {
        imagesavealpha($img, true);
        $bg = imagecolorallocatealpha($img, 0, 0, 0, 127);
      } else {
        $bg = imagecolorallocate($img, $options['bgColour'][0], $options['bgColour'][1], $options['bgColour'][2]);
      }

      $pen = imagecolorallocate($img, $options['penColour'][0], $options['penColour'][1], $options['penColour'][2]);
      imagefill($img, 0, 0, $bg);

      if (is_string($json))
        $json = json_decode(stripslashes($json));

      foreach ($json as $v) 
         $this->_drawThickLine($img, $v->lx * $options['drawMultiplier'], $v->ly * $options['drawMultiplier'], $v->mx * $options['drawMultiplier'], $v->my * $options['drawMultiplier'], $pen, $options['penWidth'] * ($options['drawMultiplier'] / 2));

      $imgDest = imagecreatetruecolor($options['imageSize'][0], $options['imageSize'][1]);

      if ($options['bgColour'] == 'transparent') {
        imagealphablending($imgDest, false);
        imagesavealpha($imgDest, true);
      }

      imagecopyresampled($imgDest, $img, 0, 0, 0, 0, $options['imageSize'][0], $options['imageSize'][0], $options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][0] * $options['drawMultiplier']);
      imagedestroy($img);

      return $imgDest;
    }

    /**
     *  Draws a thick line
     *  Changing the thickness of a line using imagesetthickness doesn't produce as nice of result
     *
     *  @param object $img
     *  @param int $startX
     *  @param int $startY
     *  @param int $endX
     *  @param int $endY
     *  @param object $colour
     *  @param int $thickness
     *
     *  @return void
     */
    private function _drawThickLine($img, $startX, $startY, $endX, $endY, $colour, $thickness) {
      $angle = (atan2(($startY - $endY), ($endX - $startX)));

      $dist_x = $thickness * (sin($angle));
      $dist_y = $thickness * (cos($angle));

      $p1x = ceil(($startX + $dist_x));
      $p1y = ceil(($startY + $dist_y));
      $p2x = ceil(($endX + $dist_x));
      $p2y = ceil(($endY + $dist_y));
      $p3x = ceil(($endX - $dist_x));
      $p3y = ceil(($endY - $dist_y));
      $p4x = ceil(($startX - $dist_x));
      $p4y = ceil(($startY - $dist_y));

      $array = array(0=>$p1x, $p1y, $p2x, $p2y, $p3x, $p3y, $p4x, $p4y);
      imagefilledpolygon($img, $array, (count($array)/2), $colour);
    }
}
