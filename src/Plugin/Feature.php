<?php

namespace Fab\Feature;

!defined( 'WPINC ' ) or die;

/**
 * Initiate plugins
 *
 * @package    Fab
 * @subpackage Fab\Includes
 */

class Feature {

    /**
     * Feature key
     * @var     string
     */
    protected $key;

    /**
     * Feature name
     * @var     string
     */
    protected $name;

    /**
     * Feature description
     * @var     string
     */
    protected $description;

    /**
     * Feature options
     * @var     array
     */
    protected $options;

    /**
     * Feature construect
     * @return void
     * @var    object   $plugin     Feature configuration
     * @pattern prototype
     */
    public function __construct(\Fab\Plugin $plugin){
        $this->options = [];
        $this->hide_on_production = false;
        $this->Plugin = $plugin;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}