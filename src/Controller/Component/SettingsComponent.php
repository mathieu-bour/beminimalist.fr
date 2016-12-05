<?php
namespace App\Controller\Component;

use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Class SettingsComponent
 * Used to read/write settings
 *
 * @author Mathieu Bour
 *
 * @package App\Controller\Component
 *
 * @property array $cached the current cached settings
 * @property AppController $Controller
 * @property \App\Model\Table\SettingsTable $SettingsTable
 */
class SettingsComponent extends Component
{
    public function initialize(array $config)
    {
        $config = array_merge_recursive($config, [
            'table' => 'Settings'
        ]);
        //$this->Controller = $this->_registry->getController(); // Not needed
        $this->SettingsTable = TableRegistry::get($config['table']);

        $this->reload(); // Reload settings

        parent::initialize($config);
    }

    /**
     * Reload the cached settings configuration
     */
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

    /**
     * Read a entry in the cached configuration
     * @param string $key the settings key
     * @param mixed $failValue the value to return in case of fail (entry does not exist)
     * @return mixed|null
     */
    public function read($key, $failValue = null)
    {
        return !empty($this->cached[$key]) ? $this->cached[$key] : $failValue;
    }

    /**
     * Write a entry in the configuration
     * @param string $key the settings key
     * @param mixed $value the value to write; serialized before saving
     * @return bool the save result
     */
    public function write($key, $value): bool
    {
        $setting = $this->SettingsTable->find('all')->where(['key' => $key])->first();

        if (empty($setting)) {
            $setting = $this->SettingsTable->newEntity(['key' => $key, 'value' => serialize($value)]);
        } else {
            $setting->value = serialize($value);
        }

        $result = $this->SettingsTable->save($setting);

        $this->reload(); // Reload settings

        return (bool)$result;
    }
}