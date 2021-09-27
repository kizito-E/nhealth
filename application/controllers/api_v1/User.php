<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index_get($id)
    {
        if (!is_numeric($id)) $this->response(['error' => 'parameter must be an integer'], self::HTTP_NOT_ACCEPTABLE);

        $user_obj = $this->User->get(['id' => $id]);

        if (!$user_obj) $this->response(null, self::HTTP_INTERNAL_ERROR);

        unset($user_obj->password);

        $this->response(['status' => 'success', 'user' => (array) $user_obj], self::HTTP_OK);
    }

    public function auth_post()
    {
        $params = $this->post();

        $this->validation->set_data($params);
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
            $this->response(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        $user_auth = $this->Auth->login($params['email'], $params['password']);

        if ($user_auth !== true) $this->response(['error' => $user_auth], self::HTTP_UNAUTHORIZED);

        $this->response(['status' => 'success'], self::HTTP_OK);

    }

    public function create_post()
    {

        $params = $this->post();

        $this->validation->set_data($params);
        $this->validation->make([
            "first_name"    => "trim|required|alpha|min_length[2]",
            "last_name"     => "trim|required|alpha|min_length[2]",
            "business_name" => "trim|alpha|min_length[2]",
            "email"         => "trim|required|valid_email|is_unique[users.email]",
            "password"      => "trim|required|min_length[8]|max_length[20]",
            "role"          => "required|in_list[benefactor,hmo,sp,admin]",
        ], [
            "first_name.*"           => "Please provide a valid first name!",
            "last_name.*"            => "Please provide a valid last name!",
            "email.required"         => "Please provide a valid email!",
            "email.valid_email"      => "Please provide a valid email!",
            "email.is_unique"        => "This email address already exists!",
            "password.required"      => "Please provide a valid password!",
            "password.min_length"    => "Password must be at least {param} сharacters!",
            "password.max_length"    => "Password cannot be more than {param} сharacters!",
            "sub_role.*"             => "Please provide a valid account role!",
        ]);

        if ($this->validation->status() === false) {
            $this->response(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        $user_obj = $this->User->add([
            'first_name'    => $params['first_name'],
            'last_name'     => $params['last_name'],
            'business_name' => isset($params['business_name']) ? $params['business_name'] : '',
            'email'         => $params['email'],
            'password'      => superhash($params['password']),
            'role'          => $params['role'],
            'status'        => 1,
        ]);

        if (!$user_obj) $this->response(null, self::HTTP_INTERNAL_ERROR);

        $this->response(['status' => 'success', 'user_id' => $user_obj->id], self::HTTP_CREATED);

    }

    public function list_get()
    {
        $user_objs = $this->User->fetch();

        if (!$user_objs) $this->response(null, self::HTTP_INTERNAL_ERROR);

        foreach ($user_objs as &$user_obj) {
            unset($user_obj->password);
        }

        $this->response(['status' => 'success', 'users' => (array) $user_objs], self::HTTP_OK);
    }

}