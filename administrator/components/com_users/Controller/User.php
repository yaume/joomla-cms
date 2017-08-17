<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Joomla\Component\Users\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\Access\Access;
use Joomla\CMS\Controller\Form;
use Joomla\CMS\Model\Model;

/**
 * User controller class.
 *
 * @since  1.6
 */
class User extends Form
{
	/**
	 * @var    string  The prefix to use with controller messages.
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_USERS_USER';

	/**
	 * Overrides \JControllerForm::allowEdit
	 *
	 * Checks that non-Super Admins are not editing Super Admins.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean  True if allowed, false otherwise.
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check if this person is a Super Admin
		if (Access::check($data[$key], 'core.admin'))
		{
			// If I'm not a Super Admin, then disallow the edit.
			if (!$this->app->getIdentity()->authorise('core.admin'))
			{
				return false;
			}
		}

		return parent::allowEdit($data, $key);
	}

	/**
	 * Method to run batch operations.
	 *
	 * @param   object  $model  The model.
	 *
	 * @return  boolean  True on success, false on failure
	 *
	 * @since   2.5
	 */
	public function batch($model = null)
	{
		\JSession::checkToken() or jexit(\JText::_('JINVALID_TOKEN'));

		// Set the model
		$model = $this->getModel('User', 'Administrator', array());

		// Preset the redirect
		$this->setRedirect(\JRoute::_('index.php?option=com_users&view=users' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}

	/**
	 * Function that allows child controller access to model data after the data has been saved.
	 *
	 * @param   Model  $model      The data model object.
	 * @param   array  $validData  The validated data.
	 *
	 * @return  void
	 *
	 * @since   3.1
	 */
	protected function postSaveHook(Model $model, $validData = array())
	{
		return;
	}
}
