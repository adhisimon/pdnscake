<?php
/**
 * view of users/login
 */
echo $session->flash('auth');
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
        echo $form->end(
            __('Login', true),
            array(
                'tabindex' => 3,
            )
        );
    ?>
</fieldset>
