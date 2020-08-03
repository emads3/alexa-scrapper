<?php


namespace Core;


use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
	protected $fillable = ['domain', 'current_rank'];

	// some scopes here...
	public function scopeNewest()
	{
		// query here...
	}
}
