<?php
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class LoginController extends Controller
{
    public function IndexAction()
    {
        // redirected to index
    }
    public function loginAction()
    {
        $usr = $this->mongo->users->findOne(['email' => $_POST['email'], 'password' => $_POST['password']]);

        if (isset($_POST['remember']) && $usr->name != '') {
            $this->cookies->set('email', $_POST['email']);
            $this->cookies->set('password', $_POST['password']);
            $this->session->loggedIn = true;
            $this->response->redirect('/login/dashboard');
        } else {
            $response = new Response();
            $response->setStatusCode(403, 'User Not Found');
            $response->setContent('Authentication Failed!');
            $response->send();
            die;
        }
    }
    public function DashboardAction()
    {
        // if it's not marked as loggedIn in session, redirect to login
        if (!$this->session->loggedIn) {
            $this->response->redirect('login/index');
        }
    }
    public function LogoutAction()
    {
        $this->session->destroy();
        $this->response->redirect('login/index');
        $this->session->loggedIn = false;
    }
}