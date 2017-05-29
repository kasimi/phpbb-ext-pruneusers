<?php

/**
 *
 * @package phpBB Extension - Prune Users
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\pruneusers\event;

use kasimi\pruneusers\cron\prune_users;
use phpbb\event\data;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_board_config_edit_add' => 'acp_board_config_edit_add',
		);
	}

	/**
	 * @param data $event
	 */
	public function acp_board_config_edit_add($event)
	{
		$this->inject_configs($event, array(
			'mode'		=> 'features',
			'position'	=> array('after' => 'allow_quick_reply'),
			'configs'	=> array(
				'kasimi_pruneusers_lifetime' => array(
					'lang' 		=> 'PRUNEUSERS_LIFETIME',
					'type'		=> 'text:0:255',
					'explain'	=> true,
				),
				'kasimi_pruneusers_mode' => array(
					'lang' 		=> 'PRUNEUSERS_MODE',
					'type'		=> 'custom',
					'function'	=> array($this, 'prune_users_mode'),
					'explain'	=> false,
				),
				'kasimi_pruneusers_usernames' => array(
					'lang' 		=> 'PRUNEUSERS_USERNAMES',
					'type'		=> 'radio:yes_no',
					'explain'	=> false,
				),
			),
		));
	}

	/**
	 * @param data $event
	 * @param array $options Required keys: mode,position,configs
	 */
	protected function inject_configs($event, $options)
	{
		if ($event['mode'] == $options['mode'])
		{
			$display_vars = $event['display_vars'];
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $options['configs'], $options['position']);
			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
		}
	}

	/**
	 * @param string $value
	 * @param string $key
	 * @return string
	 */
	public function prune_users_mode($value, $key)
	{
		$radio_ary = array(
			prune_users::MODE_REMOVE_USERS_DELETE_POSTS	=> 'PRUNEUSERS_MODE_' . prune_users::MODE_REMOVE_USERS_DELETE_POSTS,
			prune_users::MODE_REMOVE_USERS_RETAIN_POSTS	=> 'PRUNEUSERS_MODE_' . prune_users::MODE_REMOVE_USERS_RETAIN_POSTS,
			prune_users::MODE_DEACTIVATE_USERS			=> 'PRUNEUSERS_MODE_' . prune_users::MODE_DEACTIVATE_USERS,
		);

		return h_radio('config[kasimi_pruneusers_mode]', $radio_ary, $value, $key, false, '<br>');
	}
}
