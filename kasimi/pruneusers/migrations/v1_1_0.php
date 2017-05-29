<?php

/**
 *
 * @package phpBB Extension - Prune Users
 * @copyright (c) 2017 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\pruneusers\migrations;

use kasimi\pruneusers\cron\prune_users;
use phpbb\db\migration\migration;

class v1_1_0 extends migration
{
	static public function depends_on()
	{
		return array('\kasimi\pruneusers\migrations\v1_0_0');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('kasimi_pruneusers_mode', prune_users::MODE_REMOVE_USERS_DELETE_POSTS)),
			array('config.add', array('kasimi_pruneusers_usernames', 0)),
		);
	}
}
