<?php

namespace App;

use Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model
{
	protected $table = 'flyer_photos';

	protected $fillable = ['path', 'name', 'thumbnail_path'];

	protected $baseDir = 'flyer/photos';

    public function flyer() 
    {
    	return $this->belongsTo('App\Flyer');
    }

    /**
     * Build a new photo instance from a file upload.
     * 
     * @param  string $name
     * @return self     
     */
    public static function named($name) 
    {
        return (new static)->saveAs($name);
    }

    public function saveAs($name)
    {
        $this->name = sprintf("%s-%s", time(), $name);
        $this->path = sprintf("%s/%s", $this->baseDir, $this->name);
        $this->thumbnail_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);

        return $this;
    }

    public function move(UploadedFile $file)
    {
        $file->move($this->baseDir, $this->name);

        $this->makeThumbnail();

        return $this;
    }

    public function makeThumbnail()
    {
        Image::make($this->path)
            ->fit(200)
            ->save($this->thumbnail_path);
    }

}
