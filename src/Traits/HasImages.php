<?php
namespace ViralsBackpack\BackPackImageUpload\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use ViralsBackpack\BackPackImageUpload\Models\Image;

trait HasImages
{

    private $ImageClass;


    public function getImageClass()
    {
        if (! isset($this->ImageClass)) {
            $this->ImageClass = new Image();
        }

        return $this->ImageClass;
    }

    /**
     * A model may have multiple images.
     */

    public function images()
    {
        return $this->morphToMany(Image::class, 'model','model_has_images','model_id','image_id');
    }

    public function createImage($params)
    {
        if(!empty($params))
        {
            $imageArr = [];
            if(!is_array($params))
            {
                $image = $this->images()->create(['url' => $params]);
                return $image;
            }
            foreach($params as $param)
            {
                $image = $this->images()->create(['url' => $param]);
                array_push($imageArr,$image->id);
            }

            $this->syncImages($imageArr);
        }

        return $this->images()->get();
    }

    public function updateImage($params)
    {
        $this->removeImage();

        $image = $this->createImage($params);

        return $image;
    }

    public function deleteImage()
    {
        $this->removeImage();
    }

    /**
     * Revoke the given role from the model.
     *
     * @param string|\Spatie\Permission\Contracts\Role $role
     */
    public function removeImage()
    {
        $image = $this->images();
        Image::whereIn('id', $image->pluck('id'))->delete();
        $image->detach();

        return $this->load('images');
    }

    /**
     * Remove all current roles and set the given ones.
     *
     * @param array|\Spatie\Permission\Contracts\Role|string ...$roles
     *
     * @return $this
     */
    public function syncImages($images)
    {
        return $this->images()->sync($images);
    }
}
