<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="add-user">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Create a user account</h4>
            </div>

            <div class="modal-body row">
                <div v-cloak v-if="status_message" class="col-sm-12 callout callout-success callout-animated fadeIn">
                    <p>{{status_message}}</p>
                    <p v-cloak v-if="activation_link">Account activation link: {{activation_link}}</p>
                </div>
                <div class="col-sm-6 form-group">
                    <label>First Name</label>
                    <input v-model="first_name" type="text" class="form-control" placeholder="">
                </div>

                <div class="col-sm-6 form-group">
                    <label>Last Name</label>
                    <input v-model="last_name" type="text" class="form-control" placeholder="">
                </div>

                <div class="col-sm-6 form-group">
                    <label>Business Name</label>
                    <input v-model="business_name" type="text" class="form-control" placeholder="">
                </div>

                <div class="col-sm-6 form-group">
                    <label>Role</label>
                    <select v-model="role" class="form-control selectpicker" data-style="btn-default btn-flat" data-title="Select an account role">
                        <option value="beneficiary" selected >Beneficiary</option>
                        <option value="sp">Service Provider</option>
                        <option value="hmo">Health Manager</option>
                    </select>
                </div>

                <div class="col-sm-12 form-group">
                    <label>Email</label>
                    <input v-model="email" type="email" class="form-control" placeholder="">
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