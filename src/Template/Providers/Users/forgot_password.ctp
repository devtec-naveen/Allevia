<div class="fp-page">
    <div class="fp-box">
        <div class="logo">
            <a href="<?php echo ADMIN_SITE_URL ?>">
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
                  <?= $this->Form->create(null,['id'=>'forgot_password']) ?>
                    <div class="msg">
                        Enter your email address that you used to register. We'll send you an email with your username and a
                        link to reset your password.
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">
                                email
                            </i>
                        </span>
                        <div class="form-line">
                            <?php echo $this->Form->control('email', ['type' => 'email','data-msg-required'=>'Enter Registered Email','title'=>'Enter E-mail','label' => false,'class' => 'form-control','required' => true]); ?>
                            </input>
                        </div>
                    </div>
                    <button class="btn btn-block btn-lg bg-blue waves-effect" type="submit">
                        RESET MY PASSWORD
                    </button>
                    <div class="row m-t-20 m-b--5 align-center">
                         <?php  echo $this->Html->link(
                                  'Sign In',
                                  ['prefix' => 'providers','controller' => 'Users', 'action' => 'login']
                              );
                       ?>
                    </div>
                   <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
