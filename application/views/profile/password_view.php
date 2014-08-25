<div>
    <div class="header-title">
        <h2>
            <?php echo $page_title; ?>
        </h2>
    </div>

    <div>
        <form id="changePasswordForm" role="form">
            <!-- message info -->
            <div id="formChangePasswordMessage" class="alert display-none">
                <span></span>
            </div>
            
            <div>
                <div id="form-group-old_password" class="form-group">
                    <label for="old_password">Old Password *</label>
                    <input type="password" class="form-control width-300px" id="old_password" name="old_password" placeholder="Old Password" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                </div>

                <div id="form-group-new_password" class="form-group">
                    <label for="new_password">New Password *</label>
                    <input type="password" class="form-control width-300px" id="new_password" name="new_password" placeholder="New Password" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                </div>

                <div id="form-group-confirm_password" class="form-group">
                    <label for="confirm_password">Confirm New Password *</label>
                    <input type="password" class="form-control width-300px" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" data-placement="right" data-toggle="popover" data-content="" data-trigger="manual" />
                </div>
                
                <button class="btn btn-default btn-sm" type="submit">
                    <span class="icon-fixed-width glyphicon glyphicon-ok icon-button-left"></span>
                    Change Password
                </button>
            </div>
        </form>
    </div>
</div>
