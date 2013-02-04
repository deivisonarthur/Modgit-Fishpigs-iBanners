<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_iBanners_Block_Adminhtml_Banner extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_controller = 'adminhtml_banner';
		$this->_blockGroup = 'ibanners';
		$this->_headerText = $this->__('iBanners / Banner');
	}
}