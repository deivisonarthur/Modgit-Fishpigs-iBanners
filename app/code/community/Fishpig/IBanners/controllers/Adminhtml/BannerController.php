<?php
/**
 * @category    Fishpig
 * @package     Fishpig_iBanners
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_iBanners_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		$this->_setActiveMenu('cms/ibanners');
		$this->renderLayout();
	}
	
	/**
	 * Display the banner grid
	 *
	 */
	public function gridAction()
	{
		$this->getResponse()
			->setBody($this->getLayout()->createBlock('ibanners/adminhtml_banner_grid')->toHtml());
	}
	
	/**
	 * Forward to the edit action so the user can add a new banner
	 *
	 */
	public function newAction()
	{
		$this->_forward('edit');
	}
	
	/**
	 * Display the edit/add form
	 *
	 */
	public function editAction()
	{
		$banner = $this->_initBannerModel();
		$this->loadLayout();
		
		if ($headBlock = $this->getLayout()->getBlock('head')) {
			$titles = array('iBanners by FishPig');
			
			if ($banner) {
				array_unshift($titles, $banner->getTitle());
			}
			else {
				array_unshift($titles, 'Create a Banner');
			}

			$headBlock->setTitle(implode(' - ', $titles));
		}

		$this->renderLayout();
	}
	
	/**
	 * Save the banner
	 *
	 */
	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost('banner')) {
			$banner = Mage::getModel('ibanners/banner')
				->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				
				$this->_handleImageUpload($banner);
				
				$banner->save();
				$this->_getSession()->addSuccess($this->__('Banner was saved'));
			}
			catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
				Mage::logException($e);
			}
			
			if ($this->getRequest()->getParam('back') && $banner->getId()) {
				$this->_redirect('*/*/edit', array('id' => $banner->getId()));
				return;
			}
		}
		else {
			$this->_getSession()->addError($this->__('There was no data to save'));
		}
		
		$this->_redirect('*/*');
	}

	/**
	 * Upload an image and assign it to the model
	 *
	 * @param Fishpig_iBanners_Model_Banner $banner
	 * @param string $field = 'image'
	 */
	protected function _handleImageUpload(Fishpig_iBanners_Model_Banner $banner, $field = 'image')
	{
		$data = $banner->getData($field);

		if (isset($data['value'])) {
			$banner->setData($field, $data['value']);
		}

		if (isset($data['delete']) && $data['delete'] == '1') {
			$banner->setData($field, '');
		}

		if ($filename = Mage::helper('ibanners/image')->uploadImage($field)) {
			$banner->setData($field, $filename);
		}
	}
	
	/**
	 * Delete a ibanners banner
	 *
	 */
	public function deleteAction()
	{
		if ($bannerId = $this->getRequest()->getParam('id')) {
			$banner = Mage::getModel('ibanners/banner')->load($bannerId);
			
			if ($banner->getId()) {
				try {
					$banner->delete();
					$this->_getSession()->addSuccess($this->__('The banner was deleted.'));
				}
				catch (Exception $e) {
					$this->_getSession()->addError($e->getMessage());
				}
			}
		}
		
		$this->_redirect('*/*');
	}
	
	/**
	 * Delete multiple ibanners banners in one go
	 *
	 */
	public function massDeleteAction()
	{
		$bannerIds = $this->getRequest()->getParam('banner');

		if (!is_array($bannerIds)) {
			$this->_getSession()->addError($this->__('Please select some banners.'));
		}
		else {
			if (!empty($bannerIds)) {
				try {
					foreach ($bannerIds as $bannerId) {
						$banner = Mage::getSingleton('ibanners/banner')->load($bannerId);
	
						Mage::dispatchEvent('ibanners_controller_banner_delete', array('ibanners_banner' => $banner));
	
						$banner->delete();
					}
					
					$this->_getSession()->addSuccess($this->__('Total of %d record(s) have been deleted.', count($bannerIds)));
				}
				catch (Exception $e) {
					$this->_getSession()->addError($e->getMessage());
				}
			}
		}
		
		$this->_redirect('*/*');
	}
	
	/**
	 * Initialise the banner model
	 *
	 * @return null|Fishpig_iBanners_Model_Banner
	 */
	protected function _initBannerModel()
	{
		if ($bannerId = $this->getRequest()->getParam('id')) {
			$banner = Mage::getModel('ibanners/banner')->load($bannerId);
			
			if ($banner->getId()) {
				Mage::register('ibanners_banner', $banner);
			}
		}
		
		return Mage::registry('ibanners_banner');
	}
}