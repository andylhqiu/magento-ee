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

namespace Enterprise\Rma\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Mage\Sales\Test\Page\SalesGuestView;

/**
 * Open RMA on frontend for Guest step.
 */
class OpenRmaOnFrontendForGuestStep implements TestStepInterface
{
    /**
     * Sales guest view page.
     *
     * @var SalesGuestView
     */
    protected $salesGuestView;

    /**
     * @constructor
     * @param SalesGuestView $salesGuestView
     */
    public function __construct(SalesGuestView $salesGuestView)
    {
        $this->salesGuestView = $salesGuestView;
    }

    /**
     * Open RMA on frontend for Guest.
     *
     * @return void
     */
    public function run()
    {
        $this->salesGuestView->getViewBlock()->openLinkByName('Return');
    }
}
