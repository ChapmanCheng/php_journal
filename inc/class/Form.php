<?php
class Form
{
    private $title;
    private $date;
    private $time_spent;
    private $learned;
    private $resources;

    public function __construct()
    {
        if (!empty($_POST))
            foreach ($_POST as $key => $value)
                $this->{$key} = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
        return false;
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->{$name} = $value;
        } else {
            return false;
        }
    }


    public function insertData($asso_array)
    {
        foreach ($asso_array as $key => $val)
            if (property_exists($this, $key))
                $this->{$key} = $val;
    }

    /**
     * test if object's properties are empty
     * @param {$suppliedKeys} Optional. array of properties to test if respective properties are empty
     * @return if empty, returns true, else false
     */
    public function isEmpty($suppliedKeys = null)
    {
        $vars = get_object_vars($this);

        foreach ($vars as $key => $val)
            if (
                is_null($suppliedKeys) // default 
                || in_array($key, $suppliedKeys) // if include in key criteria
            )
                if (empty($val)) {
                    echo "$key and $val is empty";
                    return true;
                }
        return false;
    }

    /**
     * check if $this->date is a validate date and convert to database accepted format
     * @return {boolean} check date is true or wrong
     */
    public function validateDate()
    {
        if (isset($this->data['date'])) {
            try {
                $date = date('Y-m-d', strtotime($this->data['date']));
                $this->data['date'] = $date;
                return true;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        return false;
    }

    /**
     * Print date into sentence format e.g. June 06, 1989
     * @return {string} date string
     */
    public function printDateString()
    {
        $timestamp = strtotime($this->time_spent);
        return date('F d, Y', $timestamp);
    }

    /**
     * Convert object's properties to associative array
     * @return {array} returns an asso array of properties
     */
    public function getAssoArrayProps()
    {
        return get_object_vars($this);
    }
}
