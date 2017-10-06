<?php

namespace App\Http\Controllers;

use App\Comprobante;
use App\TipoComprobante;
use GuzzleHttp\Client;

class AfipAPIController extends Controller
{
    private $base_url = 'https://wsfe.folderit.net/api/';
    public function generarCae(Comprobante $comprobante)
    {
        $client = new Client([
            'verify' => false,
            'http_errors' => false,
            'base_uri' => $this->base_url,
        ]);

        $username = env('AFIPAPI_USERNAME', 'hermesws');
        $password = env('AFIPAPI_PASSWORD', 'CarriedEquipmentPaperRapidly');
        $code = env('AFIPAPI_CODE', 'MBUSTOS');
        $ImpNeto =  (float)$comprobante->importe_neto;
        $ImpConc =  0;
        $ImpOpEx =  0;
        $ImpTrib =  0;
        $ImpIva =  (float)$comprobante->importe_iva;
        $IdIVA =  5; // IVA 21%
        $DocTipo =  80; // TODO ver tipo doc
        $DocNro =  str_replace('-', '', $comprobante->cliente_cuit);
        $PtoVta =  (int)$comprobante->punto_venta;
        $comprobante->numero = $this->ultimoComprobante($PtoVta, $comprobante->tipo_comprobante) + 1;
        $CbteNro = (int)$comprobante->numero;
        $CbteFch =  str_replace('-', '', $comprobante->fecha);
        $Concepto =  2; // TODO ver concepto; 1=productos; 2=servicios; 3=prod y serv
        $CantReg =  1;
        $CbteTipo = $this->getNumeroTipoComprobante($comprobante->tipo_comprobante);
        $MonId =  'PES';
        $MonCotiz =  1;

        // TODO ver tributos
        /*        $Tributos =  [
                    {
                    $Id =  0;
                    $Desc =  string;
                    $BaseImp =  0;
                    $Alic =  0;
                    $Importe =  0
                    }
                  ]
                }*/
        $res = $client->request('POST', $code . '/WSFEv1/FECAESolicitar', [
            'json' => [
                'username' => $username,
                'password' => $password,
                'ImpNeto' => $ImpNeto,
                'ImpConc' => $ImpConc,
                'ImpOpEx' => $ImpOpEx,
                'ImpTrib' => $ImpTrib,
                'ImpIva' => $ImpIva,
                'IdIVA' => $IdIVA,
                'DocNro' => $DocNro,
                'PtoVta' => $PtoVta,
                'DocTipo' => $DocTipo,
                'CbteNro' => $CbteNro,
                'CbteFch' => $CbteFch,
                'Concepto' => $Concepto,
                'CantReg' => $CantReg,
                'CbteTipo' => $CbteTipo,
                'MonId' => $MonId,
                'MonCotiz' => $MonCotiz,
            ]
        ]);
        if ($res->getStatusCode() === 200) {
            $data = json_decode($res->getBody(), true)['data'];
            $comprobante->cae = $data['CAE'];
            $comprobante->fecha_cae = $data['CbteFch'];
            $comprobante->fecha_venc_cae = $data['CAEFchVto'];
            $comprobante->save();
            return $comprobante;
        } else {
            return $res;
//            throwException(new \Exception($res));
//            return $comprobante;
        }
    }

    public function ultimoComprobante($punto_venta, TipoComprobante $tipo_comprobante)
    {
        $client = new Client([
            'verify' => false,
            'http_errors' => false,
            'base_uri' => $this->base_url,
        ]);
        $username = env('AFIPAPI_USERNAME', 'hermesws');
        $password = env('AFIPAPI_PASSWORD', 'CarriedEquipmentPaperRapidly');
        $code = env('AFIPAPI_CODE', 'MBUSTOS');
        $PtoVta = $punto_venta;
        $CbteTipo = $this->getNumeroTipoComprobante($tipo_comprobante);

        $res = $client->request('POST', $code . '/WSFEv1/FECompUltimoAutorizado', [
            'json' => [
                'username' => $username,
                'password' => $password,
                'PtoVta' => $PtoVta,
                'CbteTipo' => $CbteTipo
            ]
        ]);
        if ($res->getStatusCode() === 200) {
            return json_decode($res->getBody(), true)['data'];
        } else {
            throwException(new \Exception($res));
            return $res;
        }
    }
    
    private function getNumeroTipoComprobante(TipoComprobante $tipo_comprobante)
    {
        switch ($tipo_comprobante->codigo) {
            case 'FCA':
                return 1;
                break;
            case 'FCB':
                return 6;
                break;
            case 'FCC':
                return 11;
                break;
            case 'NDA':
                return 2;
                break;
            case 'NDB':
                return 7;
                break;
            case 'NDC':
                return 12;
                break;
            case 'NCA':
                return 3;
                break;
            case 'NCB':
                return 8;
                break;
            case 'NCC':
                return 14;
                break;
        }
        throwException(new \Exception('Código de comprobante no soportado'));
        return 0;
    }
}
