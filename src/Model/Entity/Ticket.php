<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ticket Entity
 *
 * @property int $id
 * @property int $barcode
 * @property string $type
 * @property bool $paid
 * @property string $state
 * @property int $user_id
 * @property string $user_code
 * @property string $firstname
 * @property string $lastname
 * @property string $gender
 * @property \Cake\I18n\Time $birthdate
 * @property string $email
 * @property string $address
 * @property int $zip_code
 * @property string $city
 * @property float $latitude
 * @property float $longitude
 * @property \Cake\I18n\Time $created
 * @property User $user
 */
class Ticket extends Entity
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
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
