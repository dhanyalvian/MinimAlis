<div class="form-signin">
    <!-- message info -->
    <div id="loginMessage" class="alert alert-danger display-none">
        <!--button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button-->
        <span></span>
    </div>
    
    <form id="form-signin" class="">
        <div class="panel panel-default form-signin-area">
            <!--h2 class="form-signin-heading">Please sign in</h2-->
            <div class="panel-heading">
                <h3 class="panel-title">Sign in</h3>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label for="cms_username">Username</label>
                    <input type="hidden" id="sid" name="sid" value="<?php echo $this->input->get('sid', true); ?>" />
                    <input type="text" id="cms_username" name="cms_username" class="form-control width-100" placeholder="Username" />
                </div>

                <div class="form-group">
                    <label for="cms_password">Password</label>
                    <input type="password" id="cms_password" name="cms_password" class="form-control width-100" />
                </div>

                <!--label class="checkbox">
                    <input type="checkbox" value="remember-me"> Remember me
                </label-->

                <button class="btn btn-default btn-sm" type="submit">
                    <span class="icon-fixed-width glyphicon glyphicon-log-in icon-button-left"></span>
                    Sign in
                </button>

                <!--span style="margin-left:10px;"><a href="#">Forgot password</a></span-->
            </div>
        </div>
    </form>
</div>
