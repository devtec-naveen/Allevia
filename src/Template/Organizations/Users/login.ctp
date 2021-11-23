<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">
            Organization 
            <b>
                Panel
            </b>
        </a>
        <small>
            Your Personal AI-powered Medical Assistant
        </small>
    </div>
    <div class="card">
        <div class="body">
        <?php echo $this->Flash->render(); ?>            
            <?= $this->Form->create(null,['autocomplete'=>'off','id'=>'admin_login']) ?>
                <div class="msg">
                    Sign in to start your session
                </div>
               

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">
                            person
                        </i>
                    </span>
                    <div class="form-line">
                       <div class="input email required" aria-required="true">
                            <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off" required="required" id="email" aria-required="true" aria-invalid="false">
                        </div>                        
                    </div>
                </div>

                 <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">
                            lock
                        </i>
                    </span>
                    <div class="form-line">
                       <div class="input email required" aria-required="true">
                            <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required="required" id="password" aria-required="true" aria-invalid="false">
                        </div>                        
                    </div>
                </div>

               
                <div class="row">
                    <div class="col-xs-8 p-t-5">
                    <!--     <input class="filled-in chk-col-pink" id="rememberme" name="rememberme" type="checkbox">
                            <label for="rememberme">
                                Remember Me
                            </label>
                        </input> -->
                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-block bg-blue waves-effect" type="submit">
                            SIGN IN
                        </button>
                    </div>
                </div>
                <div class="row m-t-15 m-b--20">
                    <div class="col-xs-12 align-center">
                       <?php  echo $this->Html->link(
                                  'Forgot Password?',
                                  ['controller' => 'Users', 'action' => 'forgotPassword', '_full' => true,'prefix' => 'organizations']
                              );
                       ?>
                       
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
