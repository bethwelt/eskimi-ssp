<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\TestResponse;

class CampaignTest extends TestCase
{


    use HasFactory;
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
  


     public function testCreateCampaignWithMiddleWare()
    {
        $data = [
                    'name' => "Test Campaign",
                    'daily' => 20,
                    'total' => 1000,
                    'from' => '2021-06-01',
                    'to' => '2022-01-01',
                    'images' =>[
                       'image' => UploadedFile::fake()->image('image.jpg')
                    ],
                     
                ];
    
        $response = $this->json('POST', '/api/campaigns',$data);
        $response->assertStatus(200);
        $response->assertJson(['error' => false,'data'=>'Created']);
    }

    public function testCreateCampaign()
    {
         $data = [
                    'name' => "Test Campaign",
                    'daily' => 20,
                    'total' => 1000,
                    'from' => '2021-06-01',
                    'to' => '2022-01-01',
                    'images' =>[
                        'image' => UploadedFile::fake()->image('image.jpg')
                    ],
                     
                ];
        $response = $this->json('POST', '/api/campaigns',$data);
        $response->assertStatus(200);
        $response->assertJson(['error' => false,'data'=>'Created']);

        
    }


    public function testGettingAllCampaigns()
    {   
        $response = $this->json('GET', '/api/campaigns');
        $response->assertStatus(200);
        $response->assertJson(['error' => false]);
        $response->assertJsonStructure([]);
    }


    public function testUpdateCampaign()
    {
        $response = $this->json('GET', '/api/campaigns');
        $response->assertStatus(200);
        $response->assertJson(['error' => false]);
   
        $campaign = $response->getData()->data[0];

        $id =$campaign->id;


         $data = [
                    'name' => "Test Campaign 2",
                    'daily' => 30,
                    'total' => 5000,
                    'from' => '2021-06-01',
                    'to' => '2022-01-01',
                    'images' =>[
                         'image' => UploadedFile::fake()->image('image.jpg'),
                    ],
                     
                ];


        $update = $this->json('PATCH', '/api/campaigns/'.$id, $data);
         //print_r($update);exit();
        $update->assertStatus(200);
         $response->assertJson(['error' => false]);
        $update->assertJson(['data' => "Updated"]);
    }  


    // public function testUploadImage()
    // {

    //     $data = [
    //                 'name' => "Test Campaign",
    //                 'daily' => 20,
    //                 'total' => 1000,
    //                 'from' => '2021-06-01',
    //                 'to' => '2022-01-01',
    //                 'images' =>[
    //         'image' => UploadedFile::fake()->image('image.jpg')
    //         ],
                     
    //             ];


    //     $response = $this->json('POST', '/api/campaigns',$data );

    //     print_r($response);exit;
    //     $response->assertStatus(200);
    //     $response->assertJson(['error' => false,'data'=>'Created']);
    //     $this->assertNotNull();
    // }


    public function testDeleteCampaign()
    {
        $response = $this->json('GET', '/api/campaigns');
        $response->assertStatus(200);
        $response->assertJson(['error' => false]);

        $campaign = $response->getData()->data[0];;
        $delete = $this->json('GET', '/api/campaigns/'.$campaign->id);
        $delete->assertStatus(200);
        $delete->assertJson(['data' => "Deleted"]);
   }
}
