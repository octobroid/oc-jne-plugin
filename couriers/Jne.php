<?php namespace Octobro\Jne\Couriers;

use Input;
use Flash;
use Redirect;
use Exception;
use Veritrans_Snap;
use Veritrans_Config;
use ApplicationException;
use Octommerce\Shipping\Classes\CourierBase;

class Jne extends CourierBase
{
    public $table = 'octobro_jne_costs';

    protected $is_cod = false;

    /**
     * {@inheritDoc}
     */
    public function courierDetails()
    {
        return [
            'name'        => 'JNE',
            'description' => 'Jalur Nugraha Ekakurir Indonesia'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function defineFormFields()
    {
        return 'fields.yaml';
    }

    /**
     * {@inheritDoc}
     */
    public function registerServices()
    {
        return [
            [
                'code' => 'jne-oke',
                'name' => 'OKE',
                'desc' => 'Estimasi pengiriman 3-4 hari setelah pengemasan dan produk dikirim. Khusus area pedalaman atau terpencil, estimasi pengiriman dapat berubah. Penghitungan biaya kirim berdasarkan berat atau dimensi produk.'
            ],
            [
                'code' => 'jne-reg',
                'name' => 'Regular',
                'desc' => 'Estimasi pengiriman 2-3 hari setelah pengemasan dan produk dikirim. Khusus area pedalaman atau terpencil, estimasi pengiriman dapat berubah. Penghitungan biaya kirim berdasarkan berat atau dimensi produk.'
            ],
            [
                'code' => 'jne-yes',
                'name' => 'YES (Yakin Esok Sampai)',
                'desc' => 'Estimasi pengiriman 1 hari setelah pengemasan dan produk dikirim. Khusus area pedalaman atau terpencil, estimasi pengiriman dapat berubah. Penghitungan biaya kirim berdasarkan berat atau dimensi produk.'
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getShippingCost($data, $cart)
    {
        $service = $this->findServiceColumnByCode($data['service']);

        $costRecord = $this->getCostRecord($data['shipping_location_code']);

        if (!$costRecord) {
            throw new ApplicationException('Location is not available.');
        }

        return max(ceil($cart->total_weight/1000), 1) * $costRecord->{$service};
    }

    /**
     * Find column name by service code
     *
     * @param string $service service code
     *
     * @return string $service column name
     */
    public function findServiceColumnByCode($service)
    {
        switch ($service) {
            case 'jne-reg':
                $service = 'reg';
                break;
            case 'jne-yes':
                $service = 'yes';
                break;
            case 'jne-oke':
                $service = 'oke';
                break;
        }

        return $service;
    }

}
