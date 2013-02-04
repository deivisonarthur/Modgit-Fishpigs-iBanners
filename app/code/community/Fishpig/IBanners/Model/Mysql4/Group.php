<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_iBanners_Model_Mysql4_Group extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('ibanners/group', 'group_id');
	}

	/**
	 * Retrieve the load select object
	 *
	 * @param string $field
	 * @param mixed $value
	 * @param Mage_Core_Model_Abstract $object
	 * @return Varien_Db_Select
	 */
	protected function _getLoadSelect($field, $value, $object)
	{
		$select = parent::_getLoadSelect($field, $value, $object);
		
		if (!Mage::app()->isSingleStoreMode() && Mage::app()->getStore()->getId() > 0) {
			$select->where('store_id IN (?)', array(0, Mage::app()->getStore()->getId()))
				->order('store_id DESC')
				->limit(1);
		}
	
		return $select;
	}

	/**
	 * Retrieve a collection of banners associated with the group
	 *
	 * @param Fishpig_iBanners_Model_Group $group
	 * @return Fishpig_iBanners_Model_Mysql4_Banner_Collection
	 */
	public function getBannerCollection(Fishpig_iBanners_Model_Group $group, $includeDisabled = false)
	{
		$banners = Mage::getResourceModel('ibanners/banner_collection')
			->addGroupIdFilter($group->getId());
			
		if ($group->getRandomiseBanners()) {
			$banners->addOrderByRandom();
		}
		else {	
			$banners->addOrderBySortOrder();
		}
		
		if (!$includeDisabled) {
			$banners->addIsEnabledFilter(1);
		}
		
		return $banners;
	}
	
	/**
	 * Apply processing before saving object
	 *
	 * @param Mage_Core_Model_Abstract $object
	 */
	protected function _beforeSave(Mage_Core_Model_Abstract $object)
	{
		if (!$object->getCode()) {
			throw new Exception(Mage::helper('ibanners')->__('Banner group must have a unique code'));
		}
		
		$object->setCode($this->formatGroupCode($object->getCode()));
		
		if (Mage::getDesign()->getArea() == 'adminhtml') {
			foreach($object->getData() as $field => $value) {
				if (preg_match("/^use_config_([a-zA-Z_]{1,})$/", $field, $result)) {

					$object->setData($result[1], null);
					$object->unsetData($field);
				}
			}
		}
		
		return parent::_beforeSave($object);
	}
	
	/**
	 * Convert a string into a valid group code
	 *
	 * @param string $str
	 * @return string
	 */
	public function formatGroupCode($str)
	{
		$str = preg_replace('#[^0-9a-z]+#i', '_', Mage::helper('catalog/product_url')->format($str));
		$str = strtolower($str);
		$str = trim($str, '_');
		
		return $str;
	}
}
