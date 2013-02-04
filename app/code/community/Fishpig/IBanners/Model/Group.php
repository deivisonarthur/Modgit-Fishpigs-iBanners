<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_iBanners_Model_Group extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		$this->_init('ibanners/group');
	}
	
	/**
	 * Load the model based on the code field
	 *
	 * @param string $code
	 * @return Fishpig_iBanners_Model_Group
	 */
	public function loadByCode($code)
	{
		return $this->load($code, 'code');
	}
	
	/**
	 * Determine whether the group is enabled
	 *
	 * @return bool
	 */
	public function isEnabled()
	{
		return $this->getIsEnabled();
	}
	
	/**
	 * Retrieve a collection of banners associated with this group
	 *
	 * @return Fishpig_iBanners_Model_Mysql4_Banner_Group
	 */
	public function getBannerCollection()
	{
		if (!$this->hasBannerCollection()) {
			$this->setBannerCollection($this->getResource()->getBannerCollection($this));
		}
		
		return $this->_getData('banner_collection');
	}
	
	/**
	 * Retrieve the amount of banners in this group
	 *
	 * @return int
	 */
	public function getBannerCount()
	{
		if (!$this->hasBannerCount()) {
			$this->setBannerCount($this->getBannerCollection()->count());
		}
		
		return $this->_getData('banner_count');
	}
	
	/**
	 * Determine whether animation is enabled for this group
	 *
	 * @return bool
	 */
	public function isAnimationEnabled()
	{
		return $this->getCarouselAnimate() ? true : false;
	}
	
	/**
	 * Retrieve the carousel duration for this group
	 *
	 * @return int
	 */
	public function getCarouselDuration()
	{
		if (!$this->_getData('carousel_duration')) {
			$this->setCarouselDuration(1);
		}

		return (int)$this->_getData('carousel_duration');
	}
	
	/**
	 * Retrieve the carousel duration for this group
	 *
	 * @return int
	 */
	public function getCarouselAuto()
	{
		if ($this->_getData('carousel_auto') == '') {
			$this->setCarouselAuto(1);
		}
		
		return (int)$this->_getData('carousel_auto');
	}
	
	/**
	 * Retrieve the carousel duration for this group
	 *
	 * @return int
	 */
	public function getCarouselFrequency()
	{
		if (!$this->_getData('carousel_frequency')) {
			$this->setCarouselFrequency(8);
		}
		
		return (int)$this->_getData('carousel_frequency');
	}
	
	/**
	 * Retrieve the carousel duration for this group
	 *
	 * @return int
	 */
	public function getCarouselVisibleSlides()
	{
		if (!$this->_getData('carousel_visible_slides')) {
			$this->setCarouselVisibleSlides(1);
		}
		
		return (int)$this->_getData('carousel_visible_slides');
	}
	
	/**
	 * Retrieve the carousel effect for this group
	 * If no carousel effect is set, get the carousel effect from the config
	 *
	 * @return string
	 */
	public function getCarouselEffect()
	{
		if (!$this->_getData('carousel_effect')) {
			$this->setCarouselEffect('scroll');
		}
		
		return $this->_getData('carousel_effect');
	}

	/**
	 * Retrieve the carousel transition for this group
	 * If no carousel transition is set, get the carousel transition from the config
	 *
	 * @return string
	 */
	public function getCarouselTransition()
	{
		if (!$this->_getData('carousel_transition')) {
			$this->setCarouselTransition('sinoidal');
		}
		
		return $this->_getData('carousel_transition');
	}
	
	/**
	  * Retrieve animation data
	  * This is used to popular the Adminhtml form
	  *
	  * @return array
	  */
	public function getAnimationData()
	{
		return array(
			'carousel_animate' => (int)$this->isAnimationEnabled(),
			'carousel_duration' => 	$this->getCarouselDuration(),
			'carousel_auto' => $this->getCarouselAuto(),
			'carousel_frequency' => $this->getCarouselFrequency(),
			'carousel_visible_slides' => $this->getCarouselVisibleSlides(),
			'carousel_effect' => $this->getCarouselEffect(),
			'carousel_transition' => $this->getCarouselTransition(),
		);
	}
}
