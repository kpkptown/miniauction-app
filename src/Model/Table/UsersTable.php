<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\BidinfoTable|\Cake\ORM\Association\HasMany $Bidinfo
 * @property \App\Model\Table\BiditemsTable|\Cake\ORM\Association\HasMany $Biditems
 * @property \App\Model\Table\BidmessagesTable|\Cake\ORM\Association\HasMany $Bidmessages
 * @property \App\Model\Table\BidrequestsTable|\Cake\ORM\Association\HasMany $Bidrequests
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    //初期化メソッド、アソシエーションの設定
    //hasMany(ログインしたユーザー)との関連づけ
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->hasMany('Bidinfo', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Biditems', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Bidmessages', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Bidrequests', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    //バリデーションの設定
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 100)
            ->requirePresence('username', 'create')
            // ->allowEmptyString('username', false);
            ->notEmpty('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 100)
            ->requirePresence('password', 'create')
            // ->allowEmptyString('password', false);
            ->notEmpty('password');

        $validator
            ->scalar('role')
            ->maxLength('role', 20)
            ->requirePresence('role', 'create')
            // ->allowEmptyString('role', false);
            ->notEmpty('role');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    //テーブルに関する特別なルール設定がされている
    //Uniqueは重複する値がないということ　usernameに設定されているので、同じ名前のユーザーが登録できないようにしている
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));

        return $rules;
    }
}
