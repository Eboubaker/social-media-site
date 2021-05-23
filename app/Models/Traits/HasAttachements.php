<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

interface HasAttachements
{
    public function deleteAttachements();
    public function getAttachementsAttribute();
}