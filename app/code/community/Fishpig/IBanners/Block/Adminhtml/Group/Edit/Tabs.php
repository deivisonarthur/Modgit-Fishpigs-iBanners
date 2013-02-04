<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_iBanners_Block_Adminhtml_Group_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('ibanners_group_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle($this->__('iBanners / Group'));
	}
	
	protected function _beforeToHtml()
	{
		$this->addTab('general',
			array(
				'label' => $this->__('General'),
				'title' => $this->__('General'),
				'content' => $this->getLayout()->createBlock('ibanners/adminhtml_group_edit_tab_form')->toHtml(),
			)
		);
		
		if (Mage::registry('ibanners_group')) {
			$this->addTab('banners',
				array(
					'label' => $this->__('Banners'),
					'title' => $this->__('Banners'),
					'content' => $this->getLayout()->createBlock('ibanners/adminhtml_group_edit_tab_banners')->toHtml(),
				)
			);
		}
		
		return parent::_beforeToHtml();
	}
}
