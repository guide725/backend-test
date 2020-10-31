<?php

namespace Tests\Unit;

use App\Models\Creator;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
class CreatorTest extends TestCase
{
    /** @test */
    public function Login_Success()
    {
        $response = $this->json('POST','login',['username'=>"ankunding2",'password'=>"123456"]);
        $response->assertStatus(200)
                    ->assertJsonStructure(["response","token"])
                    ->assertJson(["status"=>true,
                                    "message" => "Login success"]);
    }

    /** @test */
    public function Login_Failed_with_wrong_account()
    {
        $response = $this->json('POST','login',['username'=>"guide726",'password'=>"123456"]);
        $response->assertStatus(400)
                    ->assertJson(["status" => false,
                                    "message"=> "Invalid username or password"]);
    }
    /** @test */
    public function Login_Failed_with_username_lessthan4()
    {
        $response = $this->json('POST','login',['username'=>"gui",'password'=>"123456"]);
        $response->assertStatus(400)
                    ->assertJson(["status" => false,
                                    "message"=> ["username"=> [
                                        "The username must be at least 4 characters."
                                    ]]]);
    }
    /** @test */
    public function Login_Failed_with_password_lessthan6()
    {
        $response = $this->json('POST','login',['username'=>"ankunding2",'password'=>"123"]);
        $response->assertStatus(400)
                    ->assertJson(["status" => false,
                                    "message"=> ["password"=> [
                                        "The password must be at least 6 characters."
                                    ]]]);
    }
    /** @test */
    public function Logout_success_with_jwt()
    {
        $user = Creator::where('username',"ankunding2")->first();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','logout');
        $response->assertStatus(200)
                    ->assertJson(["status"=>true ,
                                    "message"=>"logout success"]);
    }
    /** @test */
    public function Logout_failed_with_no_jwt()
    {
        $response = $this->json('GET','logout');
        $response->assertStatus(401)
                    ->assertJson([
                        'status' => false,
                        'message' => "Unauthorized"
                    ]);
    }
    /** @test */
    public function Logout_failed_with_jwt_expired_or_jwt_notcorrect()
    {
        $user = Creator::where('username',"ankunding2")->first();
        $token = JWTAuth::fromUser($user);
        $token = $token."adfdsfa";
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','logout');
        $response->assertStatus(401)
                    ->assertJson([
                        'status' => false,
                        'message' => "Unauthorized"
                    ]);
    }
    /** @test */
    public function RefreshToken_success_with_jwt()
    {
        $user = Creator::where('username',"ankunding2")->first();
        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','refresh');
        $response->assertStatus(200)
                    ->assertJson(["status"=>true ,
                                    "message"=>"logout success"]);
    }
    /** @test */
    public function RefreshToken_failed_with_no_jwt()
    {
        $response = $this->json('GET','refresh');
        $response->assertStatus(401)
                    ->assertJson([
                        'status' => false,
                        'message' => "Unauthorized"
                    ]);
    }
    /** @test */
    public function RefreshToken_failed_with_jwt_expired_or_jwt_notcorrect()
    {
        $user = Creator::where('username',"ankunding2")->first();
        $token = JWTAuth::fromUser($user);
        $token = $token."adfdsfa";
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','refresh');
        $response->assertStatus(401)
                    ->assertJson([
                        'status' => false,
                        'message' => "Unauthorized"
                    ]);
    }
}