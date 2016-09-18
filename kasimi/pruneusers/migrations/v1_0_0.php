<?php

/**
 *
 * @package phpBB Extension - Prune Users
 * @copyright (c) 2016 kasimi
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\pruneusers\migrations;

use phpbb\db\migration\migration;

class v1_0_0 extends migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\beta1');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('kasimi_pruneusers_lifetime', '')),
			array('config.add', array('kasimi_pruneusers_gc', strtotime('1 hour', 0))),
			array('config.add', array('kasimi_pruneusers_last_gc', '0', true)),
		);
	}
}
