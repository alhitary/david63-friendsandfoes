<?php
/**
*
* @package Friends & Foes Extension
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\friendsandfoes\acp;

class friendsandfoes_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container, $user;

		$this->tpl_name		= 'friends_and_foes';
		$this->page_title	= $user->lang('FRIENDS_AND_FOES');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('david63.friendsandfoes.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->display_output();
	}
}
