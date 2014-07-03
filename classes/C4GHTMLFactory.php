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

namespace c4g;


class C4GHTMLFactory 
{
	protected $defaultInputClass 			= 'c4gInput';
	protected $defaultDivClass 				= 'c4gDiv';
	protected $defaultButtonClass 			= 'c4gButton';

	/**
	 * inserts an <br>-tag
	 * @return string
	 */
	public static function lineBreak()
	{
		return '<br>';
	}

	/**
	 * inserts an <hr>-tag
	 * @return string
	 */
	public static function horizontalLine()
	{
		return '<hr>';
	}

	/**
	 * wrapps a string with HTML-headline-tags
	 * @param  string  $content
	 * @param  integer $type
	 * @return string
	 */
	public static function headline( $content, $type = 1 )
	{
		return '<h' . $type . '>' . $content . '</h' . $type . '>';
	}

	/**
	 * wrapps a string with <p>-tags
	 * @param  string $content
	 * @param  string $id
	 * @param  string $class
	 * @return string
	 */
	public static function paragraph( $content, $id = '', $class = '' )
	{
		$attr = '';
		if (!empty( $id )) {
			$attr .= ' id="' . $id . '"';
		}
		if (!empty( $class )) {
			$attr .= ' class="' . $class . '"';
		}
		return '<p' . $attr . '>' . $content . '</p>';
	}

	/**
	 * wrapps a string with <span>-tags
	 * @param  string $content
	 * @param  string $id
	 * @param  string $class
	 * @return string
	 */
	public static function span( $content, $id = '', $class = '' )
	{
		$attr = '';
		if (!empty( $id )) {
			$attr .= ' id="' . $id . '"';
		}
		if (!empty( $class )) {
			$attr .= ' class="' . $class . '"';
		}
		return '<span' . $attr . '>' . $content . '</span>';
	}

	// ----------------------------------------------------------------------------------
	// comming soon
	// ----------------------------------------------------------------------------------
	public static function textfield(  )
	{
		//with label
	}

	public static function checkbox( )
	{
		//PASS
	}

	public static function radiobutton( )
	{
		//PASS
	}

	public static function dropdown( )
	{
		//PASS
	}

	public static function unsortedList( )
	{
		//PASS
	}
}?>