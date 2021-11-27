<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="new-service">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">New service request</h4>
            </div>

            <div class="modal-body row">
                <p v-cloak v-if="error && status_message" class="bg-danger">{{status_message}}</p>
                <p v-cloak v-if="!error && status_message" class="bg-success">{{status_message}}</p>

                <div class="col-sm-4 form-group">
                    <label>Beneficiary ID</label>
                    <input v-model="user_id" type="text" class="form-control" placeholder="">
                </div>

                <div class="col-sm-4 form-group">
                    <label>Total cost</label>
                    <input v-model="cost" type="number" class="form-control" placeholder="">
                </div>

                <div class="col-sm-4 form-group">
                    <label>Amount due</label>
                    <input v-model="amount_due" type="number" class="form-control" placeholder="">
                </div>

                <div class="col-sm-12 form-group">
                    <label>Description</label>
                    <textarea v-model="description" row="2" class="form-control" placeholder=""></textarea>
                </div>
            </div>

            <div class="modal-footer">

                <button data-dismiss="modal" class="btn btn-default pull-left">
                    Close
                </button>

                <button @click="addService" class="btn btn-primary">
                    <i class="fa fa-check fa-fw"></i>
                    Create
                </button>

            </div>
        </div>
    </div>
</div>