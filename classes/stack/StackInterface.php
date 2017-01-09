<?php
/**
 * @package     con4gis
 * @filesource  StackInterface.php
 * @version     1.0.0
 * @since       16.12.16 - 19:08
 * @author      Patrick Froch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2016
 * @license     EULA
 */
namespace c4g\core;

/**
 * Interface StackInterface
 * @package c4g\projects
 */
interface StackInterface
{


    /**
     * add an item to the top of the stack
     * @param array $item
     * @return mixed
     */
    public function push(array $item);


    /**
     * remove the last item added to the top of the stack
     * @return mixed
     */
    public function pop();


    /**
     * look at the item on the top of the stack without removing it
     * @return mixed
     */
    public function top();


    /**
     * return whether the stack contains no more items
     * @return mixed
     */
    public function isEmpty();
}
