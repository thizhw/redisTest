<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class RedisController extends Controller
{

    public function index() {
        Redis::set("user:1:first_name", "Mike");
        Redis::set("user:2:first_name", "John");
        Redis::set("user:3:first_name", "Kate");

        for ($i=0; $i < 4; $i++) {
            echo Redis::get('user:' . $i . ':first_name');
        }
    }

    // public function setData(Request $req) {
    //     // Establish connection to Redis
    //     $redis = Redis::connection();
    
    //     // Extract first name and last name from the request
    //     $firstName = $req->input('fname');
    //     $lastName = $req->input('lname');
    
    //     // Check if both first name and last name are provided
    //     if ($firstName && $lastName) {
    //         // Create an array with user details
    //         $userDetails = [
    //             'first_name' => $firstName,
    //             'last_name' => $lastName
    //         ];
    
    //         // Generate a unique key for the user details
    //         $userId = uniqid(); // You can use any method to generate a unique identifier here
    
    //         // Set user details in Redis with a unique key
    //         $redis->set("user_details:$userId", json_encode($userDetails));
    
    //         // Optionally, you may want to set an expiration time for the key
    //         // $redis->expire("user_details:$userId", 3600); // Expires in 1 hour
    
    //         // Redirect back with a success message
    //         return back()->with('success', 'User details saved successfully.');
    //     } else {
    //         // Redirect back with an error message if either first name or last name is missing
    //         return back()->with('error', 'Both first name and last name are required.');
    //     }
    // }    

    // public function getData() {
    //     $redis    = Redis::connection();

    //     $response = $redis->get('user_details');

    //     $response = json_decode($response);
    // }
    

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        Redis::hmset('user:'.$validatedData['name'], [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        return redirect()->back()->with('success', 'Data stored successfully');
    }

    // public function getData() 
    // {

    //     $userData = Redis::hgetall('user:*');

    //     $name = $userData['name'];
    //     $email = $userData['email'];

    //     return view('redis', ['name'=>$name, 'email'=>$email]);

    // }

    public function getData() 
    {

        $keys = Redis::keys('user:*');

        $users = [];
        foreach ($keys as $key) {
            print_r($key);
            echo "<br/>";
            $user = Redis::hgetall($key);
            $users[] = $user;
        }

        dd($users);

        return view('redis', ['users'=>$users]);

    }

}
