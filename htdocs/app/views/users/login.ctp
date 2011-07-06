<?php
/**
 * view of users/login
 */


# display authentication message
    $flash_auth = $this->Session->flash('auth');
    if (!preg_match("/$auth_error_message/", $flash_auth)) {
        echo $flash_auth;
    }
?>

<fieldset>
    <?php echo $form->create('User'); ?>
    <?php
        echo $form->input(
            'User.username',
            array(
                'tabindex' => 1,
            )
        );
        echo $form->input(
            'User.password',
            array(
                'tabindex' => 2,
            )
        );
        echo $form->submit(
            __('Login', true),
            array(
                'tabindex' => 3,
            )
        );
        echo $form->end();
    ?>
</fieldset>
