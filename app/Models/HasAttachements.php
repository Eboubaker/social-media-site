<?php
namespace App\Models;

interface HasAttachements
{
    public function deleteAttachements();
    public function getAttachementsAttribute();
}