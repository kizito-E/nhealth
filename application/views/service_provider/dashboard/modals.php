<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="new-service">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">New service request</h4>
            </div>

            <div class="modal-body row">
                <div class="col-sm-6 form-group">
                    <label>Beneficiary ID</label>
                    <input type="text" class="form-control" placeholder="">
                </div>

                <div class="col-sm-6 form-group">
                    <label>Beneficiary email</label>
                    <input type="email" class="form-control" placeholder="">
                </div>

                <div class="col-sm-6 form-group">
                    <label>Total cost</label>
                    <input type="number" class="form-control" placeholder="">
                </div>

                <div class="col-sm-6 form-group">
                    <label>Claim/amount covered</label>
                    <input type="number" class="form-control" placeholder="">
                </div>

                <div class="col-sm-12 form-group">
                    <label>Description</label>
                    <textarea row="2" class="form-control" placeholder=""></textarea>
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