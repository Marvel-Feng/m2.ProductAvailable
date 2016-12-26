<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_ProductAvailable
 * @copyright   Copyright (c) 2016 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Faonni\ProductAvailable\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Customer\Model\Session;

/**
 * Faonni ProductAvailable Data helper
 */
class Data extends AbstractHelper
{
    /**
     * Hide add to cart config path
     */
    const XML_HIDE_ADD_TO_CART = 'catalog/available/hide_add_to_cart';
	
    /**
     * Hide from groups config path
     */
    const XML_HIDE_ADD_TO_CART_GROUPS = 'catalog/available/hide_add_to_cart_groups';
	
    /**
     * Hide price config path
     */
    const XML_HIDE_PRICE = 'catalog/available/hide_price';
	
    /**
     * Hide from groups config path
     */
    const XML_HIDE_PRICE_GROUPS = 'catalog/available/hide_price_groups';
	
    /**
	 * Customer Session
	 *
     * @var \Magento\Customer\Model\Session
     */
    protected $_session;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\Session $session
	 *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Session $session
    ) {
        $this->_session = $session;
        parent::__construct($context);
    }

    /**
     * Check whether the customer allows add to cart
     *
     * @return bool
     */
    public function isAvailableAddToCart()
    {
		if ($this->_getConfig(self::XML_HIDE_ADD_TO_CART)) {
			return !in_array(
				$this->_session->getCustomerGroupId(), 
				explode(',', $this->_getConfig(self::XML_HIDE_ADD_TO_CART_GROUPS))
			);			
		}
		return true;
    }	

    /**
     * Check whether the customer allows price
     *
     * @return bool
     */
    public function isAvailablePrice()
    {
		if ($this->_getConfig(self::XML_HIDE_PRICE)) {
			return !in_array(
				$this->_session->getCustomerGroupId(), 
				explode(',', $this->_getConfig(self::XML_HIDE_PRICE_GROUPS))
			);			
		}
		return true;
    }	 
	
    /**
     * Retrieve store configuration data
     *
     * @param   string $path
     * @return  string|null
     */
    protected function _getConfig($path)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }      
}
