<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */


class Fishpig_iBanners_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Determine whether the extension is enabled
	 *
	 * @return bool
	 */
	public function isEnabled()
	{
		return Mage::getStoreConfig('ibanners/settings/enabled');
	}
}
