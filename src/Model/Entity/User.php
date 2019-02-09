<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

//追記
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $role
 *
 * @property \App\Model\Entity\Bidinfo[] $bidinfo
 * @property \App\Model\Entity\Biditem[] $biditems
 * @property \App\Model\Entity\Bidmessage[] $bidmessages
 * @property \App\Model\Entity\Bidrequest[] $bidrequests
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    //利用する項目の指定(アクセス可能かどうか)
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'role' => true,
        'bidinfo' => true,
        'biditems' => true,
        'bidmessages' => true,
        'bidrequests' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    //非表示の項目
    protected $_hidden = [
        'password'
    ];

    //パスワードを暗号化する為の仕組み
    protected function _setPassword($password){
        return(new DefaultPasswordHasher)->hash($password);
    }
}
