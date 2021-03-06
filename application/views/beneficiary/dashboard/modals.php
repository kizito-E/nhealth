<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="new-subscription">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Create or change subscription</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Select HMO</label>
                    <input type="text" class="form-control" placeholder="">
                </div>

                <div class="form-group">
                    <label>Select plan</label>
                    <input type="email" class="form-control" placeholder="">
                </div>
            </div>

            <div class="modal-footer">

                <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left">
                    Close
                </button>

                <button @click="addSite" class="btn btn-primary">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    Submit
                </button>

            </div>
        </div>
    </div>
</div>