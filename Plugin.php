<?php namespace Octobro\Jne;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerShippingCouriers()
    {
    	return [
    		'Octobro\Jne\Couriers\Jne' => 'jne',
    	];
    }
}
