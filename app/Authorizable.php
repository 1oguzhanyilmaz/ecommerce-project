<?php


namespace App;


use Illuminate\Support\Arr;

trait Authorizable
{
    private $abilities = [
        'index' => 'view',
        'edit' => 'edit',
        'show' => 'view',
        'update' => 'edit',
        'create' => 'add',
        'store' => 'add',
        'destroy' => 'delete',

        'options' => 'add',
        'store_option' => 'add',
        'edit_option' => 'edit',
        'update_option' => 'edit',
        'remove_option' => 'edit',
    ];

    public function callAction($method, $parameters){
        if( $ability = $this->getAbility($method) ) {
            $this->authorize($ability);
        }

        return parent::callAction($method, $parameters);
    }

    public function getAbility($method){
        $routeName = explode('.', \Request::route()->getName());
        $action = Arr::get($this->getAbilities(), $method);

        return $action ? $action . '_' . $routeName[0] : null;
    }

    private function getAbilities(){
        return $this->abilities;
    }

    public function setAbilities($abilities){
        $this->abilities = $abilities;
    }
}
