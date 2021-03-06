<?php
/**
*
* CCMarketplace - Classified Ads for Joomla!
*
* @package		Marketplace
* @subpackage	Backend
* @author		Lucas Huber
*
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class CCMarketplaceControllerGroupids extends JController
{
	function display() {

        JRequest::setVar('view', 'groupids');

        parent::display();

    }


	function publish() {

		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if ( !is_array( $cid ) || count( $cid ) < 1) {

			$msg = '';

			JError::raiseWarning(500, JText::_( 'SELECT ITEM PUBLISH' ) );

		}
		else {

			$model = $this->getModel( 'groupids');

			if( !$model->publish( $cid, 1)) {
				JError::raiseError( 500, $model->getError());
			}

			$msg 	= JText::_( 'CCMP_GROUP_PUBLISHED');

			$cache = &JFactory::getCache('com_ccmarketplace');
			$cache->clean();

		}

		$this->setRedirect( 'index.php?option=com_ccmarketplace&view=groupids', $msg );
	}


	function unpublish() {

		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if ( !is_array( $cid ) || count( $cid ) < 1) {

			$msg = '';

			JError::raiseWarning(500, JText::_( 'SELECT ITEM UNPUBLISH' ) );

		}
		else {

			$model = $this->getModel( 'groupids');

			if( !$model->publish( $cid, 0)) {
				JError::raiseError( 500, $model->getError());
			}

			$msg 	= JText::_( 'CCMP_GROUP_UNPUBLISHED');

			$cache = &JFactory::getCache('com_ccmarketplace');
			$cache->clean();

		}

		$this->setRedirect( 'index.php?option=com_ccmarketplace&view=groupids', $msg );
	}




	function orderup() {

		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );

		JArrayHelper::toInteger($cid);

		if (isset($cid[0]) && $cid[0]) {

			$id = $cid[0];

		}
		else {

			$this->setRedirect( 'index.php?option=com_ccmarketplace&view=groupids', JText::_( 'No Items Selected') );

			return false;

		}

		$model =& $this->getModel( 'groupids' );

		if ( $model->orderup( $id)) {

			$msg = JText::_( 'Group Moved Up' );

		}
		else {

			$msg = $model->getError();

		}

		$this->setRedirect( 'index.php?option=com_ccmarketplace&view=groupids', $msg );

	}



	function orderdown() {

		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );

		JArrayHelper::toInteger($cid);

		if (isset($cid[0]) && $cid[0]) {

			$id = $cid[0];

		}
		else {

			$this->setRedirect( 'index.php?option=com_ccmarketplace&view=groupids', JText::_( 'No Items Selected') );

			return false;
		}

		$model =& $this->getModel( 'groupids' );

		if ( $model->orderdown( $id)) {

			$msg = JText::_( 'Group Moved Down' );

		}
		else {

			$msg = $model->getError();

		}

		$this->setRedirect( 'index.php?option=com_ccmarketplace&view=groupids', $msg );

	}




	function edit() {

		JRequest::checkToken() or jexit( 'Invalid Token' );

		JRequest::setVar( 'view', 'groupid' );

		JRequest::setVar( 'hidemainmenu', 1 );

		$model 	= $this->getModel('groupid');

		parent::display();

	}



	function add() {

		JRequest::checkToken() or jexit( 'Invalid Token' );

		JRequest::setVar( 'view', 'groupid' );

		JRequest::setVar( 'hidemainmenu', 1 );

		$model 	= $this->getModel('groupid');

		parent::display();

	}



	function remove() {

		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );

		JArrayHelper::toInteger( $cid);

		if (count( $cid ) < 1) {

			JError::raiseError(500, JText::_( 'Select an item to delete' ) );

		}

		$model = $this->getModel('groupid');

		if( !$model->delete($cid)) {
			JError::raiseWarning(500, $model->getError() );
			//echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";

		} else {
			$msg = JText::_( 'CCMP_GROUP_DELETE_SUCCESSFULLY' );
		}

		$this->setRedirect( 'index.php?option=com_ccmarketplace&view=groupids', $msg );

	}

}
?>
