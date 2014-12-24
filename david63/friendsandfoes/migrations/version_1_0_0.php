<?php
/**
*
* @package Friends & Foes Extension
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\friendsandfoes\migrations;

class version_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['friendsandfoes_version']) && version_compare($this->config['friendsandfoes_version'], '1.1.0', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\beta3');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('friendsandfoes_version', '1.0.0')),

			array('module.add', array('acp', 'ACP_CAT_USERS',
				array(
					'module_basename'	=> '\david63\friendsandfoes\acp\friendsandfoes_module',
					'modes'				=> array('main'),
				),
			)),
		);
	}
}