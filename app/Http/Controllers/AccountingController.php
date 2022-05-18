<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class AccountingController extends Controller
{

    //
    public function index()
    {
        return view('accounting.mergeImage');
    }


    public function merge_image(Request $_request)
    {

        ini_set("memory_limit", -1);
        /*...images name in array...*/
        if ($_request->has("images") && !empty($_request->images)) {
            $imageNameString = $_request->images[0];
            /*...if multiple images...*/
            if (count($_request->images) > 1) {
                $allWidth        = $allHeight        = [];
                $canvasWidth     = $canvasHeight     = 0;
                $imageNameString = Str::random(30) . ".png";
                /*...get all images height & width for make/merger new image...*/
                foreach ($_request->images as $imagesKey => $imagesName) {
                    $allImg      = Image::make($imagesName->path());
                    $allWidth[]  = $allImg->width();
                    $imgHeight   = $allImg->height();
                    $allHeight[] = $imgHeight;
                    $canvasHeight += $imgHeight;
                }

                /*...max width...*/
                $canvasWidth = max($allWidth);
                /*...make empty canvas with max height width...*/
                $img = Image::canvas($canvasWidth, $canvasHeight);
                /*...save...*/
                $img->save(storage_path("app/public/images/" . $imageNameString));

                /*...append images to canvas...*/
                foreach ($_request->images as $imagesKey => $imagesName) {
                    /*...get offset for append image at bottom of canvas...*/
                    $totalWidth = $totalHeight = 0;
                    for ($i = 0; $i < $imagesKey; $i++) {
                        $totalWidth += $allWidth[$i];
                        $totalHeight += $allHeight[$i];
                    }
                    /*...get canvas...*/
                    $img = Image::make(storage_path("app/public/images/" . $imageNameString));
                    /*...append image at top with offset...*/
                    $appendImg = Image::make($imagesName->path());
                    $img->insert($appendImg, "top", 0, $totalHeight);

                    /*...save...*/
                    $img->save(storage_path("app/public/images/" . $imageNameString));
                }
            }
        }
        $file = public_path('storage/images/' . $imageNameString);
        $headers = ['Content-Type: image/png'];
        $newName = 'image-' . time() . '.png';
        return response()->download($file, $newName, $headers);
    }
}
