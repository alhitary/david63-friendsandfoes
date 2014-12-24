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
	function main($id, $mode)
	{
		global $db, $user, $template, $request, $phpbb_container, $config;

		$user->add_lang_ext('david63/friendsandfoes', 'friendsandfoes_common');
		$this->tpl_name		= 'friends_and_foes';
		$this->page_title	= $user->lang('FRIENDS_AND_FOES');
		$pagination			= $phpbb_container->get('pagination');
		add_form_key('david63/friendsandfoes');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('david63/friendsandfoes'))
			{
				trigger_error('FORM_INVALID');
			}
		}

		// Start initial var setup
		$action			= $request->variable('action', '');
		$start			= $request->variable('start', 0);
		$fc				= $request->variable('fc', '');
		$filter_by		= $request->variable('filter_by', '');
		$per_page		= $request->variable('users_per_page', (int) $config['topics_per_page']);
		$sort_key		= $request->variable('sk', 'u');
		$sd = $sort_dir	= $request->variable('sd', 'a');

		$sort_dir		= ($sort_dir == 'd') ? ' DESC' : ' ASC';

		$order_ary = array(
			'f'	=> 'z.friend' . $sort_dir. ', u.username_clean ASC',
			'o'	=> 'z.foe' . $sort_dir. ', u.username_clean ASC',
			'u'	=> 'u.username_clean' . $sort_dir,
		);

		if ($fc == 'other')
		{
			for ($i = 97; $i < 123; $i++)
			{
				$filter_by .= ' AND u.username_clean NOT ' . $db->sql_like_expression(chr($i) . $db->any_char);
			}
		}
		else if ($fc)
		{
			$filter_by .= ' AND u.username_clean ' . $db->sql_like_expression(substr($fc, 0, 1) . $db->any_char);
		}

	   	$sql = $db->sql_build_query('SELECT', array(
			'SELECT'	=> 'u.user_id, u.username, u.username_clean, u.user_colour, z.*',
			'FROM'		=> array(
				USERS_TABLE	=> 'u',
				ZEBRA_TABLE	=> 'z',
			),
			'WHERE'		=> 'u.user_id = z.user_id' . $filter_by,
			'ORDER_BY'	=> ($sort_key == '') ? 'u.username_clean' : $order_ary[$sort_key],
		));

		$result = $db->sql_query_limit($sql, $config['topics_per_page'], $start);

		while ($row = $db->sql_fetchrow($result))
		{
			$sql1 = $db->sql_build_query('SELECT', array(
				'SELECT'	=> 'u.user_id, u.username, u.user_colour',
				'FROM'		=> array(
					USERS_TABLE	=> 'u',
				),
				'WHERE'		=> 'u.user_id = ' . $row['zebra_id'],
			));

			$result1	= $db->sql_query($sql1);
			$row1		= $db->sql_fetchrow($result1);

			$template->assign_block_vars('friends_foes', array(
				'FOE'		=> ($row['foe'] == 0) ? '' : get_username_string('full', $row1['user_id'], $row1['username'], $row1['user_colour']),
				'FRIEND'	=> ($row['friend'] == 0) ? '' : get_username_string('full', $row1['user_id'], $row1['username'], $row1['user_colour']),
				'USERNAME'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
			));

			$db->sql_freeresult($result1);
		}

		$db->sql_freeresult($result);

		$sort_by_text	= array('u' => $user->lang['SORT_USERNAME'], 'f' => $user->lang['SORT_FRIEND'], 'o' => $user->lang['SORT_FOE']);
		$limit_days		= array();
		$s_sort_key		= $s_limit_days = $s_sort_dir = $u_sort_param = '';

		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sd, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		// Get total user count for pagination
		$sql = $db->sql_build_query('SELECT', array(
			'SELECT'	=> 'COUNT(z.user_id) AS total_users',
			'FROM'		=> array(
				USERS_TABLE	=> 'u',
				ZEBRA_TABLE	=> 'z',
			),
			'WHERE'		=> 'u.user_id = z.user_id' . $filter_by,
		));

		$result		= $db->sql_query($sql);
		$user_count	= (int) $db->sql_fetchfield('total_users');

		$db->sql_freeresult($result);

		if ($user_count == 0)
		{
			trigger_error($user->lang['NO_FF_DATA']);
		}

 		$action = $this->u_action . '&amp;sk=' . $sort_key . '&amp;sd=' . $sd . '&amp;fc=' . $fc . '&amp;start=' . $start;
		$pagination->generate_template_pagination($action, 'pagination', 'start', $user_count, $per_page, $start);

		$template->assign_vars(array(
			//'S_ON_PAGE'     => $per_page,
			'S_SORT_DIR'	=> $s_sort_dir,
			'S_SORT_KEY'	=> $s_sort_key,

			'U_ACTION'		=> $action,
		));
	}
}

?>