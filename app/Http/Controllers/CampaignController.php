<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Campaigns;
use App\Models\CampaignImages;
use Auth;
use Storage;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    //get all campaigns
      public function index()
    {
        $result = Campaigns::with('campaigns_images')->orderBy('created_at', 'desc')->get();
        return response()->json(['status'=> 200,'error' => false, 'data' => $result]);
    }

    //post campaigns

    public function store(Request $request)
    {
        //get the request from the api
        DB::transaction(function () use ($request) {
            $user =Auth::user();
            $name = $request->name;
            $daily = $request->daily;
            $total = $request->total;
            $from = $request->from;
            $to = $request->to;
            $images = $request->images;
// add campaign 
            $data = Campaigns::create([
                'name' => $name,
                'total_budget' => $total,
                'daily_budget' => $daily,
                'date_from' => $from,
                'date_to' => $to,
                'user_id' => $user->id,
            ]);

            // store each image with related campaign
            foreach($images as $image) {
                 $id =$data->id;

                $imagePath = Storage::disk('uploads')->put($user->id . '/campaigns/' . $data->id, $image);
                  $image_data=[
                    'campaign_image_caption' => $name,
                    'campaign_image_path' => '/uploads/' . $imagePath,
                    'campaigns_id' => $data->id,
                ];
               // print_r($image_data);exit();
                CampaignImages::create($image_data);
            }
        });
        return response()->json(['status'=> 200,'error' => false, 'data' =>'Created']);
    }

   public function update($id, Request $request) {
            $user = Auth::user();
            $name = $request->name;
            $daily = $request->daily;
            $total = $request->total;
            $from = $request->from;
            $to = $request->to;
            $images = $request->images;
        $campaign = Campaigns::find($id);
        $campaign->update([
                'name' => $name,
                'total_budget' => $total,
                'daily_budget' => $daily,
                'date_from' => $from,
                'date_to' => $to,
                'user_id' => $user->id,
            ]);
        return response()->json(['status'=> 200,'error' => false, 'data' =>'Updated']);
    }
    public function destroy($id) {
        $product = Campaigns::find($id);
        $product->delete();
        return response()->json(['status'=> 200,'error' => false, 'data' =>'Deleted']);
    }
}
