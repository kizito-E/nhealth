<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends REST_Controller {

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

        $plan_obj = $this->Plan->get(['id' => $id]);

        if (!$plan_obj) $this->response(null, self::HTTP_INTERNAL_ERROR);

        $this->response(['status' => 'success', 'plan' => (array) $plan_obj], self::HTTP_OK);
    }

    public function list_get()
    {
        $plan_objs = $this->Plan->fetch();

        if (!$plan_objs) $this->response(null, self::HTTP_INTERNAL_ERROR);

        $this->response(['status' => 'success', 'plans' => (array) $plan_objs], self::HTTP_OK);
    }

}