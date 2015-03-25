<?php
/**
*
* @package Friends & Foes Extension
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
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
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_USER_UTILS'			=> 'Kullanıcı hizmetleri',

	'ALL'						=> 'Tümü',

	'FILTER_BY'					=> 'Şuna göre filtrele',
	'FILTER_USERNAME'			=> 'Kullanıcı adı',
	'FOE'						=> 'Şunun düşmanı yap',
	'FRIEND'					=> 'Şununla dost ol',
	'FRIENDS_AND_FOES'			=> 'Dostlar & Düşmanlar',
	'FRIENDS_AND_FOES_EXPLAIN'	=> 'Bu size her üyenin dost & düşman listesini verir (nerede ayarlıysa).',

	'NO_FF_DATA'				=> 'Gösterilecek dost ve düşman yok',

	'OTHER'						=> 'Diğer',

	'SELECT_CHAR'				=> 'Karakter seçin',
	'SORT_FOE'					=> 'Düşmanlar',
	'SORT_FRIEND'				=> 'Dostlar',
	'SORT_USERNAME'				=> 'Kullanıcı adı',

	'TOTAL_USERS'				=> 'Kullanıcı sayısı : %1$s',

	'YES'						=> 'Evet',
));
