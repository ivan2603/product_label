<?php

namespace Module\ProductLabel\Model\Config\Source;


class LabelOptions extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

	protected $optionFactory;

    public function getAllOptions()
    {
        $this->_options = [
            ['label' => __('Sale'), 'value'=>'sale'],
            ['label' => __('Free Shipping'), 'value'=>'free_shipping'],
            ['label' => __('Best Seller'), 'value'=>'best_seller']
        ];
        return $this->_options;
    }
}
