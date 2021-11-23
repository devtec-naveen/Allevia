<div class="login-box">
    <div class="logo">
        <a href="javascript:void(0);">
            Allevia
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
                <!-- <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">
                            person
                        </i>
                    </span>
                    <div class="form-line">
                      
                        </input>
                    </div>
                </div> -->

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">
                            person
                        </i>
                    </span>
                    <div class="form-line focused">
                       <div class="input email required" aria-required="true"><input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off" required="required" id="email" value="" aria-required="true"></div>                        
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">
                            lock
                        </i>
                    </span>
                    <div class="form-line">
                        <?= $this->Form->control('password',['class'=>'form-control','autofocus'=>'','placeholder'=>'Password','label'=>false,'autocomplete'=>'off','required'=>true]) ?>  
                        </input>
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
                                  ['controller' => 'Users', 'action' => 'forgotPassword', '_full' => true]
                              );
                       ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
