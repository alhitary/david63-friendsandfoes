<?php
/**
*
* @package Friends & Foes Extension
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
* Translated By : Bassel Taha Alhitary - www.alhitary.net
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
	'ACP_USER_UTILS'			=> 'خدمات العضو',

	'ALL'						=> 'الجميع',

	'FF_SORT'					=> 'ترتيب',
	'FF_CLEAR_FILTER'			=> 'الترتيب الإفتراضي',
	'FILTER_BY'					=> 'الترتيب بواسطة',
	'FILTER_USERNAME'			=> 'إسم المستخدم',
	'FOE'						=> 'اضاف إلى قائمة الخصوم',
	'FRIEND'					=> 'اضاف إلى قائمة الأصدقاء',
	'FRIENDS_AND_FOES'			=> 'الأصدقاء و الخصوم',
	'FRIENDS_AND_FOES_EXPLAIN'	=> 'من هنا تستطيع أن تحصل على قائمة الأصدقاء والخصوم لكل عضو في منتداك.',

	'NO_FF_DATA'				=> 'لا يوجد أصدقاء و خصوم لعرضهم',

	'OTHER'						=> 'آخر',

	'SELECT_CHAR'				=> 'اختار حرف',
	'SORT_FOE'					=> 'الخصوم',
	'SORT_FRIEND'				=> 'الأصدقاء',
	'SORT_USERNAME'				=> 'إسم المستخدم',

	'TOTAL_USERS'				=> 'عدد الأصدقاء و الخصوم : <strong>%1$s</strong>',

	'YES'						=> 'نعم',

	// Translators - set these to whatever is most appropriate in your language
	// These are used to populate the filter keys
	'START_CHARACTER'		=> 'A',
	'END_CHARACTER'			=> 'Z',
));
