<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class VWVisitor extends Model {
	
	protected $table = 'vw_visitors';
	protected $primaryKey = 'vis_id';

	public function regions(){
		return $this->belongsTo(Region::class, 'region_id');
	}

}
