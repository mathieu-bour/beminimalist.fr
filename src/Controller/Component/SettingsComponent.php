<?php
namespace App\Controller\Component;

use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Class SettingsComponent
 * @package App\Controller\Component
 *
 * @property AppController $Controller
 * @property \App\Model\Table\SettingsTable $SettingsTable
 */
class SettingsComponent extends Component
{
    public $cached;

    public function initialize(array $config)
    {
        $this->Controller = $this->_registry->getController();
        $this->SettingsTable = TableRegistry::get('Settings');

        $this->reload();

        parent::initialize($config);
    }

    public function reload()
    {
        $this->cached = $this->SettingsTable->find('list', [
            'keyField' => 'key',
            'valueField' => 'value'
        ])->toArray();

        foreach($this->cached as $key => $v) {
            $this->cached[$key] = unserialize($v);
        }
    }

    public function read($key)
    {
        return $this->readOrFail($key, null);
    }

    public function readOrFail($key, $failValue)
    {
        return !empty($this->cached[$key]) ? $this->cached[$key] : $failValue;
    }

    public function write($key, $value)
    {
        $setting = $this->SettingsTable->find('all')->where(['key' => $key])->first();

        if (empty($setting)) {
            $setting = $this->SettingsTable->newEntity(['key' => $key, 'value' => serialize($value)]);
        } else {
            $setting->value = serialize($value);
        }
        $this->SettingsTable->save($setting);

        $this->reload();
    }
}