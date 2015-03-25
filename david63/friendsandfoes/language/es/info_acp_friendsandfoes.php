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
	'ACP_USER_UTILS'			=> 'Utilidades de usuario',

	'ALL'						=> 'Todos',

	'FILTER_BY'					=> 'Filtrar por',
	'FILTER_USERNAME'			=> 'Nombre de usuario',
	'FOE'						=> 'Ignodado(s) de',
	'FRIEND'					=> 'Amigo(s) con',
	'FRIENDS_AND_FOES'			=> 'Amigos e Ignorados',
	'FRIENDS_AND_FOES_EXPLAIN'	=> 'Esto le da una lista de los amigos e ignorados de cada miembro (en conjunto).',

	'NO_FF_DATA'				=> 'No hay amigos e ignodados a mostrar',

	'OTHER'						=> 'Otro',

	'SELECT_CHAR'				=> 'Seleccionar condición',
	'SORT_FOE'					=> 'Ignorados',
	'SORT_FRIEND'				=> 'Amigos',
	'SORT_USERNAME'				=> 'Nombre de usuario',

	'TOTAL_USERS'				=> 'Cantidad de usuarios : %1$s',

	'YES'						=> 'Si',
));
