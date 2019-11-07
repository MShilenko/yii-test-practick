<?php
/*
 * StorageInterface.php
 * 
 * Copyright 2019 Михаил <mihail@mihail-Presario-CQ58-Notebook-PC>
 * 
 */

namespace common\components;

use yii\web\UploadedFile; 

interface StorageInterface
{
	public function saveUploadedFile(UploadedFile $file);
	
	public function getFile(string $filename);
}
