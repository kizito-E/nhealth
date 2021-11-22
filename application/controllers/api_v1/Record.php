<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Record extends REST_Controller {

    /**
     * Constructor
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function index_get($id)
    {
        if (!is_numeric($id)) $this->response(['error' => 'parameter must be an integer'], self::HTTP_NOT_ACCEPTABLE);

        $record_obj = $this->Record->get(['id' => $id]);

        if (!$record_obj) $this->response(['status' => false, 'error' => "No records found"], self::HTTP_OK);

        $this->response(['status' => 'success', 'record' => (array) $record_obj], self::HTTP_OK);
    }

    public function create_post()
    {

        $params = $this->post();

        $this->validation->set_data($params);
        $this->validation->make([
            "user_id"    => "trim|required|numeric",
            "hmo_id"     => "trim|required|numeric|differs[user_id]",
            "sp_id"      => "trim|required|numeric|differs[user_id]|differs[hmo_id]",
            "description"=> "trim|required|alpha_numeric_spaces|min_length[3]|max_length[255]",
            "cost"       => "trim|required|numeric",
            "amount_due" => "trim|required|numeric",
        ], [
            "user_id.required"=> "Please provide a valid user id!",
            "user_id.numeric" => "User id must be numeric!",
            "description.*"   => "Please enter a valid description of 3-255 characters!",
            "hmo_id.required" => "Please provide a valid HMO id!",
            "hmo_id.differs" => "User id and HMO id cannot be the same!",
            "hmo_id.numeric" => "HMO id must be numeric!",
            "sp_id.required" => "Please provide a valid service provider id!",
            "sp_id.differs"  => "User id, HMO id, and service provider IDs cannot be the same!",
            "sp_id.numeric"  => "Service provider id must be numeric!",
            "cost.*"         => "Please enter a valid cost for this service!",
            "amount_due.*"   => "Please enter a valid amount payable by the HMO!"
        ]);

        if ($this->validation->status() === false) {
            $this->response(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        if ($params['amount_due'] > $params['cost']) {
            
            $this->response(['error' => 'Amount payable to HMO cannot be greater than total cost!'], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->User->exists(['id' => $params['user_id']])) {

            $this->response(['error' => 'User does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->User->exists(['id' => $params['hmo_id']])) {

            $this->response(['error' => 'HMO does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->User->exists(['id' => $params['sp_id']])) {

            $this->response(['error' => 'Service provider does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        $user = $this->User->get(['id' => $params['user_id']]);
        $hmo  = $this->User->get(['id' => $params['hmo_id']]);
        $sp   = $this->User->get(['id' => $params['sp_id']]);

        if ($user->role != 'benefactor' || $hmo->role != 'hmo' || $sp->role != 'sp') {

            $this->response(['error' => 'Error! Please verify user roles.'], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->Subscription->exists(['user_id' => $params['user_id']])) {

            $this->response(['error' => 'User has no active subscription!'], self::HTTP_NOT_ACCEPTABLE);
        }

        $record_obj = $this->Record->add([
            'user_id'    => $params['user_id'],
            'hmo_id'     => $params['hmo_id'],
            'sp_id'      => $params['sp_id'],
            'description'=> $params['description'],
            'cost'       => $params['cost'],
            'amount_due' => $params['amount_due'],
            'status'     => 'pending approval'
        ]);

        if (!$record_obj) $this->response(null, self::HTTP_INTERNAL_ERROR);

        $this->response(['status' => 'success', 'record' => (array) $record_obj], self::HTTP_CREATED);

    }

    public function update_post()
    {
        $params = $this->post();

        $this->validation->set_data($params);
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
            $this->response(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->Record->exists(['id' => $params['record_id']])) {

            $this->response(['error' => 'Record does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }
        $record = $this->Record->get(['id' => $params['record_id']]);

        if ($record->sp_id != $params['sp_id']) {

            $this->response(['error' => 'Error! Unauthorized Access.'], self::HTTP_NOT_ACCEPTABLE);
        }
        
        if (isset($params['amount_due']) && isset($params['cost'])) {

            if ($params['amount_due'] > $params['cost']) {
            
                $this->response(['error' => 'Amount payable to HMO cannot be greater than total cost!'], self::HTTP_NOT_ACCEPTABLE);
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

        if (!$record_obj) $this->response(null, self::HTTP_INTERNAL_ERROR);

        $this->response(['status' => 'success', 'record' => (array) $record_obj], self::HTTP_CREATED);

    }

    public function list_get()
    {
        $record_objs = $this->Record->fetch();

        if (!$record_objs) $this->response(['status' => false, 'error' => "No records found"], self::HTTP_OK);

        $this->response(['status' => 'success', 'records' => (array) $record_objs], self::HTTP_OK);
    }

    public function user_records_get($id)
    {
        if (!is_numeric($id)) $this->response(['error' => 'parameter must be an integer'], self::HTTP_NOT_ACCEPTABLE);

        $record_objs = $this->Record->fetch(['user_id' => $id]);

        if (!$record_objs) $this->response(['status' => false, 'error' => "No records found"], self::HTTP_OK);

        $this->response(['status' => 'success', 'records' => (array) $record_objs], self::HTTP_OK);
    }

}