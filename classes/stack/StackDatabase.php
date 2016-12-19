<?php
/**
 * @package     eden
 * @filesource  StackDatabase.php
 * @version     1.0.0
 * @since       16.12.16 - 19:11
 * @author      Patrick Froch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2016
 * @license     EULA
 */
namespace c4g\core;

/**
 * Class StackDatabase
 * @package c4g\core
 */
class StackDatabase implements StackInterface
{


    /**
     * Name der Tabelle, in der der Stack gespeichert wird.
     * (Wird in der Kindklasse gesetzt!)
     * @var string
     */
    protected $table = '';


    /**
     * Gibt die Datenbankklaase zurück.
     * @return \Contao\Database
     */
    protected  function getDb()
    {
        return \Contao\Database::getInstance();
    }


    /**
     * @return string
     */
    public  function getTable()
    {
        return $this->table;
    }


    /**
     * Führt eine Datanbankabfrage aus.
     * @param $query
     */
    public  function execute($query)
    {
        $db = $this->getDb();
        return $db->execute($query);
    }


    /**
     * Fügt dem Stack ein Element hinzu.
     * @param $item
     */
    public  function push($item)
    {
        $item   = (!is_string($item)) ? serialize($item) : $item;
        $query  = 'INSERT INTO `' . $this->table . '` SET `data` = \'' . $item . '\' , `tstamp` = ' . time();
        return $this->execute($query);
    }


    /**
     * Entfernt ein Element vom Stack.
     * @return array|mixed
     */
    public  function pop()
    {
        $data = $this->top();

        if (is_array($data) && count($data)) {
            $query = 'DELETE FROM `' . $this->table . '` WHERE `id` = ' . $data["id"];
            $this->execute($query);
            return $data;
        }

        return array();
    }


    /**
     * Gibt das oberste Element vom Stack zurück.
     * @return array
     */
    public  function top()
    {
        $query  = 'SELECT * FROM `' . $this->table . '` ORDER BY id ASC LIMIT 1';
        $result = $this->execute($query);

        if ($result->numRows) {
            return $result->fetchAssoc();
        }

        return array();
    }


    /**
     * Prüft, ob der Stack leer ist.
     * @return bool
     */
    public  function isEmpty()
    {
        $query  = 'SELECT * FROM `' . $this->table . '` ORDER BY id ASC LIMIT 1';
        $result = $this->execute($query);

        return ($result->numRows) ? false : true;

    }
}
