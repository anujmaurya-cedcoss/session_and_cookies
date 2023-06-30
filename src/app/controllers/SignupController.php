<?php
use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function IndexAction()
    {
        // nothing here
    }

    public function registerAction()
    {
        // creating a new user, with name and email obtained by post method
        if ($_POST['name'] != '' && $_POST['email'] != '' && $_POST['password'] != '') {
            $success = $this->mongo->users->insertOne($_POST);
        }
        // if the user details is saved, then return success
        $this->session->set('user', $_POST['email']);
        $this->view->success = $success;
        if ($success) {
            $this->view->message = "Register succesfully";
        } else {
            $this->view->message = "There was some error<br> <a href = '/'>Go Home</a>";
        }
    }
}