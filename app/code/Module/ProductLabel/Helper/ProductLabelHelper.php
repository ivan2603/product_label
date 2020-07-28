<?php

namespace Module\ProductLabel\Helper;


class ProductLabelHelper extends \Magento\Framework\Url\Helper\Data
{

    protected $storeManager;
    protected $registry;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->registry = $registry;
    }


    public function getProductLabelSelect($product)
    {
        if (!empty($product->getData('badge_label'))) {

            return $product->getData('badge_label');
        } else {
            return "";
        }
    }

    public function getProduct() {
        return $this->registry->registry('product');
    }

    public function getFrontendValue($type)
    {
	    $options = $this->getOptions();
	    if (isset($options[$type])) {
		    return $options[$type];
	    }
		return '';
    }

    public function getOptions() {
        return [
            'sale'          =>  'Sale',
            'free_shipping' =>  'Free Shipping',
            'best_seller'   =>  'Best Seller'
        ];
    }

}
