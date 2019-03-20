<?php
namespace ViralsBackpack\BackPackImageUpload\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use ViralsBackpack\BackPackImageUpload\Models\Image;
use Illuminate\Support\Facades\Storage;

trait HasImages
{

    /**
     * A model may have multiple images.
     */

    public function images()
    {
        return $this->morphToMany(Image::class, 'model','model_has_images','model_id','image_id');
    }

    /**
     * created image
     * $params: string or array
     *
     * return: all images for record
     */
    public function createImage($params=[])
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

    /**
     * updated image
     * $params: string or array
     *
     * return: all images for record
     */

    public function updateImage($params =[])
    {
        if($params)
        {
            $this->removeURLImage();
            $image = $this->createImage($params);

            return $image;
        }

        return null;
    }

    /**
     * deleted image
     * $params: string or array
     *
     * return: true or false
     */
    public function deleteImages($url=[])
    {
        if(!empty($url))
        {
            $convertURL = [];
            if(is_array($url))
            {
                foreach($url as $link)
                {
                    array_push($url,'public/'.$link);
                }
            }
            else
            {
                $convertURL = 'public/'.$url;

            }
            Storage::delete($convertURL);

            return true;
        }

        return false;
    }

    /**
     *
     * remove image and relationship image
     *
     */
    private function removeURLImage()
    {
        $images = $this->images();
        if($images->get()->isNotEmpty()){
            Image::whereIn('id', $images->pluck('id'))->delete();
            $images->detach();

            return $this->load('images');

        }
        return null;
    }

    /**
     *
     * add image url and add relationship image
     *
     **/
    public function syncImages($images = [])
    {
        if(!empty($images))
        {
            return $this->images()->sync($images);
        }

        return false;
    }

}
