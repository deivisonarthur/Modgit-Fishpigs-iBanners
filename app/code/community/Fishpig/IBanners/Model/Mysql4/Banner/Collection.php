<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_iBanners_Model_Mysql4_Banner_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('ibanners/banner');
	}

	/**
	 * Init collection select
	 *
	 * @return Fishpig_iBanners_Model_Mysql4_Banner_Collection
	*/
	protected function _initSelect()
	{
		$this->getSelect()->from(array('main_table' => $this->getMainTable()));
		
		return $this;
	}
	
	/**
	 * Filter the collection by a group ID
	 *
	 * @param int $groupId
	 * @return Fishpig_iBanners_Model_Mysql4_Banner_Collection
	 */
	public function addGroupIdFilter($groupId)
	{
		return $this->addFieldToFilter('group_id', $groupId);
	}
	
	/**
	 * Filter the collection by enabled banners
	 *
	 * @param int $isEnabled = true
	 * @return Fishpig_iBanners_Model_Mysql4_Banner_Collection
	 */
	public function addIsEnabledFilter($isEnabled = true)
	{
		return $this->addFieldToFilter('is_enabled', $isEnabled ? 1 : 0);
	}
	
	/**
	 * Add a random order to the banners
	 *
	 * @return Fishpig_iBanners_Model_Mysql4_Banner_Collection
	*/
	public function addOrderByRandom($dir = 'ASC')
	{
		$this->getSelect()->order('RAND() ' . $dir);
		return $this;
	}
	
	/**
	 * Add order by sort order
	 *
	 * @return Fishpig_iBanners_Model_Mysql4_Banner_Collection
	*/
	public function addOrderBySortOrder($dir = 'ASC')
	{
		$this->getSelect()->order('sort_order ' . $dir);
		return $this;
	}
}
