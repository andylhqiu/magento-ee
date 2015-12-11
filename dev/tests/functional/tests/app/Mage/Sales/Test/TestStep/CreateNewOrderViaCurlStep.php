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

namespace Mage\Sales\Test\TestStep;

use Mage\Sales\Test\Fixture\Order;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Create new order via curlstep.
 */
class CreateNewOrderViaCurlStep implements TestStepInterface
{
    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * Order dataSet.
     *
     * @var string
     */
    protected $orderDataSet;

    /**
     * @constructor
     * @param FixtureFactory $fixtureFactory
     * @param string $orderDataSet
     */
    public function __construct(FixtureFactory $fixtureFactory, $orderDataSet)
    {
        $this->fixtureFactory = $fixtureFactory;
        $this->dataSet = $orderDataSet;
    }

    /**
     * Create new order via curl.
     *
     * @return array
     */
    public function run()
    {
        /** @var Order $order */
        $order = $this->fixtureFactory->createByCode('order', ['dataSet' => $this->orderDataSet]);
        $order->persist();

        return ['order' => $order];
    }
}
