<?php

class Validation {

    private $ci;
    private $errors   = [];
    private $rules    = [];
    private $messages = [];

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->helper(array('form', 'url', 'validation'));
        $this->ci->load->library('form_validation');

        $this->ci->form_validation->set_error_delimiters('', '');
    }


    public function set_rules($rules = [])
    {
        $this->rules = $rules;
    }


    public function set_messages($messages = [])
    {
        $this->messages = $messages;
    }


    public function make($rules = null, $messages = null)
    {
        $this->errors   = [];
        $this->rules    = isset($rules) ? $rules : $this->rules;
        $this->messages = isset($messages) ? $messages : $this->messages;


        $config = [];

        foreach ($this->rules as $field_name => $_rules) {

            $config[] = [
                'field'  => $field_name,
                'label'  => "\"$field_name\"",
                'rules'  => $_rules,
                'errors' => []
            ];
        }

        foreach ($this->messages as $field_rule => $message) {

            list($field, $rule) = array_pad(explode(".", $field_rule), 2, null);

            foreach ($config as &$value) {

                if ($value['field'] == $field && $rule == "*") {
                    $value['errors'] = $this->fill_one_message($value['field'], $message, $config);
                } else if ($value['field'] == $field && $rule !== null) {
                    $value['errors'][$rule] = $message;
                }
            }
        }

        foreach ($config as $v) {
            $this->ci->form_validation->set_rules($v['field'], $v['label'], $v['rules'], $v['errors']);
        }

        if ($this->ci->form_validation->run() === false) {

            foreach ($this->rules as $k => $v) {
                if (form_error($k)) {
                    $this->errors[$k] = form_error($k);
                }
            }

            if (count($this->errors) == 0) {
                $this->errors[] = "Validation error!";
            }

            return false;
        }

        $this->errors = [];
        return true;
    }


    public function set_data($data)
    {
        $this->ci->form_validation->set_data($data);
    }


    public function errors_assoc()
    {
        return $this->errors;
    }


    public function errors()
    {
        return array_values($this->errors);
    }


    public function first_error()
    {
        $value = reset($this->errors);
        return $value ? $value : null;
    }


    public function first_error_assoc()
    {
        $value = reset($this->errors);

        if (key($this->errors)) {
            return [
                key($this->errors) => $value
            ];
        }

        return null;
    }


    public function status()
    {
        return empty($this->errors) ? true : false;
    }


    public function run()
    {
        $this->make();

        return $this->status();
    }


    // field one message from all rules
    private function fill_one_message($field, $message, $config)
    {
        $rules = '';
        $out   = [];

        foreach ($config as $val) {
            if ($val['field'] == $field) {
                $rules = explode("|", $val['rules']);
                break;
            }
        }

        foreach ($rules as &$val) {
            $val = strtok($val, "[");
            $val = str_replace('callback_', '', $val);
        }

        unset($val);

        foreach ($rules as $val) {
            $out[$val] = $message;
        }


        return $out;
    }


}
