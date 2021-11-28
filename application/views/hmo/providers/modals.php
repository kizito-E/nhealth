<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="add-user">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Enroll a new SP</h4>
            </div>

            <div class="modal-body row">
                <p v-cloak v-if="error && status_message" class="bg-danger">{{status_message}}</p>
                <p v-cloak v-if="!error && status_message" class="bg-success">{{status_message}}</p>
                <p v-cloak v-if="!error && status_message && activation_link" class="bg-success">Account activation link: {{activation_link}}</p>
                
                <div class="col-sm-12 form-group">
                    <label>Email</label>
                    <input v-model="email" type="email" class="form-control" placeholder="">
                </div>

                <div class="col-sm-6 form-group">
                    <label>Business Name</label>
                    <input v-model="business_name" type="text" class="form-control" placeholder="">
                </div>

                <div class="col-sm-6 form-group">
                    <label>Role</label>
                    <select v-model="role" disabled class="form-control selectpicker" data-style="btn-default btn-flat" data-title="Select an account role">
                        <option value="sp" selected>Health Service Provider</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">

                <button data-dismiss="modal" class="btn btn-default pull-left">
                    Close
                </button>

                <button @click="addUser" class="btn btn-primary"><i class="fa fa-check fa-fw"></i>
                    Create
                </button>

            </div>
        </div>
    </div>
</div>