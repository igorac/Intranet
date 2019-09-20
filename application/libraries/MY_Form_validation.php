<?php

    class MY_Form_validation extends CI_Form_validation {

    public function __construct($config)
    {
        parent::__construct($config);
    }
    
        public function clear_field_data() {
            $_POST = array();
            $this->_field_data = array();
            return $this;
        }
    }