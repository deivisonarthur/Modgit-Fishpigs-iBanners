<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_iBanners_Block_View extends Mage_Core_Block_Template
{
	/**
	 * Determine whether a valid group is set
	 *
	 * @return bool
	 */
	public function hasValidGroup()
	{
		if ($this->helper('ibanners')->isEnabled()) {
			return is_object($this->getGroup());
		}
		
		return false;
	}

	/**
	 * Determine whether the group requires animation
	 *
	 * @return bool
	 */
	public function canAnimate()
	{
		if ($this->hasValidGroup()) {
			$group = $this->getGroup();
		
			return $group->isAnimationEnabled() 
				&& $group->getBannerCount() > $group->getCarouselVisibleSlides();
		}
		
		return false;
	}
	
	/**
	 * Retrieve the ID used for the wrapper div
	 *
	 * @return string
	 */
	public function getWrapperId()
	{
		if (!$this->hasWrapperId()) {
			$this->setWrapperId('ibanners-' . $this->getGroupCode());
		}
		
		return $this->_getData('wrapper_id');
	}
	
	/**
	 * Retrieve the ID used for the wrapper div
	 *
	 * @return string
	 */
	public function getWrapperClass()
	{
		if (!$this->hasWrapperClass()) {
			$this->setWrapperClass('ibanners-wrapper');
		}
		
		return $this->_getData('wrapper_class');
	}
	
	/**
	 * Retrieve the position of the controls (previous/next buttons)
	 * If an empty string is returned, do not show controls
	 *
	 * @return string
	 */
	public function getControlsPosition()
	{
		if (!$this->hasControlsPosition()) {
			$this->setControlsPosition($this->getGroup()->getControlsPosition());
		}
		
		return $this->_getData('controls_position');
	}
	
	/**
	 * Set the group code
	 * The group code is validated before being set
	 *
	 * @param string $code
	 */
	public function setGroupCode($code)
	{
		$currentGroupCode = $this->getGroupCode();
		
		if ($currentGroupCode != $code) {
			$this->setGroup(null);
			$this->setData('group_code', null);

			$group = Mage::getModel('ibanners/group')->loadByCode($code);

			if ($group->getId() && $group->getIsEnabled()) {
				if (in_array($group->getStoreId(), array(0, Mage::app()->getStore()->getId()))) {
					$this->setGroup($group);
					$this->setData('group_code', $code);
				}
			}
		}
		
		return $this;
	}

	/**
	 * Retrieve a collection of banners
	 *
	 * @return Fishpig_iBanners_Model_Mysql4_Banner_Collection
	 */
	public function getBanners()
	{
		return $this->getGroup()->getBannerCollection();
	}
	
	/**
	 * If a template isn't passed in the XML, set the default template
	 *
	 * @return Fishpig_iBanners_Block_View
	 */
	protected function _beforeToHtml()
	{
		parent::_beforeToHtml();
		
		if (!$this->getTemplate()) {
			$this->setTemplate('ibanners/default.phtml');
		}
	
		return $this;	
	}
}
