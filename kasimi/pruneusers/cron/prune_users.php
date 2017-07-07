<?php

/**
 *
 * @package phpBB Extension - Prune Users
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\pruneusers\cron;

use phpbb\config\config;
use phpbb\cron\task\base;
use phpbb\db\driver\driver_interface;
use phpbb\log\log_interface;
use phpbb\user;

class prune_users extends base
{
	const MODE_REMOVE_USERS_DELETE_POSTS = 0;
	const MODE_REMOVE_USERS_RETAIN_POSTS = 1;
	const MODE_DEACTIVATE_USERS = 2;

	/** @var user */
	protected $user;

	/** @var config */
	protected $config;

	/** @var driver_interface */
	protected $db;

	/** @var log_interface */
	protected $log;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/**
	 * @param user				$user
	 * @param config			$config
	 * @param driver_interface	$db
	 * @param log_interface		$log
	 * @param string			$root_path
	 * @param string			$php_ext
	 * @param config			$config
	 */
	public function __construct(
		user $user,
		config $config,
		driver_interface $db,
		log_interface $log,
		$root_path,
		$php_ext
	)
	{
		$this->user				= $user;
		$this->config			= $config;
		$this->db				= $db;
		$this->log				= $log;
		$this->root_path		= $root_path;
		$this->php_ext			= $php_ext;
	}

	/**
	 * Runs this cron task.
	 */
	public function run()
	{
		$this->user->add_lang('common');

		$expired_users = $this->get_expired_users();

		if ($expired_users)
		{
			if (!function_exists('user_delete'))
			{
				include($this->root_path . 'includes/functions_user.' . $this->php_ext);
			}

			switch ($this->config['kasimi_pruneusers_mode'])
			{
				case self::MODE_REMOVE_USERS_DELETE_POSTS:
					user_delete('remove', array_keys($expired_users), (bool) $this->config['kasimi_pruneusers_usernames']);
					break;

				case self::MODE_REMOVE_USERS_RETAIN_POSTS:
					user_delete('retain', array_keys($expired_users), (bool) $this->config['kasimi_pruneusers_usernames']);
					break;

				case self::MODE_DEACTIVATE_USERS:
					user_active_flip('deactivate', array_keys($expired_users));
					break;
			}

			$this->add_admin_log('LOG_PRUNEUSERS', array(
				count($expired_users),
				implode($this->user->lang('COMMA_SEPARATOR'), $expired_users),
			));
		}
		else
		{
			$this->add_admin_log('LOG_PRUNEUSERS_NONE');
		}

		$this->config->set('kasimi_pruneusers_last_gc', time());
	}

	/**
	 * @return array
	 */
	protected function get_expired_users()
	{
		$lifetime = time() - (strtotime($this->config['kasimi_pruneusers_lifetime'], 0));

		$sql = 'SELECT u.user_id, u.username
				FROM ' . USERS_TABLE . ' u
				WHERE u.user_type = ' . USER_NORMAL . '
					AND u.user_id <> ' . ANONYMOUS . '
					AND u.user_lastvisit < ' . (int) $lifetime;
		$result = $this->db->sql_query($sql);

		$expired_users = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
			$expired_users[(int) $row['user_id']] = $row['username'];
		}
		$this->db->sql_freeresult($result);

		asort($expired_users);

		return $expired_users;
	}

	/**
	 * @param string $lang_key
	 * @param array $additional_data
	 */
	protected function add_admin_log($lang_key, $additional_data = array())
	{
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, $lang_key, false, $additional_data);
	}

	/**
	 * Returns whether this cron task can run, given current board configuration.
	 *
	 * @return bool
	 */
	public function is_runnable()
	{
		return false !== strtotime($this->config['kasimi_pruneusers_lifetime']);
	}

	/**
	 * Returns whether this cron task should run now, because enough time
	 * has passed since it was last run.
	 *
	 * @return bool
	 */
	public function should_run()
	{
		return $this->config['kasimi_pruneusers_last_gc'] < time() - $this->config['kasimi_pruneusers_gc'];
	}
}
