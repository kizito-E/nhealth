<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends MY_Controller {

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

        $subscription_obj = $this->Subscription->get(['id' => $id]);

        if (!$subscription_obj) exit_json(['status' => false, 'error' => "No records found"], self::HTTP_OK);

        $plan_obj = $this->Plan->get(['id' => $subscription_obj->plan_id]);
        $user_obj = $this->User->get(['id' => $subscription_obj->user_id]);
        unset($user_obj->password);

        exit_json([
            'status' => 'success', 
            'subscription' => (array) $subscription_obj,
            'plan' => (array) $plan_obj,
            'user' => (array) $user_obj
        ], self::HTTP_OK);
    }

    public function create_post()
    {
        $this->validation->make([
            "user_id"    => "trim|required|numeric|is_unique[subscriptions.user_id]",
            "plan_id"    => "trim|required|numeric",
            "hmo_id"     => "trim|numeric|differs[user_id]"
        ], [
            "user_id.is_unique" => "User already has a subscription! Please update subscription instead.",
            "user_id.required"  => "Please provide a valid user id!",
            "user_id.numeric"   => "User id must be numeric!",
            "plan_id.*" => "Please provide a valid plan id!",
            "hmo_id.differs" => "User id and HMO id cannot be the same!",
            "hmo_id.numeric" => "HMO id must be numeric!"
        ]);

        if ($this->validation->status() === false) {
            exit_json(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->User->exists(['id' => $params['user_id']])) {

            exit_json(['error' => 'User does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->Plan->exists(['id' => $params['plan_id']])) {

            exit_json(['error' => 'Plan does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        if (isset($params['hmo_id'])){

            if (!$this->User->exists(['id' => $params['hmo_id']])) {

                exit_json(['error' => 'HMO does not exist!'], self::HTTP_NOT_ACCEPTABLE);
            }

            $this->User->update([
                'id' => $params['user_id']
            ],[
                'hmo_id' => $params['hmo_id'],
            ]);

        } else {

            $user_obj = $this->User->get(['id' => $params['user_id']]);
            if (!is_numeric($user_obj->hmo_id) || $user_obj->hmo_id == 0) {

                exit_json(['error' => 'HMO not assigned! Please assign user a HMO.'], self::HTTP_NOT_ACCEPTABLE);
            }
        }

        $subscription_obj = $this->Subscription->add([
            'user_id' => $params['user_id'],
            'plan_id' => $params['plan_id']
        ]);

        if (!$subscription_obj) exit_json(null, self::HTTP_INTERNAL_ERROR);

        $this->User->update([
            'id' => $subscription_obj->user_id
        ],[
            'plan_id' => $subscription_obj->plan_id,
            'subscription_id' => $subscription_obj->id
        ]);

        exit_json(['status' => 'success', 'subscription_id' => $subscription_obj->id], self::HTTP_CREATED);

    }

    public function update_post()
    {
        $this->validation->make([
            "subscription_id" =>  "trim|required|numeric",
            "user_id"     =>  "trim|required|numeric",
            "new_plan_id" => "trim|required|numeric"
        ], [
            "subscription_id.*" => "Please provide a valid subscription id!",
            "user_id.*"     => "Please provide a valid user id!",
            "new_plan_id.*" => "Please provide a valid plan id!"
        ]);

        if ($this->validation->status() === false) {
            exit_json(['error' => $this->validation->first_error()], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->Subscription->exists(['id' => $params['subscription_id']])) {

            exit_json(['error' => 'Subscription does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->Plan->exists(['id' => $params['new_plan_id']])) {

            exit_json(['error' => 'Plan does not exist!'], self::HTTP_NOT_ACCEPTABLE);
        }

        if ($this->Subscription->get(['id' => $params['subscription_id']])->user_id != $params['user_id']) {

            exit_json(['error' => 'User and subscription does not match!'], self::HTTP_NOT_ACCEPTABLE);
        }

        $subscription_obj = $this->Subscription->update([
            'id' => $params['subscription_id']
        ],[
            'plan_id' => $params['new_plan_id']
        ]);

        if (!$subscription_obj) exit_json(null, self::HTTP_INTERNAL_ERROR);

        $this->User->update([
            'id' => $subscription_obj->user_id
        ],[
            'plan_id' => $subscription_obj->plan_id
        ]);

        exit_json(['status' => 'success', 'subscription' => (array) $subscription_obj], self::HTTP_OK);

    }

    public function fetch()
    {
        (is_administrator() || is_hmo()) OR exit_json(1, "Unauthorized Access!");

        $where = [];

        if(is_hmo() || is_administrator()) $where["user_id !="] = userdata()->id;

        $subscription_objs = $this->Subscription->fetch_dt($where);

        foreach ($subscription_objs['data'] as $key => &$subscription_obj) {

            $user = $this->User->get(['id' => $subscription_obj['user_id']]);
            
            $subscription_obj['beneficiary'] = $user->first_name . ' ' . $user->last_name;
            $subscription_obj['plan'] = $this->Plan->get(['id' => $subscription_obj['plan_id']])->name;

            if (is_hmo() && $user->hmo_id != userdata()->id) {
                unset($subscription_objs['data'][$key]);
                $subscription_objs['data'] = array_values($subscription_objs['data']);
            }
        }

        exit(json_encode(array_merge(['error' => 0], $subscription_objs), JSON_PRETTY_PRINT));
    }

}