<?php
	class Form_Admin_EditOrganisationGroup extends App_Form
	{
		public function init() {
			$this->setName('create_organisation_group');
			$form = array();

			$userId = $this->getAttrib('user_id');
			$db = Zend_Db_Table_Abstract::getDefaultAdapter();
			$clause = $db->quoteInto('user_id != ?', $userId);
			
			$form['group_name'] = new Zend_Form_Element_Text('group_name');
			$form['group_name']->setLabel('Group Name')
				->setRequired()
				->setAttrib('class', 'form-text');

			$form['group_organisations'] = new Zend_Form_Element_Select('group_organisations');
	        $form['group_organisations']->setLabel('Organisations')
	        	->setRequired()
	            ->setRegisterInArrayValidator(false)
	            ->setAttrib('multiple', 'true')
	            ->setAttrib('class', 'form-select');

	        $form['first_name'] = new Zend_Form_Element_Text('first_name');
	        $form['first_name']->setLabel('First Name')
	        	->setAttrib('class', 'form-text')
	        	->setRequired();

	        $form['middle_name'] = new Zend_Form_Element_Text('middle_name');
	        $form['middle_name']->setLabel('Middle Name')
	        	->setAttrib('class', 'form-text');

	        $form['last_name'] = new Zend_Form_Element_Text('last_name');
	        $form['last_name']->setLabel('Last Name')
	        	->setAttrib('class', 'form-text')
	        	->setRequired();

	        $form['group_identifier'] = new Zend_Form_Element_Text('group_identifier');
	        $form['group_identifier']->setLabel('Group Identifier')
	        	->setAttrib('class', 'form-text')
	        	->setDescription("Your group identifier will be used as a prefix for your organisation group. 
	        					  We recommend that you use a short abbreviation that uniquely identifies 
	        					  your organisation group. If your group identifier is 'abc' the username 
	        					  for the group created with this registration will be 'abc_group'.")
	        	->setRequired();

	        $form['user_name'] = new Zend_Form_Element_Text('user_name');
	        $form['user_name']->setLabel('User Name')
			    ->setAttrib('class', 'form-text')
			    ->setAttrib('readonly','true')
			    ->setDescription("User Name is a combination of Group Identifier and '_group'.
                             You may only change Group Identifier portion of the username.")
                ->addValidator('Db_NoRecordExists', false, 
    				array('table' => 'user', 'field' => 'user_name', 'exclude' => $clause,
    					'messages' => array(
    		        		Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND => 'Username already in use. Please change your Group Identifier.'
    		        	)))
			    ->setRequired();

	        $form['email'] = new Zend_Form_Element_Text('email');
	                $form['email']->setLabel('Email')
	                ->addValidator('emailAddress', false)
	                ->addFilter('stringTrim')
	                ->setAttrib('class', 'form-text')
	                ->addValidator('Db_NoRecordExists', false, 
	                	array('table' => 'user', 'field' => 'email', 'exclude' => $clause,
	                	'messages' => array(
	                			Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND => 'Email address already in use.'
	                		)))
	                ->setRequired();

            $account_model = new User_Model_DbTable_Account();
            $organisations = $account_model->getAllOrganisationNameWithId();

	        foreach ($organisations as $organisation) {
	        	$form['group_organisations']->addMultiOption($organisation['id'], $organisation['name']);
	        }
	  
	        $update_group = new Zend_Form_Element_Submit('update_group');
        	$update_group->setLabel('Update Group')->setAttrib('id', 'Submit');

	       	$this->addElements($form);
	        // add clearfix div for all form items
	        foreach($form as $element){
	            $element->addDecorators(
                    array(
                    	array(
                            array('wrapperAll' => 'HtmlTag') ,
                            array(
                            	'tag' => 'div' ,
                            	'class' => 'clearfix form-item'
                            )
                        )
                    )
                );
	        }

			$this->addDisplayGroup(
                array('user_info', 'group_name', 'group_organisations', 'group_identifier'),
                'create_organisation_group',
                array('legend'=>'New Organisation Group')
            );

			$this->addDisplayGroup(
				array('first_name', 'middle_name', 'last_name', 'user_name', 'email'),
				'group_admin_information',
				array('legend'=>'Group Admin Information')
			);

			$group = $this->getDisplayGroups();
			foreach($this->getDisplayGroups() as $group){
				$group->setDecorators(array(
				    'FormElements',
				    'Fieldset',
				    array(
				        array( 'wrapperAll' => 'HtmlTag' ),
				        array( 'tag' => 'div','class'=>'default-activity-list')
				    )
				));
			}

			$this->addElement($update_group);
			$this->setMethod('post');

		}
	}
?>