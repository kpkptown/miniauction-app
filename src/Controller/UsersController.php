<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize(){
        parent::initialize();
        //各種コンポーネントのロード
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth',[
            //認証の設定（コントローラーの指定）
            'authorize' => ['Controller'],
            //認証で使うフォームの内容などを指定
            'authenticate' => [
                'Form' =>[
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                        ]
                    ]
                ],
                //ログイン時のリダイレクト設定
                'loginRedirect' => [
                    'controller' => 'Users',
                    'action' => 'login'
                ],
                //ログアウト時のリダイレクト設定
                'logoutRedirect' => [
                    'controller' => 'Users',
                    'action' => 'logout',
                ],
                //エラーメッセージ
                'authError' => 'ログインしてください。',
            ]);

    }

    //ログイン処理
    function login(){
        //POST時の処理
        if($this->request->isPost()){
            //ログインしたユーザーのエンティティーの取り出し
            $user = $this->Auth->identify();
            //Authのidentifyをユーザーに設定
            if(!empty($user)){
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('ユーザー名かパスワードが間違っています。');
        }
    }

    //ログアウト処理
    public function logout(){
        //セッションという機能の情報を破棄
        $this->request->session()->destroy();
        return $this->redirect($this->Auth->logout());
    }

    //認証を使わないページの設定
    //beforeFilterメソッドは、フィルター処理(ログイン処理を行う前に実行されるもの)を行う
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    //'login'アクションは認証の必要がなくなる
        $this->Auth->allow(['login']);
    }

    //認証時のロールのチェック
    //isAuthorizedメソッドは、認証後に実行する処理
    public function isAuthorized($user = null){
        //管理者はtrue
        if($user['role'] === 'admin'){
            return true;
        }
        //一般ユーザーはfalse
        if($user['role'] === 'user'){
            return false;
        }
        //他は全てfalse
        return false;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Bidinfo', 'Biditems', 'Bidmessages', 'Bidrequests']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
