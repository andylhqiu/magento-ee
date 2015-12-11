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

namespace Enterprise\GiftRegistry\Test\Constraint;

use Enterprise\GiftRegistry\Test\Fixture\GiftRegistryType;
use Enterprise\GiftRegistry\Test\Page\Adminhtml\BackendGiftRegistryIndex;
use Enterprise\GiftRegistry\Test\Page\Adminhtml\GiftRegistryNew;
use Magento\Mtf\Constraint\AbstractAssertForm;

/**
 * Assert that gift registry type form data is equal to fixture data.
 */
class AssertGiftRegistryTypeForm extends AbstractAssertForm
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Assert that gift registry type form data is equal to fixture data.
     *
     * @param GiftRegistryType $giftRegistryType
     * @param BackendGiftRegistryIndex $giftRegistryIndex
     * @param GiftRegistryNew $giftRegistryNew
     * @return void
     */
    public function processAssert(
        GiftRegistryType $giftRegistryType,
        BackendGiftRegistryIndex $giftRegistryIndex,
        GiftRegistryNew $giftRegistryNew
    ) {
        $giftRegistryIndex->getGiftRegistryGrid()->searchAndOpen(['label' => $giftRegistryType->getLabel()]);
        $formData = $giftRegistryNew->getGiftRegistryForm()->getData($giftRegistryType);
        $fixtureData = $giftRegistryType->getData();
        $errors = $this->verifyData($fixtureData, $formData);
        \PHPUnit_Framework_Assert::assertEmpty($errors, $errors);
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Gift registry type form data is equal to fixture data.';
    }
}
