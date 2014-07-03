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

/**
 * Handels Activationkeys
 */
class C4gActivationkeyModel extends \Model
{
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_c4g_activationkey';

	/**
	 * generates an activationlink from geiven key
	 * @param  string $key
	 * @return string
	 */
	public static function generateActivationLink( $url, $key )
	{
		// check if key exists
		if (empty( $key )) {
			return false;
		}
		// build activation-link
		$actLink = substr( $actPart, 0, strpos( $url, '=' ) + 1 );
		$actLink .= static::getActionForKey( $key ) . ':' . $key;
		// return the link as string 	TODO(/or html-link)
		return $actLink;
	}

	/**
	 * Generates an Activationkey and saves it in the DB, if $saveInDB is true
	 * @param  string  $action
	 * @param  boolean $saveInDB
	 * @return string
	 */
	public static function generateActivationkey( $action='', $saveInDB=true )
	{
		// generate a unique key
		$attempts = 42;
		do {
			$key = md5(uniqid(rand(), true));
			$hasKey = static::findOneBy( 'activationkey', $key );
			$attempts--;
		} while (!empty( $hasKey ) && $attempts > 0);
		if (!empty( $hasKey )) { return false; }

		// save key in database
		if ($saveInDB) {
			$objKey = new C4gActivationkeyModel();
			$objKey->activationkey = $key;
			$objKey->expiration_date = strtotime('+1 month', time());
			$objKey->key_action = $action;
			$objKey->save();
		}
		
		return $key;
	}

	/**
	 * assigns an user to a key, if not already claimed
	 * @param  int $userId
	 * @param  string $key
	 * @return boolean
	 */
	public static function assignUserToKey( $userId, $key )
	{
		$objKey = static::findBy( 'activationkey', $key );
		if (empty( $hasKey ) || $objKey->used_by == 0) { return false; }
		$objKey->used_by = $userId;
		$objKey->save();
		return true;
	}

	/**
	 * returns the action connected to the given key
	 * @param  string $key
	 * @return string
	 */
	public static function getActionForKey( $key )
	{
		return static::findOneBy( 'activationkey', $key )->key_action;
	}
}?>