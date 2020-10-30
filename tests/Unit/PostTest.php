<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Creator;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
class PostTest extends TestCase
{
        /** @test */
        public function showPost_published_have_noP()
        {
            $response = $this->json('GET','/posts');
            $response->assertStatus(200)
                ->assertJson([
                    'status' => true,
            ]);
        }
        /** @test */
        public function showPost_published_haveP()
        {
            $response = $this->json('GET','/posts',['p'=>3]);
            $response->assertStatus(200)
                ->assertJson([
                    'status' => true,
            ]);
        }
        /** @test */
        public function showPost_HaveP_Exceed_limit()
        {
            $response = $this->json('GET','/posts',['p'=>999]);
            $response->assertStatus(400)
                ->assertJson([
                    'status' => false,
                    'message' => "Bad request"
                ]);
        }
        /** @test */
        public function createPost_Have_No_jwt()
        {
            $response = $this->withHeaders([
                'X-Header' => 'Value',
            ])->json('POST','/posts',
                        ['title'=>'POST#TEST',
                        'content'=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit." , 
                        "author"=>'Mr.G' , 
                        "published"=>"0"]);
            $response->assertStatus(401)
                ->assertJson([
                    'status' => false,
                    'message' => "Unauthorized"
                ]);
        }
        /** @test */
        public function createPost_Have_jwt()
        {
            $user = Creator::where('username',"guide725")->first();
            $token = JWTAuth::fromUser($user);
            $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token,
            ])->json('POST','/posts',
                        ['title'=>'POST#TEST',
                        'content'=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit." , 
                        "author"=>'Mr.G' , 
                        "published"=>"0"]);
            $response->assertStatus(201)
                ->assertJson([
                    "status"=>true , 
                    "message"=>"create success"
                ]);
        }
        /** @test */
        public function createPost_Have_jwt_TitleLen_lessthan3()
        {
            $user = Creator::where('username',"guide725")->first();
            $token = JWTAuth::fromUser($user);
            $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST','/posts',
                        ['title'=>'PO',
                        'content'=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit." , 
                        "author"=>'Mr.G' , 
                        "published"=>"0"]);
            $response->assertStatus(400)
                ->assertJson([
                    "status"=>false , 
                    "message"=> ["title" => [
                        "The title must be at least 3 characters."
                    ]]
                ]);
        }
        /** @test */
        public function createPost_Have_jwt_contentLen_lessthan3()
        {
            $user = Creator::where('username',"guide725")->first();
            $token = JWTAuth::fromUser($user);
            $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token,
            ])->json('POST','/posts',
                        ['title'=>'POST#TEST',
                        'content'=>"t." , 
                        "author"=>'Mr.G' , 
                        "published"=>"0"]);
            $response->assertStatus(400)
                ->assertJson([
                    "status"=>false , 
                    "message"=> ["content" => [
                        "The content must be at least 3 characters."
                    ]]
                ]);
        }
        /** @test */
        public function publishPost_Have_No_jwt()
        {
            $response = $this->json('GET','/posts/'.'3'.'/publish');
            $response->assertStatus(401)
                ->assertJson([
                    "status"=> false,
                    "message"=> "Unauthorized"
                    
                ]);
        }
        /** @test */
        public function publishPost_Have_jwt()
        {
            $user = Creator::where('username',"guide725")->first();
            $token = JWTAuth::fromUser($user);
            $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token,
            ])->json('GET','/posts/'.'3'.'/publish');
            $response->assertStatus(200)
                ->assertJson([
                    "status"=> true,
                    "message"=> "publish success"
                    
                ]);
        }
        /** @test */
        public function publishPost_Have_jwt_No_Data()
        {
            $user = Creator::where('username',"guide725")->first();
            $token = JWTAuth::fromUser($user);
            $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token,
            ])->json('GET','/posts/'.'999'.'/publish');
            $response->assertStatus(400)
                ->assertJson([
                    "status"=> false,
                    "message"=> "Bad request"
                ]);
        }



}
