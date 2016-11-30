<?php
namespace App\Controller\Admin;

/**
 * Settings Controller
 *
 * @property \App\Controller\Component\SettingsComponent $Settings
 */
class SettingsController extends AppController
{
    public function update() {
        if($this->request->is('post')) {
            $this->loadComponent('Settings');

            foreach($this->request->data as $key => $value) {
                $this->Settings->write($key, $value);
            }
        }

        $this->redirect($this->request->referer());
    }
}
