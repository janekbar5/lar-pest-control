<?php

namespace App\Http\Controllers;

use App\Image;
use Intervention\Image\Facades\Image as Foto;
use Illuminate\Http\Request;
///////////
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
//images
use Storage;
use File;



class ImageController extends Controller
{

       
    /**///////////////////////////////////////////////////////////////////////////////////////////////////////
    public function index(Request $request)
    {                
        //dd( $request->all() );
        return Image::                    
                    where('photoable_type', '=', $request->input('photoable_type'))
                    ->where('photoable_id','=', $request->input('photoable_id'))
                    ->get(); 
    }     
    /**///////////////////////////////////////////////////////////////////////////////////////////////////////
    public function destroy($id)
    {
        $gallery_image = Image::find($id);       
        unlink(public_path('images/'.$gallery_image->path));
		unlink(public_path('images/thumb_large-'.$gallery_image->path));
        unlink(public_path('images/thumb_medium-'.$gallery_image->path));   
        unlink(public_path('images/thumb_small-'.$gallery_image->path));
        unlink(public_path('images/thumb_mini-'.$gallery_image->path));    
        $gallery_image->delete();
        return response()->json(['deleted' => true]);
    }

    /**////////////////////////////////////////////////////////////////////////////////////////////////////
    public function destroyAllImages($photoable_type,$photoable_id)
    {
        $images = Image::                    
                      where('photoable_type', '=', $photoable_type)
                    ->where('photoable_id','=', $photoable_id)
                    ->get();
        foreach ($images as $image) {
            unlink(public_path('images/'.$image->path));
            unlink(public_path('images/thumb_large-'.$image->path));
            unlink(public_path('images/thumb_medium-'.$image->path));   
            unlink(public_path('images/thumb_small-'.$image->path));
            unlink(public_path('images/thumb_mini-'.$image->path));  
        }
    }
    public function destroyImagesbyGroup($properties)
    {
      foreach($properties as $prop){
        echo $prop->id.'</br>';
      }
      
    }

    /**////////////////////////////////////////////////////////////////////////////////////////////////////
    public function changeImageOrder(Request $request)
    {
        $images = Image::orderBy('image_order', 'asc')->get();
        $string = Input::get('order');
        array($string);
        $string = trim($string, ".");
        $split = explode(",", $string);
        $count = 1;
        foreach ($split as $value) { //loop over values
            $count ++;
            $image = Image::find($value);
            $image->image_order = $count;
            $image->update();
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////Upload image
    public function post(Request $request)
    {                
        $file = $request->file('file');  
        $model_name = str_replace('\\', '-', $request->input('photoable_type'));        
        $filename = Auth::user()->id.'-'.$request->input('photoable_id').'-'.$model_name.'-'.uniqid().'.'.$file->guessExtension();    
        $file->move('images',$filename);               
        /////////////////////////////////////////////////////////Generate thumb     
        $thumbs_sizes = [
            ['name' => 'thumb_mini','width' => 140,'height' => 80],
            ['name' => 'thumb_small','width' => 240,'height' => 180],
            ['name' => 'thumb_medium','width' => 400,'height' => 300],
            ['name' => 'thumb_large','width' => 800,'height' => 600] 
        ];
        foreach($thumbs_sizes as $size){
            $thumb = Foto::make('images/' . $filename)		
            ->resize($size['width'], $size['height'], function ($constraint) {
                $constraint->aspectRatio();
            })
            ->resizeCanvas($size['width'], $size['height'], 'center', false, array(255, 255, 255, 0))		
            ->save('images/' . $size['name'].'-'.$filename,80);
        }   
        
        $image = Image::create([
                    'photoable_type'=> $request->input('photoable_type'),
                    'photoable_id' => $request->input('photoable_id'),
                    'user_id' => \Auth::user()->id,
                    'path' => $filename,     
                    'image_order' => 1,
        ]);
        return $image;
    }
    

   
}