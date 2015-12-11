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
 * @category    Unserialize
 * @package     Unserialize_Parser
 * @copyright Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Class Unserialize_Parser
 */
class Unserialize_Parser
{
    const TYPE_STRING = 's';
    const TYPE_INT = 'i';
    const TYPE_DOUBLE = 'd';
    const TYPE_ARRAY = 'a';
    const TYPE_BOOL = 'b';

    const SYMBOL_QUOTE = '"';
    const SYMBOL_SEMICOLON = ';';
    const SYMBOL_COLON = ':';

    /**
     * @param $str
     * @return array|null
     * @throws Exception
     */
    public function unserialize($str)
    {
        $reader = new Unserialize_Reader_Arr();
        $prevChar = null;
        for ($i = 0; $i < strlen($str); $i++) {
            $char = $str[$i];
            $arr = $reader->read($char, $prevChar);
            if (!is_null($arr)) {
                return $arr;
            }
            $prevChar = $char;
        }
        throw new Exception('Error during unserialization');
    }
}
