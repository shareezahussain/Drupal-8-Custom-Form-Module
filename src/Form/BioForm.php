<?php
namespace Drupal\test_form\Form;


use Drupal\Core\Database\Database;
//if need to interact with the DB, reference the DB object

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Implements a simple form.
*/
class BioForm extends FormBase {
	
  //*FormBase is an abstract class, hence, you need to implement its abstract methods - getFormId, buildForm, validateForm, submitForm
  
public function getFormId() { 
  return 'BioForm'; //an unique id of your form
  
  }
   
public function buildForm(array $form, FormStateInterface $form_state) {
	   
 
  
  $form['name'] = array(
   '#type' => 'textfield', 
   '#title'=> 'Name', 
   '#required'=> true,
   
   ); 
   
   $form['address'] = array(
   '#type' => 'textfield', 
   '#title'=> 'Where I Live', 
   '#required'=> true,
   ); 
   
   $form['dob'] = array(
   '#type' => 'date', 
   '#title'=> 'My Date of Birth', 
   '#required'=> true,
   
   ); 
   
   $form['phone'] = array(
   '#type' => 'number',
   '#title'=> 'Telephone #', 
   '#maxlength'=> 10,
   //'#default_value' => 0,
   ); 
   
   $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
   
   return $form; 
   }
   
   public function validateForm(array &$form, FormStateInterface $form_state) { 
  
   $values = $form_state->getValues();
   
   //if empty field(s), flag it. However, this isn't neede because when define #require => true in the buildForm method, this error will still flag 
   
   if(empty($values['name'])){

   $form_state->setErrorByName('name',t('Please enter your full name'));
	   
   } 
   
   if(empty($values['address'])){

   $form_state->setErrorByName('name',t('Please enter your address'));
	   
   } 
   
   if(empty($values['dob'])){

   $form_state->setErrorByName('name',t('Please enter your birthday'));
	   
   } 
  
   
   
   
/*************************************************************/

  //check for only alphabetical, if not flag it
   if(is_numeric($values['name'])){ 
   $form_state->setErrorByName('name',t('Enter only letters')); 
   }
   
  
  
  
   
   return;
   }
   
   public function submitForm(array &$form, FormStateInterface $form_state) {

   
    $conn = Database::getConnection();
  

    $values = array(
		'name' => $form_state->getValue('name'),
		'address' => $form_state->getValue('address'),
		'dob' => $form_state->getValue('dob'),
		'phone' => $form_state->getValue('phone'),
		);
	
	//allow not required empty field to get inserted in database without showing an error
	if(empty($values['phone'])){ 

	$conn->insert('bio_table')
	
	
		-> fields(array(
			'name' => $values['name'],
			'address' => $values['address'],
			'dob' => $values['dob'],
			'phone' => 0000000000, 
			))
			
		
	
		 
		->execute();
	}
	
	else {
		
		$conn->insert('bio_table')
	
	
		-> fields(array(
			'name' => $values['name'],
			'address' => $values['address'],
			'dob' => $values['dob'],
			'phone' => $values['phone'],
			))
			
		
	
		 
		->execute();
	}
	
	
	
	
	drupal_set_message('The Record have been saved');
	
   
     }
}
