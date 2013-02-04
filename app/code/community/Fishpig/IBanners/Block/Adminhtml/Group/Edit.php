<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_iBanners_Block_Adminhtml_Group_Edit  extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();
		
		$this->_controller = 'adminhtml_group';
		$this->_blockGroup = 'ibanners';
		$this->_headerText = $this->_getHeaderText();
		
		$this->_addButton('save_and_edit_button', array(
			'label'     => Mage::helper('catalog')->__('Save and Continue Edit'),
			'onclick'   => 'editForm.submit(\''.$this->getSaveAndContinueUrl().'\')',
			'class' => 'save'
		));
	}
	
	/**
	 * Retrieve the URL used for the save and continue link
	 * This is the same URL with the back parameter added
	 *
	 * @return string
	 */
	public function getSaveAndContinueUrl()
	{
		return $this->getUrl('*/*/save', array(
			'_current'   => true,
			'back'       => 'edit',
		));
	}
    
    /**
     * Retrieve the header text
     * If splash page exists, use name
     *
     * @return string
     */
	protected function _getHeaderText()
	{
		if ($group = Mage::registry('ibanners_group')) {
			if ($displayName = $group->getTitle()) {
				return $displayName;
			}
		}
	
		return $this->__('Edit Banner Group');
	}
}
