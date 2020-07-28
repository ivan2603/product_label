<?php
namespace Module\ProductLabel\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Catalog\Model\ResourceModel\Product as ResourceProduct;


class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
    protected $_attributeSet;
    protected $_resourceProduct;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        AttributeSet $attributeSet,
        ResourceProduct $resourceProduct
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->_attributeSet    = $attributeSet;
        $this->_resourceProduct = $resourceProduct;
    }


    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        $setup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
 
        
 
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'badge_label',
            [
                'group' => 'Product Details',
                'label' => 'Product Label Type',
                'type'  => 'varchar',
                'input' => 'multiselect',
                'source' => '\Module\ProductLabel\Model\Config\Source\LabelOptions',
                'required' => false,
                'sort_order' => 30,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'used_in_product_listing' => true,
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'visible_on_front' => false,
                'apply_to'=>'simple, configurable'
            ]
        );
 
        
        $setup->endSetup();
    }
}
