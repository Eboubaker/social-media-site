<?php
namespace App\DataBase\Eloquent;

use Closure;

trait HasAfterSaveEvents
{
    protected $afterSaveCallbacks = [];
    protected $savedModel = null;

    /**
     * Register custom event that will be triggered after save is called
     *
     * @param Closure $callback
     * @param array $params
     * @return $this
     */
    public function afterSave(Closure $callback)
    {
        $this->afterSaveCallbacks[] = $callback;
        return $this;
    }

    protected function callAfterSaveEvents()
    {
        foreach($this->afterSaveCallbacks as $callback)
        {
            $callback($this);
        }
    }

    public function getSavedModel()
    {
        return $this->savedModel;
    }
}