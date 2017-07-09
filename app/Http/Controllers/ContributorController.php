<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Meta;

class ContributorController extends Controller
{
    public function contributors() {
    // 	$client = new \Guzzle\Service\Client();
    // 	$request = $client->get('https://api.github.com/repos/LAB-55/MakersLog/contributors');
  		// $response = $request->send();
  		// $result = $response->json();
    	
    	$client = new \Guzzle\Service\Client();
    	$request = $client->get('https://api.github.com/repos/LAB-55/MakersLog/stats/contributors', [
    							'token' => env('GITHUB_TOKEN')
		]);
  		$response = $request->send();
  		$result = $response->json();

  		$commit = array();
  		for ($i=0; $i < count($result) ; $i++) {
  			for ($j = 0; $j < count($result[$i]['weeks']); $j++) { 
  				$commit[$i][$j] = $result[$i]['weeks'][$j]['c'];
  				// echo  $i . "[c] : " . $commit[$i]['c'];
  				// echo "<br>";	
  			}
  		}
      	
  		// print_r($result);
    //   	exit();
    	
    	return view('contributor')
    			->with('contributors', $result)
    			->with('commit', $commit)
    			->with('meta', Meta::get());
    }
}
