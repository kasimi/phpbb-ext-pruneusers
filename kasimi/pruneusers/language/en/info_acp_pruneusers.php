<?php

/**
 *
 * @package phpBB Extension - Prune Users
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters for use
// ’ » “ ” …

$lang = array_merge($lang, array(
	'PRUNEUSERS_LIFETIME'			=> 'Expiry time of user accounts',
	'PRUNEUSERS_LIFETIME_EXPLAIN'	=> 'Leave empty to disable.',
	'PRUNEUSERS_MODE'				=> 'Action to perform on expired user accounts',
	'PRUNEUSERS_MODE_0'				=> 'Delete users and delete posts',
	'PRUNEUSERS_MODE_1'				=> 'Delete users and retain posts',
	'PRUNEUSERS_MODE_2'				=> 'Deactivate users',
	'PRUNEUSERS_USERNAMES'			=> 'Retain usernames when retaining posts',
	'PRUNEUSERS_USERNAMES_EXPLAIN'	=> 'If set to no, affected posts will be changed to the guest user.',
	'LOG_PRUNEUSERS_NONE'			=> '<strong>No users pruned</strong>',
	'LOG_PRUNEUSERS'				=> '<strong>Pruned %1$d users</strong><br />» %2$s',
));
