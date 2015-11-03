<?php
/**
*
* @package Friends & Foes Extension
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\friendsandfoes\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

use david63\friendsandfoes\ext;

/**
* Admin controller
*/
class admin_controller implements admin_interface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config				$config		Config object
	* @param \phpbb\db\driver\driver_interface	$db
	* @param \phpbb\request\request				$request	Request object
	* @param \phpbb\template\template			$template	Template object
	* @param \phpbb\user						$user		User object
	* @param \phpbb\pagination					$pagination
	*
	* @return \phpbb\boardrules\controller\admin_controller
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\pagination $pagination)
	{
		$this->config		= $config;
		$this->db  			= $db;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		$this->pagination	= $pagination;
	}

	/**
	* Display the output for this extension
	*
	* @return null
	* @access public
	*/
	public function display_output()
	{
		// Start initial var setup
		$action			= $this->request->variable('action', '');
		$clear_filters	= $this->request->variable('clear_filters', '');
		$fc				= $this->request->variable('fc', '');
		$sort_key		= $this->request->variable('sk', 'u');
		$sd = $sort_dir	= $this->request->variable('sd', 'a');
		$start			= $this->request->variable('start', 0);

		if ($clear_filters)
		{
			$fc				= '';
			$sd = $sort_dir	= 'a';
			$sort_key		= 'u';
		}

		$sort_dir		= ($sort_dir == 'd') ? ' DESC' : ' ASC';

		$order_ary = array(
			'f'	=> 'z.friend' . $sort_dir. ', u.username_clean ASC',
			'o'	=> 'z.foe' . $sort_dir. ', u.username_clean ASC',
			'u'	=> 'u.username_clean' . $sort_dir,
		);

		$filter_by = '';
		if ($fc == 'other')
		{
			for ($i = ord($this->user->lang('START_CHARACTER')); $i	<= ord($this->user->lang('END_CHARACTER')); $i++)
			{
				$filter_by .= ' AND u.username_clean ' . $this->db->sql_not_like_expression(utf8_clean_string(chr($i)) . $this->db->get_any_char());
			}
		}
		else if ($fc)
		{
			$filter_by .= ' AND u.username_clean ' . $this->db->sql_like_expression(utf8_clean_string(substr($fc, 0, 1)) . $this->db->get_any_char());
		}

	   	$sql = $this->db->sql_build_query('SELECT', array(
			'SELECT'	=> 'u.user_id, u.username, u.username_clean, u.user_colour, z.*',
			'FROM'		=> array(
				USERS_TABLE	=> 'u',
				ZEBRA_TABLE	=> 'z',
			),
			'WHERE'		=> 'u.user_id = z.user_id' . $filter_by,
			'ORDER_BY'	=> ($sort_key == '') ? 'u.username_clean' : $order_ary[$sort_key],
		));

		$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$rowset[] = $row;
		}
		$this->db->sql_freeresult($result);

		if (!empty($rowset))
		{
			foreach ($rowset as $rowdata)
			{
				$sql = 'SELECT user_id, username
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . $rowdata['zebra_id'];

				$result = $this->db->sql_query($sql);
				$row	= $this->db->sql_fetchrow($result);

				$this->template->assign_block_vars('friends_foes', array(
					'FOE'		=> ($rowdata['foe'] == 0) ? '' : get_username_string('full', $row['user_id'], $row['username'], 'CC3300'),
					'FRIEND'	=> ($rowdata['friend'] == 0) ? '' : get_username_string('full', $row['user_id'], $row['username'], '006600'),
					'USERNAME'	=> get_username_string('full', $rowdata['user_id'], $rowdata['username'], $rowdata['user_colour']),
		   		));
			}
		}
		$this->db->sql_freeresult($result);

		$sort_by_text	= array('u' => $this->user->lang('SORT_USERNAME'), 'f' => $this->user->lang('SORT_FRIEND'), 'o' => $this->user->lang('SORT_FOE'));
		$limit_days	= array();
		$s_sort_key	= $s_limit_days = $s_sort_dir = $u_sort_param = '';

		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sd, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		// Are there any friends & foes?
		$sql = $this->db->sql_build_query('SELECT', array(
			'SELECT'	=> 'COUNT(z.user_id) AS total_users',
			'FROM'		=> array(
				USERS_TABLE	=> 'u',
				ZEBRA_TABLE	=> 'z',
			),
			'WHERE'		=> 'u.user_id = z.user_id',
		));

		$result			= $this->db->sql_query($sql);
		$fandf_count	= (int) $this->db->sql_fetchfield('total_users');

		$this->db->sql_freeresult($result);

		// Get total user count for pagination
		$sql = $this->db->sql_build_query('SELECT', array(
			'SELECT'	=> 'COUNT(z.user_id) AS total_users',
			'FROM'		=> array(
				USERS_TABLE	=> 'u',
				ZEBRA_TABLE	=> 'z',
			),
			'WHERE'		=> 'u.user_id = z.user_id' . $filter_by,
		));

		$result		= $this->db->sql_query($sql);
		$user_count	= (int) $this->db->sql_fetchfield('total_users');

		$this->db->sql_freeresult($result);

		$action = "{$this->u_action}&amp;sk=$sort_key&amp;sd=$sd";
		$link = ($fandf_count) ? adm_back_link($action . '&amp;start=' . $start) : '';

		if ($user_count == 0)
		{
			trigger_error($this->user->lang('NO_FF_DATA') . $link);
		}

		$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $user_count);
		$this->pagination->generate_template_pagination($action . "&ampfc=$fc", 'pagination', 'start', $user_count, $this->config['topics_per_page'], $start);

		$first_characters		= array();
		$first_characters['']	= $this->user->lang('ALL');
		for ($i = ord($this->user->lang('START_CHARACTER')); $i	<= ord($this->user->lang('END_CHARACTER')); $i++)
		{
			$first_characters[chr($i)] = chr($i);
		}
		$first_characters['other'] = $this->user->lang('OTHER');

		foreach ($first_characters as $char => $desc)
		{
			$this->template->assign_block_vars('first_char', array(
				'DESC'		=> $desc,
				'U_SORT'	=> $action . '&amp;fc=' . $char,
			));
		}

		$this->template->assign_vars(array(
			'FRIENDS_AND_FOES_VERSION'	=> ext::FRIENDS_AND_FOES_VERSION,
			'S_SORT_DIR'				=> $s_sort_dir,
			'S_SORT_KEY'				=> $s_sort_key,
			'TOTAL_USERS'				=> $this->user->lang('TOTAL_USERS', (int) $user_count),

			'U_ACTION'					=> $action . "&ampfc=$fc",
		));
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
