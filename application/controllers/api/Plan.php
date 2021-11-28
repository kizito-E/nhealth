<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends MY_Controller {

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

        $plan_obj = $this->Plan->get(['id' => $id]);

        if (!$plan_obj) exit_json(null, self::HTTP_INTERNAL_ERROR);

        exit_json(['status' => 'success', 'plan' => (array) $plan_obj], self::HTTP_OK);
    }

    public function list_get()
    {
        $plan_objs = $this->Plan->fetch();

        if (!$plan_objs) exit_json(null, self::HTTP_INTERNAL_ERROR);

        exit_json(['status' => 'success', 'plans' => (array) $plan_objs], self::HTTP_OK);
    }

}