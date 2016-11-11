<?php

/**
 *
 * @package phpBB Extension - Prune Users
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\pruneusers\event;

use Symfony\Component\EventDispatcher\Event;
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
	 * @param Event $event
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
					'explain'	=> false,
				),
			),
		));
	}

	/**
	 * @param Event $event
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
}
