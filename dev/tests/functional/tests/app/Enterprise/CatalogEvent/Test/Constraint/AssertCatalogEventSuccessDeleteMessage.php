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

namespace Enterprise\CatalogEvent\Test\Constraint;

use Enterprise\CatalogEvent\Test\Page\Adminhtml\CatalogEventIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Assert that delete event message is present on events page.
 */
class AssertCatalogEventSuccessDeleteMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Expected delete message.
     */
    const DELETE_MESSAGE = 'Event has been deleted.';

    /**
     * Assert that delete event message is present on events page.
     *
     * @param CatalogEventIndex $catalogEventIndex
     * @return void
     */
    public function processAssert(CatalogEventIndex $catalogEventIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            self::DELETE_MESSAGE,
            $catalogEventIndex->getMessagesBlock()->getSuccessMessages()
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Event delete message is present.';
    }
}
