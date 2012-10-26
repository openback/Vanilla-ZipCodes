<?php if (!defined('APPLICATION')) exit();

// Define the plugin:
$PluginInfo['ZipCodes'] = array(
   'Description' => 'Adds required Zip Code field for users and allows them to be displayed',
   'Version' => '0.1',
   'Author' => "Timothy Caraballo",
   'AuthorEmail' => 'openback@pixelpod.net',
   'AuthorUrl' => 'http://pixelpod.net'
);

class ZipCodes extends Gdn_Plugin {
    public function Setup() {
		$this->Structure();
    }

	public function Structure() {
		Gdn::Structure()
			->Table('User')
			->Column('ZipCode', 'char(5)', FALSE)
			->Set();
    }

	public function EntryController_Render_Before($Sender,$Args) {
		if(strcasecmp($Sender->RequestMethod,'register')==0) {
			if(strcasecmp($Sender->View,'registerthanks')!=0 && strcasecmp($Sender->View,'registerclosed')!=0) {
				$RegistrationMethod = Gdn::Config('Garden.Registration.Method');
				$Sender->View = $this->GetView( 'register'.strtolower($RegistrationMethod).'.php');
			}
		}
    }

	/**
	 * Display custom fields on Profile.
	 */
	public function UserInfoModule_OnBasicInfo_Handler($Sender) {
		echo Wrap(T('Zip Code'), 'dt');
		echo Wrap($Sender->User->ZipCode, 'dd');
	}

	 /**
	  * Add fields to edit profile form.
	  */
	public function ProfileController_EditMyAccountAfter_Handler($Sender) {
		?>
		<li>
			<?php
			echo $Sender->Form->Label('Zip Code', 'ZipCode');

			echo $Sender->Form->TextBox('ZipCode');
			?>
		</li>
		<?php
	}

	/**
	 * Display custom fields on Edit User form.
	 */
	public function UserController_AfterFormInputs_Handler($Sender) {
		?>
		<h3><?php echo T('Zip Code Options'); ?></h3>
		<ul>
			<li>
				<?php
				echo $Sender->Form->Label('Zip Code', 'ZipCode');

				echo $Sender->Form->TextBox('ZipCode');
				?>
			</li>
		</ul>
		<?php
	}

	/**
	 * Display custom fields on Add User form.
	 */
	public function UserController_Render_Before($Sender) {
		if(strcasecmp($Sender->RequestMethod,'add')==0) {
			$Sender->View = $this->GetView('add.php');
		}
	}

	/**
	 * Check for a valid zip code on edit
	 */
	public function UserModel_BeforeSaveValidation_Handler($Sender) {
		$zip = $Sender->EventArguments['FormPostValues']['ZipCode'];
		if (preg_match('/\d{5}/', $zip) == 0) {
			$Sender->Validation->AddValidationResult('ZipCode', T('Please enter a valid zip code.'));
		}
	}

	/**
	 * Check for a valid zip code on register
	 */
	public function UserModel_BeforeRegister_Handler($Sender, $Args) {
		$zip = $Sender->EventArguments['User']['ZipCode'];
		if (preg_match('/\d{5}/', $zip) == 0) {
			$Sender->Validation->AddValidationResult('ZipCode', T('Please enter a valid zip code.'));
		}
	}

	public function OnDisable() {
		Gdn::Structure()
		->Table('User')
		->Column('ZipCode', 'char(5)', NULL)
		->Set();
	}
}
?>
