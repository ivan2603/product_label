<?php
namespace Module\ProductLabel\Plugin\Magento\ConfigurableProduct\Block\Product\View\Type;

use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Json\DecoderInterface;

class Configurable
{
	protected $jsonEncoder;
	protected $jsonDecoder;
	protected $_productRepository;

	public function __construct(
		\Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
		EncoderInterface $jsonEncoder,
		DecoderInterface $jsonDecoder

	) {
		$this->jsonDecoder = $jsonDecoder;
		$this->jsonEncoder = $jsonEncoder;
		$this->_productRepository = $productRepository;
	}



	public function getProductById($id)
	{
		return $this->_productRepository->getById($id);
	}

	public function afterGetJsonConfig(
		\Magento\ConfigurableProduct\Block\Product\View\Type\Configurable $subject,
		$result
	)
	{
		$config = $result;
		$config = $this->jsonDecoder->decode($config);
		$config['custom_attribute'] = [];
		/*$attribute = NULL;*/

		foreach ($subject->getAllowProducts() as $simpleProduct) {
			if (!empty($simpleProduct->getData('badge_label'))) {
				$config['custom_attribute'][$simpleProduct->getId()] = explode(',', $simpleProduct->getData('badge_label'));
			}
		}

		return $this->jsonEncoder->encode($config);
	}
}
