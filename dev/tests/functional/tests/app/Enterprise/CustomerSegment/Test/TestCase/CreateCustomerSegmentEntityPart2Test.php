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

namespace Enterprise\CustomerSegment\Test\TestCase;

use Enterprise\CustomerSegment\Test\Page\Adminhtml\CustomerSegmentEdit;
use Mage\Cms\Test\Page\CmsIndex;
use Mage\Customer\Test\Fixture\Address;
use Mage\Customer\Test\Fixture\Customer;
use Mage\Customer\Test\Page\Adminhtml\CustomerIndex;
use Mage\Customer\Test\Page\Adminhtml\CustomerEdit;
use Mage\Customer\Test\Page\CustomerAccountLogout;
use Enterprise\CustomerSegment\Test\Fixture\CustomerSegment;
use Enterprise\CustomerSegment\Test\Page\Adminhtml\CustomerSegmentIndex;
use Enterprise\CustomerSegment\Test\Page\Adminhtml\CustomerSegmentNew;
use Mage\SalesRule\Test\Fixture\SalesRule;
use Mage\SalesRule\Test\Page\Adminhtml\PromoQuoteEdit;
use Mage\SalesRule\Test\Page\Adminhtml\PromoQuoteIndex;
use Magento\Mtf\Client\Browser;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

/**
 * Preconditions:
 * 1. Customer is created.
 * 2. Simple product is created.
 *
 * Steps:
 * 1. Login to backend as admin.
 * 2. Navigate to Customers -> Customer Segments.
 * 3. Click 'Add Segment' button.
 * 4. Fill all fields according to dataSet and click 'Save and Continue Edit' button.
 * 5. Navigate to Conditions tab.
 * 6. Add specific test condition according to dataSet.
 * 7. Create Shopping Cart Price Rule matched created customer segment.
 * 9. Perform assertions.
 *
 * @group Customer_Segments_(CS)
 * @ZephyrId MPERF-7432
 */
class CreateCustomerSegmentEntityPart2Test extends CreateCustomerSegmentEntityPart1Test
{
    //
}
