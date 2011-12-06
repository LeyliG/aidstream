<?php

class User_Form_User_Forgotpassword extends App_Form
{

    public function init()
    {

        $this->setName('Forgot Password');
        $this->setMethod('post');
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')->setRequired();
        $this->addElement($email);

        $login = new Zend_Form_Element_Submit('reset_password');
        $login->setLabel('Reset Password');

        
        $this->addDisplayGroup(
                               array('email'),
                               'forgot-password',
                               array('legend'=> 'Reset Password')
                            );
        $forgot = $this->getDisplayGroup('forgot-password');
        $forgot->addDecorators(array(
                array(
                      array( 'wrapperAll' => 'HtmlTag' ),
                      array( 'tag' => 'div','class'=>'default-activity-list'))
            ));
        
        $this->addElement($login);
    }

}