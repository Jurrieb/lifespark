<?php
namespace App\Controller;

use Cake\Network\Email\Email;

class UsersController extends AppController
{

    public function initialize()
    {
        $this->allow = ['register', 'login', 'requestPasswordReset', 'passwordReset', 'verifyEmail'];
        parent::initialize();
        $this->layout = 'website';
    }

    public function register()
    {
       $user = $this->Users->newEntity();
       if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'register']);
            if($this->Users->save($user)){
                $email = new Email('default');
                $email->viewVars([
                        'user' => $user->name,
                        'token' => $user->token
                    ])
                    ->from(['noreply@lifespark.nl' => 'LifeSpark'])
                    ->to($user->email)
                    ->emailFormat('html')
                    ->template('welcome')
                    ->subject('Welkom op LifeSpark.nl');
                $this->Flash->success(__('User has been created. Please check youre email to activate youre account.'));
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error(__('Could not create user'));
            }
       }
       $this->set('user', $user);
    }

    public function login()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'login']);

            if($this->Authentication->checkUser(
                    $this->request->data['email'],
                    $this->request->data['password'])) {
               $this->Flash->success(__('Welcome back'));
               return $this->redirect(['controller' => 'pages', 'action' => 'overview']);
            } else {
                $this->Flash->error(__('Could not login'));
                return $this->redirect(['action' => 'login']);
            }

        }
        $this->set('user', $user);
    }

    public function logout()
    {
        if($this->Authentication->logoutUser()) {
            $this->Flash->success(__('You are logged out'));
        } else {
            $this->Flash->error(__('Could not logout user'));
        }
        return $this->redirect(['action' => 'login']);
    }

    public function requestPasswordReset()
    {
       $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'requestPasswordReset']);
            if(!$user->errors()) {
                $token = $this->Users->savePasswordToken($this->request->data['email']);
                $email = new Email('default');
                $email->viewVars([
                        'token' => $token,
                        'name' => $user->name
                    ])
                    ->from(['noreply@lifespark.nl' => 'LifeSpark'])
                    ->to($user->email)
                    ->emailFormat('html')
                    ->template('password_reset')
                    ->subject('Wachtwoord veranderen op LifeSpark.nl');
                $this->Flash->success(__('An email has been send to {0}', [$this->request->data['email']]));
                return $this->redirect(['action' => 'login']);
            }
        }
        $this->set('user', $user);
    }

    public function passwordReset($token = null)
    {
        $token  = $this->Users->UsersPasswordTokens->find()
                     ->where(['token' => $token])
                     ->first();
        if($token) {
            $user = $this->Users->get($token->user_id);
            unset($user->password);
            unset($user->password_salt);
            if ($this->request->is('put')) {
                $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'passwordReset']);
                if(!$user->errors()) {
                    if($this->Users->save($user)){
                        $this->Flash->success(__('Youre password has been reset'));
                        $this->Users->deletePasswordToken($token->user_id);
                        return $this->redirect(['action' => 'login']);
                    } else {
                        $this->Flash->error(__('Password could not be reset'));
                    }
                }
            }
        } else {
            throw new NotFoundException(_('This page does not exist'));
        }
        $this->set('user', $user);
    }

    public function verifyEmail($token = null)
    {
        $userId = $this->Users->UsersVerifyTokens->find()
                    ->where(['token' => $token])
                    ->extract('user_id')
                    ->first();
        if($this->Users->activateAccount($userId)) {
            $this->Flash->success(__('Youre account has been activated'));
            return $this->redirect(['action' => 'login']);
        }
        throw new NotFoundException(_('This page does not exist'));
    }

    public function profile($slug = null)
    {
        $this->layout = 'default';
        $user = $this->Users->findBySlug($slug);
        $connection = $this->Users->Friends->checkConnection( $this->Authentication->getUser('id') , $user->id);
        $this->set('connection', $connection);
        $this->set('user', $user);
    }

}
