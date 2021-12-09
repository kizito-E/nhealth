<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        redirect("/");
    }


    public function login()
    {
        if ($this->Auth2->is_logged()) {
            redirect("main/dashboard");
        }

        $this->load->view('auth/login');
    }

    public function logout()
    {
        $this->Auth2->logout();

        redirect("/");
    }


    public function forgot()
    {
        if ($this->Auth2->is_logged()) {
            redirect("/");
        }

        $this->load->view('auth/forgot');
    }


    public function set_password()
    {
        if ($this->Auth2->is_logged()) {
            redirect("main/dashboard");
        }

        $this->load->view('auth/reset_password');
    }


    public function api_login()
    {
        if (!check_csrf_token()) {
            exit_json(1, "Invalid CSRF Token");
        }

        $email = $this->input->post("email");
        $password = $this->input->post("password");

        try {
            $this->Auth2->login($email, $password);
        } catch (Exception $e) {
            exit_json(1, $e->getMessage());
        }

        exit_json();
    }


    public function api_register()
    {

        if ($this->Auth2->is_logged()) {
            exit_json(1, "An error occurred");
        }

        if (!check_csrf_token()) {
            exit_json(1, "Invalid CSRF Token");
        }

        $this->validation->make([
            "username" => "required|alpha_numeric|is_unique[users.username]",
            "email"    => "required|valid_email|is_unique[users.email]",
            "password" => "required|min_length[8]|max_length[20]",
        ], [
            "username.required"      => __("Имя пользователя не может быть пустым!"),
            "username.alpha_numeric" => __("Запрещенные символы в имени пользователя!"),
            "username.is_unique"     => __("Это имя пользователя уже занято!"),
            "email.required"         => __("Email не может быть пустым!"),
            "email.valid_email"      => __("Некорректный email!"),
            "email.is_unique"        => __("Этот email уже существует в системе!"),
            "password.required"      => __("Пароль не может быть пустым!"),
            "password.min_length"    => __("Длина пароля должна быть не менее {param} символов!"),
            "password.max_length"    => __("Длина пароля должна быть не более {param} символов!"),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $user_obj = $this->User2->add([
            'username'      => $this->input->post("username"),
            'email'         => $this->input->post("email"),
            'password'      => superhash($this->input->post("password")),
            'role'          => 'user',
            'subrole'       => 'webmaster',
            'status'        => 1,
            'register_date' => gmdate('Y-m-d H:i:s'),
        ]);

        if (!$user_obj) {
            exit_json(1, "An error occurred");
        }

        $user_obj->plain_password = $this->input->post("password");

        //event("user.register", $user_obj);

        exit_json();
    }


    public function api_forgot_password()
    {
        if ($this->Auth2->is_logged()) {
            exit_json(1, "An error occurred");
        }

        if (!check_csrf_token()) {
            exit_json(1, "Invalid CSRF Token");
        }

        $this->validation->make([
            "email" => "required|valid_email|is_exists[users.email]"
        ], [
            "email.required"    => "Please enter a valid email",
            "email.valid_email" => "Please enter a valid email",
            "email.is_exists"   => "Email/account not found!",
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $reset_token = $this->User2->generate_reset_password_token([
            'email' => $this->input->post('email')
        ]);

        if (!$reset_token) {
            exit_json(1, "An error occured!");
        }

        event("user.forgot_password", (object) [
            'email'       => $this->input->post('email'),
            'reset_token' => $reset_token,
        ]);

        exit_json();
    }


    public function api_reset_password()
    {
        if ($this->Auth2->is_logged()) {
            exit_json(1, "Error! You're already logged in.");
        }

        if (!check_csrf_token()) {
            exit_json(1, "Invalid CSRF Token");
        }

        $this->validation->make([
            "reset_pass_token" => "required|is_exists[users.reset_pass_token]",
            "new_password"     => "required|min_length[8]|max_length[20]"
        ], [
            "reset_pass_token.*"      => "Invalid password reset/activation link!",
            "new_password.required"   => "Please enter a valid password!",
            "new_password.min_length" => "The provided password must be at least 8 characters",
            "new_password.max_length" => "The provided password must be at most 20 characters",
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $userdata = $this->User2->update([
            'reset_pass_token' => $this->input->post("reset_pass_token"), // where
        ], [
            'password'         => superhash($this->input->post("new_password")),
            'reset_pass_token' => null,
            'status'           => 1
        ]);

        exit_json(0, "Success!");
    }

}
