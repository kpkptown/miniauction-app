<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;

class AuctionBaseController extends AppController{
    //初期化処理
    public function initialize(){
        parent::initialize();
        //必要なコンポーネントのロード
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth',[
            //認証の設定（コントローラーの指定）
            'authorize' => ['Controller'],
            //認証で使うフォームの内容などを指定
            'authenticate' => [
                'Form' => [
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
                'action' => 'logout'
            ],
            //エラーメッセージ
            'authError' => 'ログインして下さい。',
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
        //セッションを破棄
        $this->request->session()->destroy();
        return $this->redirect($this->Auth->logout());
    }

    //認証しないページの設定
    //beforeFilterメソッドは、フィルター処理(ログイン処理を行う前に実行されるもの)を行う
    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
        $this->Auth->allow([]);
    }

    //認証時のロールの処理
    public function isAuthorized($user = null){
        //管理者はtrue
        if($user['role'] === 'admin'){
            return true;
        }
        //一般ユーザーはAuctionControllerのみtrue、他はfalse
        if($user['role'] === 'user'){
            if($this->name == 'Auction'){
                return true;
            }else{
                return false;
            }
        }
        //その他は全てfalse
        return false;
    }
}