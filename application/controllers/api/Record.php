<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Record extends MY_Controller {

    /**
     * Constructor
     */

    public function __construct()
    {
        parent::__construct();

        check_csrf_token() OR exit_json(1, "Invalid CSRF Token!");
    }

    public function index_get($id)
    {
        if (!is_numeric($id)) exit_json(['error' => 'parameter must be an integer'], self::HTTP_NOT_ACCEPTABLE);

        $record_obj = $this->Record->get(['id' => $id]);

        if (!$record_obj) exit_json(['status' => false, 'error' => "No records found"], self::HTTP_OK);

        exit_json(['status' => 'success', 'record' => (array) $record_obj], self::HTTP_OK);
    }

    public function create()
    {
        $this->validation->make([
            "user_id"    => "trim|required|numeric",
            "description"=> "trim|required|alpha_numeric_spaces|min_length[3]|max_length[255]",
            "cost"       => "trim|required|numeric",
            "amount_due" => "trim|required|numeric",
        ], [
            "user_id.required"=> "Please provide a valid user id!",
            "user_id.numeric" => "User id must be numeric!",
            "description.*"   => "Please enter a valid description of 3-255 characters!",
            "cost.*"         => "Please enter a valid cost for this service!",
            "amount_due.*"   => "Please enter a valid amount payable by the HMO!"
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $params = $this->input->post();

        if ($params['amount_due'] > $params['cost']) {
            
            exit_json(1, 'Amount payable to HMO cannot be greater than total cost!');
        }

        if (!$this->User->exists(['id' => $params['user_id']])) {

            exit_json(1, 'User does not exist!');
        }

        $user = $this->User->get(['id' => $params['user_id']]);

        if ($user->role != 'beneficiary') {

            exit_json(1, 'Error! Please provide a valid beneficiary ID.');
        }

        if ($params['user_id'] == userdata()->id) exit_json(1, 'Beneficiary and service provider cannot be the same!');

        if (!$this->Subscription->exists(['user_id' => $params['user_id']])) {

            exit_json(1, 'User has no active subscription!');
        }

        $record_obj = $this->Record->add([
            'user_id'    => $params['user_id'],
            'hmo_id'     => $user->hmo_id,
            'sp_id'      => userdata()->id,
            'description'=> $params['description'],
            'cost'       => $params['cost'],
            'amount_due' => $params['amount_due'],
            'status'     => 'pending approval'
        ]);

        if (!$record_obj) exit_json(1, 'Error! Unable to create service record.');

        exit_json(0, 'Success! Service initiated', $record_obj);

    }

    public function update_post()
    {
        $this->validation->make([
            "sp_id"      => "trim|required|numeric",
            "record_id"  => "trim|required|numeric",
            "description"=> "trim|alpha_numeric_spaces|min_length[3]|max_length[255]",
            "cost"       => "trim|numeric",
            "amount_due" => "trim|numeric",
        ], [
            "record_id.required"=> "Please provide a valid record id!",
            "record_id.numeric" => "Record id must be numeric!",
            "description.*"   => "Please enter a valid description of 3-255 characters!",
            "sp_id.required" => "Please provide a valid service provider id!",
            "sp_id.numeric"  => "Service provider id must be numeric!",
            "cost.*"         => "Please enter a valid cost for this service!",
            "amount_due.*"   => "Please enter a valid amount payable by the HMO!"
        ]);

        if ($this->validation->status() === false) {
            exit_json(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->Record->exists(['id' => $params['record_id']])) {

            exit_json(['error' => 'Record does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }
        $record = $this->Record->get(['id' => $params['record_id']]);

        if ($record->sp_id != $params['sp_id']) {

            exit_json(['error' => 'Error! Unauthorized Access.'], self::HTTP_NOT_ACCEPTABLE);
        }
        
        if (isset($params['amount_due']) && isset($params['cost'])) {

            if ($params['amount_due'] > $params['cost']) {
            
                exit_json(['error' => 'Amount payable to HMO cannot be greater than total cost!'], self::HTTP_NOT_ACCEPTABLE);
            }
        }

        $record_obj = $this->Record->update([
            'id'    => $params['record_id'],
            'sp_id' => $params['sp_id']
        ],[
            'description' => isset($params['description']) ? $params['description'] : $record->description,
            'cost'        => isset($params['cost']) ? $params['cost'] : $record->cost,
            'amount_due'  => isset($params['amount_due']) ? $params['amount_due'] : $record->amount_due,
            'date_updated'=> date('Y-m-d H:i:s')
        ]);

        if (!$record_obj) exit_json(null, self::HTTP_INTERNAL_ERROR);

        exit_json(['status' => 'success', 'record' => (array) $record_obj], self::HTTP_CREATED);

    }

    public function fetch()
    {
        $where = [];

        if(is_hmo() || is_sp() || is_administrator()) $where["user_id !="] = userdata()->id;

        if(is_beneficiary()) $where["user_id"] = userdata()->id;
        if(is_hmo()) $where["hmo_id"] = userdata()->id;
        if(is_sp())  $where["sp_id"] = userdata()->id;

        $record_objs = $this->Record->fetch_dt($where);

        foreach ($record_objs['data'] as $key => &$record_obj) {

            $bf  = $this->User->get(['id' => $record_obj['user_id']]);
            
            $record_obj['beneficiary'] = $bf->first_name . ' ' . $bf->last_name;
            $record_obj['sp']  = $this->User->get(['id' => $record_obj['sp_id']])->business_name;
            $record_obj['hmo'] = $this->User->get(['id' => $record_obj['hmo_id']])->business_name;
        }

        exit(json_encode(array_merge(['error' => 0], $record_objs), JSON_PRETTY_PRINT));
    }

    public function user_records_get($id)
    {
        if (!is_numeric($id)) exit_json(['error' => 'parameter must be an integer'], self::HTTP_NOT_ACCEPTABLE);

        $record_objs = $this->Record->fetch(['user_id' => $id]);

        if (!$record_objs) exit_json(['status' => false, 'error' => "No records found"], self::HTTP_OK);

        exit_json(['status' => 'success', 'records' => (array) $record_objs], self::HTTP_OK);
    }

}