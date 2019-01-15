<?php
namespace Drupal\test_form\Form;


use Drupal\Core\Database\Database;
//if need to interact with the DB, reference the DB object

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File; //need to define this in order for reference the File Functions etc




/**
* Implements a simple form.
*/
class ImageUploaderForm extends FormBase {
	
  //*FormBase is an abstract class, hence, you need to implement its abstract methods - getFormId, buildForm, validateForm, submitForm
  
public function getFormId() { 
  return 'imageUploader'; //an unique id of your form
  
  }
   
public function buildForm(array $form, FormStateInterface $form_state) {
	   
 
  
  
    $form['#attributes']['enctype'] = 'multipart/form-data';
    $form['uploadimage'] = array(
      '#type' => 'managed_file',
      '#title' => 'Your Photo',
      '#upload_location' => 'public://',
      '#default_value' => '',
      '#upload_validators' => [
       'file_validate_extensions' => ['jpg png'],
      ]
    );
   
   $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
   
   return $form; 
   }
   
   public function validateForm(array &$form, FormStateInterface $form_state) { 
	   
   } 
   
  
   
   
   public function submitForm(array &$form, FormStateInterface $form_state) {


    $image = $form_state->getValue('uploadimage');
    $file = File::load( $image[0] );
     if (!empty($file)) {
    $file->setPermanent(); //set the file status to permanent (true) or else it will eventually be be remove
    // Save the file in the file_managed table in your database.
    $file->save();
    $file_usage = \Drupal::service('file.usage'); 
    //$file_usage->add($file, 'welcome', 'welcome', \Drupal::currentUser()->id());
  }
  
  drupal_set_message('The Record have been saved');
	
   
     }
}
