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
 * @category    Tests
 * @package     Tests_Functional
 * @copyright Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

namespace Enterprise\GiftCard\Test\TestCase;

use Mage\Checkout\Test\TestCase\DeleteProductsFromShoppingCartTest;

/**
 * Preconditions
 * 1. Test GiftCard product is created.
 *
 * Steps:
 * 1. Add product to Shopping Cart.
 * 2. Click 'Remove item' button from Shopping Cart for product.
 * 3. Perform all asserts.
 *
 * @group Shopping_Cart_(CS)
 * @ZephyrId MPERF-7659
 */
class DeleteGiftCardFromShoppingCartTest extends DeleteProductsFromShoppingCartTest
{
    //
}
