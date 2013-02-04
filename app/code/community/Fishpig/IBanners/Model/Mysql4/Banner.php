<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_iBanners_Model_Mysql4_Banner extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('ibanners/banner', 'banner_id');
	}
	
	/**
	 * Logic performed before saving the model
	 *
	 * @param Mage_Core_Model_Abstract $object
	 * @return Fishpig_iBanners_Model_Mysql4_Banner
	 */
	protected function _beforeSave(Mage_Core_Model_Abstract $object)
	{
		if (!$object->getGroupId()) {
			$object->setGroupId(null);
		}
		
		return parent::_beforeSave($object);
	}
	
	/**
	 * Retrieve the group model associated with the banner
	 *
	 * @param Fishpig_iBanners_Model_Banner $banner
	 * @return Fishpig_iBanners_Model_Group
	 */
	public function getGroup(Fishpig_iBanners_Model_Banner $banner)
	{
		if ($banner->getGroupId()) {
			$group = Mage::getModel('ibanners/group')->load($banner->getGroupId());
			
			if ($group->getId()) {
				return $group;
			}
		}
		
		return false;
	}
}
