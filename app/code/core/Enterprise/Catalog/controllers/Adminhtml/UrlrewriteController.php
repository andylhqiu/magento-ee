<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition End User License Agreement
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magento.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Enterprise
 * @package     Enterprise_Catalog
 * @copyright Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Urlrewrites adminhtml controller
 *
 * @category    Enterprise
 * @package     Enterprise_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Catalog_Adminhtml_UrlrewriteController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Ajax products grid action
     */
    public function productGridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Ajax categories tree loader action
     */
    public function categoriesJsonAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog');
    }
}
