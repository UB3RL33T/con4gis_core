<?php

/**
 * Contao Open Source CMS
 *
 * @version   php 5
 * @package   con4gis
 * @author    Tobias Dobbrunz
 * @license   GNU/LGPL http://opensource.org/licenses/lgpl-3.0.html
 * @copyright Küstenschmiede GmbH Software & Design 2014
 * @link      https://www.kuestenschmiede.de
 * @filesource 
 */



$GLOBALS['TL_DCA']['tl_c4g_activationkey'] = array
(
//___CONFIG________________________________________________________________________________________________________________________________
	'config' => array
	(
		'dataContainer'               => 'Table',
		'closed'                      => true,
		'notEditable'                 => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

//___LISTS________________________________________________________________________________________________________________________________
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('tstamp DESC', 'id DESC'),
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('tstamp', 'text'),
			'format'                  => '<span style="color:#b3b3b3;padding-right:3px">[%s]</span> %s',
			'maxCharacters'           => 96,
			// 'label_callback'          => array('tl_log', 'colorize')
		),
		'global_operations' => array
		(
			// 'all' => array
			// (
			// 	'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
			// 	'href'                => 'act=select',
			// 	'class'               => 'header_edit_all',
			// 	'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			// )
		),
		'operations' => array
		(
			// 'delete' => array
			// (
			// 	'label'               => &$GLOBALS['TL_LANG']['tl_log']['delete'],
			// 	'href'                => 'act=delete',
			// 	'icon'                => 'delete.gif',
			// 	'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			// ),
			// 'show' => array
			// (
			// 	'label'               => &$GLOBALS['TL_LANG']['tl_log']['show'],
			// 	'href'                => 'act=show',
			// 	'icon'                => 'show.gif'
			// )
		)
	),

//___FIELDS________________________________________________________________________________________________________________________________
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'activationkey' => array
		(
			'sql'                     => "varchar(40) NOT NULL default ''"
		),
		'expiration_date' => array
		(
			'sql'                     => "int(10) NOT NULL default '0'"
		),
		'key_action' => array
		(
			'sql'                     => "varchar(40) NOT NULL default '0'"
		),
		'used_by' => array
		(
			'sql'                     => "varchar(40) NOT NULL default '0'"
		),
	)
);
?>