<?php if (!defined('APPLICATION')) exit(); ?>
<h1><?php echo T("Apply for Membership") ?></h1>
<div class="Box">
   <?php
   $TermsOfServiceUrl = Gdn::Config('Garden.TermsOfService', '#');
   $TermsOfServiceText = sprintf(T('I agree to the <a id="TermsOfService" class="Popup" target="terms" href="%s">terms of service</a>'), Url($TermsOfServiceUrl));

   // Make sure to force this form to post to the correct place in case the view is
   // rendered within another view (ie. /dashboard/entry/index/):
   echo $this->Form->Open(array('Action' => Url('/entry/register'), 'id' => 'Form_User_Register'));
   echo $this->Form->Errors();
   ?>
   <ul>
      <li>
         <?php
            echo $this->Form->Label('Invitation Code', 'InvitationCode');
            echo $this->Form->TextBox('InvitationCode', array('value' => $this->InvitationCode));
         ?>
      </li>
      <li>
         <?php
            echo $this->Form->Label('Username', 'Name');
            echo $this->Form->TextBox('Name');
            echo '<span id="NameUnavailable" class="Incorrect" style="display: none;">'.T('Name Unavailable').'</span>';
         ?>
      </li>
      <li>
         <?php
            echo $this->Form->Label('Password', 'Password');
            echo $this->Form->Input('Password', 'password');
         ?>
      </li>
      <li>
         <?php
            echo $this->Form->Label('Confirm Password', 'PasswordMatch');
            echo $this->Form->Input('PasswordMatch', 'password');
            echo '<span id="PasswordsDontMatch" class="Incorrect" style="display: none;">'.T("Passwords don't match").'</span>';
         ?>
      </li>
      <li class="Gender">
         <?php
            echo $this->Form->Label('Gender', 'Gender');
            echo $this->Form->RadioList('Gender', $this->GenderOptions, array('default' => 'm'))
         ?>
      </li>
	  <li>
         <?php
			echo $this->Form->Label('Zip Code', 'ZipCode');
            echo $this->Form->TextBox('ZipCode');
         ?>
      </li>
      <li>
         <?php
            echo $this->Form->CheckBox('TermsOfService', $TermsOfServiceText, array('value' => '1'));
            echo $this->Form->CheckBox('RememberMe', T('Remember me on this computer'), array('value' => '1'));
         ?>
      </li>
      <li class="Buttons">
         <?php echo $this->Form->Button('Sign Up'); ?>
      </li>
   </ul>
   <?php echo $this->Form->Close(); ?>
</div>
