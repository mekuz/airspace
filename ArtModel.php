<?php

namespace App\Models;

use CodeIgniter\Model;



class ArtModel extends Model

{

	protected $table = 'artifact';

	protected $primaryKey = 'id';

	protected $returnType = 'array';

	protected $allowedFields = [
		'id',
		'name',	
		'short_description',	
		'description',
		'img',
		'hits',
		'video',	
		'audio',	
		'artist',
		'sign',	
		'location',
		'date_created',
		'date_updated'
		];



	protected $useTimestamps = true;

	protected $createdField = 'date_created';
	
	protected $updatedField = 'date_updated';

	protected $dateFormat = 'int';


}//end class