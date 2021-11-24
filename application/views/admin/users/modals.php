<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="add-user">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Create a user account</h4>
            </div>

            <div class="modal-body row">
                <div class="col-sm-6 form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" placeholder="">
                </div>

                <div class="col-sm-6 form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" placeholder="">
                </div>

                <div class="col-sm-6 form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" placeholder="">
                </div>

                <div class="col-sm-6 form-group">
                    <label>Role</label>
                    <select class="form-control selectpicker" data-style="btn-default btn-flat" data-title="Select an account role">
                        <option value="beneficiary">Beneficiary</option>
                        <option value="sp">Service Provider</option>
                        <option value="hmo">Health Manager</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">

                <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left">
                    Close
                </button>

                <button @click="addSite" class="btn btn-primary">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    Create
                </button>

            </div>
        </div>
    </div>
</div>