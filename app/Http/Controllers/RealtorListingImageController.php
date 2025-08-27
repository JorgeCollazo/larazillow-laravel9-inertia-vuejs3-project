<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RealtorListingImageController extends Controller
{
    public function create(Listing $listing)
    {
        $listing->load('images'); // Load the images relationship to pass to the view, this become a new attribute called images

        return inertia(
            'Realtor/ListingImage/Create',
            [
                'listing' => $listing
            ]
        );
    }

    public function store(Listing $listing, Request $request)
    {
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');      // This will store the image in the storage/app/public/images folder, and return the path

                $listing->images()->create([          // This will create a new image record in the images table, using the relationship defined in the Listing model, you could also use $listing->images()->save(new ListingImage(['path' => $path]));
                    'filename' => $path
                ]);
            }
        }
        return redirect()->back()->with('success', 'Images uploaded successfully!');
    }

    public function destroy($listing, ListingImage $image)
    {
        Storage::disk('public')->delete($image->filename);      // This will delete the image from the storage/app/public/images folder
        $image->delete();    // This will delete the image record from the images table
        return redirect()->back()->with('success', 'Image deleted successfully!');
    }
}
