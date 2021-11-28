<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        check_csrf_token() OR exit_json(1, "Invalid CSRF Token!");
    }

    public function index($id)
    {
        if (!is_numeric($id)) exit_json(['error' => 'parameter must be an integer'], self::HTTP_NOT_ACCEPTABLE);

        $user_obj = $this->User->get(['id' => $id]);

        if (!$user_obj) exit_json(null, self::HTTP_INTERNAL_ERROR);

        unset($user_obj->password);

        exit_json(['status' => 'success', 'user' => (array) $user_obj], self::HTTP_OK);
    }

    public function auth()
    {
        $this->validation->make([
            "email"         => "trim|required|valid_email",
            "password"      => "trim|required|min_length[8]|max_length[20]",
        ], [
            "email.required"         => "Please provide a valid email!",
            "email.valid_email"      => "Please provide a valid email!",
            "password.required"      => "Please provide a valid password!",
            "password.min_length"    => "Password must be at least {param} сharacters!",
            "password.max_length"    => "Password cannot be more than {param} сharacters!",
        ]);

        if ($this->validation->status() === false) {
            exit_json(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        $user_obj = $this->User->get(['email' => $params['email']]);

        if (!$user_obj) exit_json(null, self::HTTP_INTERNAL_ERROR);

        unset($user_obj->password);

        $user_auth = $this->Auth->login($params['email'], $params['password']);

        if ($user_auth !== true) exit_json(['error' => $user_auth], self::HTTP_UNAUTHORIZED);

        exit_json(['status' => 'success', 'user' => (array) $user_obj], self::HTTP_OK);

    }

    public function create()
    {
        (is_administrator() || is_hmo()) OR exit_json(1, "Unauthorized Access!");

        $this->validation->make([
            "first_name"    => "trim|alpha|min_length[2]",
            "last_name"     => "trim|alpha|min_length[2]",
            "business_name" => "trim|alpha|min_length[2]",
            "email"         => "trim|required|valid_email|is_unique[users.email]",
            "password"      => "trim|required|min_length[8]|max_length[20]",
            "role"          => "required|in_list[beneficiary,hmo,sp,admin]",
            "plan_id"       => "numeric|in_list[1,2,3]",
        ], [
            "first_name.*"           => "Please provide a valid first name!",
            "last_name.*"            => "Please provide a valid last name!",
            "business_name.*"        => "Please provide a valid business name!",
            "email.required"         => "Please provide a valid email!",
            "email.valid_email"      => "Please provide a valid email!",
            "email.is_unique"        => "This email address already exists!",
            "password.required"      => "Please provide a valid password!",
            "password.min_length"    => "Password must be at least {param} сharacters!",
            "password.max_length"    => "Password cannot be more than {param} сharacters!",
            "role.*"                 => "Please provide a valid account role!",
            "plan_id.*"              => "Please select a valid plan!",
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $params = $this->input->post();

        $user_obj = $this->User->add([
            'first_name'    => isset($params['first_name']) ? $params['first_name'] : '',
            'last_name'     => isset($params['last_name']) ? $params['last_name'] : '',
            'business_name' => isset($params['business_name']) ? $params['business_name'] : '',
            'email'         => $params['email'],
            'password'      => superhash($params['password']),
            'role'          => $params['role'],
            'plan_id'       => $params['role'] == 'beneficiary' ? $params['plan_id'] : 0,
            'status'        => -1,
        ]);

        if (!$user_obj) exit_json(1, 'Error: Unable to create user.');

        $user_obj->activation_link = base_url() . "reset_password/" . $this->User->generate_reset_password_token([
            'email' => $params['email']
        ]);

        exit_json(0, 'Success: User enrolled!', $user_obj);

    }

    public function update_password()
    {
        $this->validation->make([
            'old_password' => "required|callback__check_old_password",
            'new_password' => "required|differs[old_password]|min_length[8]|max_length[20]",
                ], [
            'old_password.required'            => "Old password is required",
            'old_password._check_old_password' => "Old password is incorrect",
            'new_password.differs'             => "New password must be different from old password",
            'new_password.min_length'          => "Password must be at least 8 characters",
            'new_password.max_length'          => "Password cannot be more than 20 characters",
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $this->User->set_password(userdata()->id, $this->input->post('new_password'));

        exit_json(0, "Settings updated!");
    }

    public function _check_old_password($old_password)
    {
        return $this->User->exists([
            'id'       => userdata()->id,
            'password' => superhash($old_password)
        ]);
    }

    public function update()
    {
        $this->validation->make([
            "user_id"       => "trim|required|numeric",
            "first_name"    => "trim|alpha|min_length[2]",
            "last_name"     => "trim|alpha|min_length[2]",
            "business_name" => "trim|alpha|min_length[2]",
            "status"        => "numeric|in_list[0,1]",
        ], [
            "user_id.required"       => "Please provide a valid user id!",
            "user_id.numeric"        => "User id must be numeric!",
            "first_name.*"           => "Please provide a valid first name!",
            "last_name.*"            => "Please provide a valid last name!",
            "business_name.*"        => "Please provide a valid business name!",
            "status.*"               => "Please provide a valid account status!",
        ]);

        if ($this->validation->status() === false) {
            exit_json(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->User->exists(['id' => $params['user_id']])) {

            exit_json(['error' => 'User does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        $user = $this->User->get(['id' => $params['user_id']]);

        $user_obj = $this->User->update([
            'id' => $params['user_id']
        ],[
            'first_name'    => isset($params['first_name']) ? $params['first_name'] : $user->first_name,
            'last_name'     => isset($params['last_name']) ? $params['last_name'] : $user->last_name,
            'business_name' => isset($params['business_name']) ? $params['business_name'] : $user->business_name,
            'status'        => isset($params['status']) ? $params['status'] : $user->status,
        ]);

        if (!$user_obj) exit_json(null, self::HTTP_INTERNAL_ERROR);

        unset($user_obj->password);

        exit_json(['status' => 'success', 'user' => (array) $user_obj], self::HTTP_OK);

    }

    public function assign()
    {
        $this->validation->make([
            "user_id" =>  "trim|required|numeric",
            "hmo_id"  =>  "trim|required|numeric|differs[user_id]"
        ], [
            "user_id.required"  => "Please provide a valid user id!",
            "user_id.numeric"   => "User id must be numeric!",
            "hmo_id.required"  => "Please provide a valid HMO id!",
            "hmo_id.differs" => "User id and HMO id cannot be the same!",
            "hmo_id.numeric" => "HMO id must be numeric!"
        ]);

        if ($this->validation->status() === false) {
            exit_json(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->User->exists(['id' => $params['user_id']])) {

            exit_json(['error' => 'User does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->User->exists(['id' => $params['hmo_id']])) {

            exit_json(['error' => 'HMO does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        $user = $this->User->get(['id' => $params['user_id']]);
        $hmo  = $this->User->get(['id' => $params['hmo_id']]);

        if ($user->role != 'beneficiary' || $hmo->role != 'hmo') {

            exit_json(['error' => 'Error! Please verify user roles.'], self::HTTP_NOT_ACCEPTABLE);
        }

        $user_obj = $this->User->update([
            'id' => $user->id,
        ],[
            'hmo_id'=> $hmo->id
        ]);

        if (!$user_obj) exit_json(null, self::HTTP_INTERNAL_ERROR);

        unset($user_obj->password);
        exit_json(['status' => 'success', 'user' => (array) $user_obj], self::HTTP_OK);

    }

    public function fetch($role = null)
    {
        (is_administrator() || is_hmo()) OR exit_json(1, "Unauthorized Access!");

        $where = [
            "role !=" => "admin"
        ];

        if (isset($role)) $where['role'] = $role;
        if(is_hmo()) $where['hmo_id'] = userdata()->id;

        $user_objs = $this->User->fetch_dt($where);

        if (!isset($role)) {
            foreach ($user_objs['data'] as &$user_obj) {

                $user_obj['hmo'] = $user_obj['hmo_id'] != 0 ? $this->User->get(['id' => $user_obj['hmo_id']])->business_name : '-';
                $user_obj['plan'] = $user_obj['plan_id'] != 0 ? $this->Plan->get(['id' => $user_obj['plan_id']])->name : '-';
            }
        }

        exit(json_encode(array_merge(['error' => 0], $user_objs), JSON_PRETTY_PRINT));
    }

    public function approve_service()
    {
        $this->validation->make([
            "user_id"   => "trim|required|numeric",
            "record_id" => "trim|required|numeric"
        ], [
            "user_id.required"=> "Please provide a valid user id!",
            "user_id.numeric" => "User id must be numeric!",
            "record_id.required"=> "Please provide a valid record id!",
            "record_id.numeric" => "Record id must be numeric!"
        ]);

        if ($this->validation->status() === false) {
            exit_json(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->Record->exists(['id' => $params['record_id']])) {

            exit_json(['error' => 'Record does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        $record = $this->Record->get(['id' => $params['record_id']]);

        if ($record->user_id != $params['user_id'] || $record->status != 'pending approval') {

            exit_json(['error' => 'Error! Unauthorized Access.'], self::HTTP_NOT_ACCEPTABLE);
        }

        $record_obj = $this->Record->update([
            'id'      => $params['record_id'],
            'user_id' => $params['user_id']
        ],[
            'status'      => 'pending fulfillment',
            'date_updated'=> date('Y-m-d H:i:s')
        ]);

        if (!$record_obj) exit_json(null, self::HTTP_INTERNAL_ERROR);

        exit_json(['status' => 'success', 'record' => (array) $record_obj], self::HTTP_CREATED);

    }

    public function update_service()
    {
        $this->validation->make([
            "user_id"   => "trim|required|numeric",
            "record_id" => "trim|required|numeric",
            "status"    => "trim|required|in_list[completed,cancelled]"
        ], [
            "user_id.required"=> "Please provide a valid user id!",
            "user_id.numeric" => "User id must be numeric!",
            "record_id.required"=> "Please provide a valid record id!",
            "record_id.numeric" => "Record id must be numeric!",
            "status.*"          => "Error! Status must be one of the following: completed or cancelled."
        ]);

        if ($this->validation->status() === false) {
            exit_json(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->Record->exists(['id' => $params['record_id']])) {

            exit_json(['error' => 'Record does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        $record = $this->Record->get(['id' => $params['record_id']]);

        if ($record->user_id != $params['user_id'] || ($record->status != 'pending approval' && $record->status != 'pending fulfillment')) {

            exit_json(['error' => 'Error! Invalid user id or service isn\'t pending approval or fulfillment.'], self::HTTP_NOT_ACCEPTABLE);
        }

        $record_obj = $this->Record->update([
            'id'      => $params['record_id'],
            'user_id' => $params['user_id']
        ],[
            'status'      => $params['status'],
            'date_updated'=> date('Y-m-d H:i:s')
        ]);

        if (!$record_obj) exit_json(null, self::HTTP_INTERNAL_ERROR);

        exit_json(['status' => 'success', 'record' => (array) $record_obj], self::HTTP_CREATED);

    }

}