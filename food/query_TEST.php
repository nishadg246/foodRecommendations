<?php
/**
 * Yelp API v2.0 code sample.
 *
 * This program demonstrates the capability of the Yelp API version 2.0
 * by using the Search API to query for businesses by a search term and location,
 * and the Business API to query additional information about the top result
 * from the search query.
 * 
 * Please refer to http://www.yelp.com/developers/documentation for the API documentation.
 * 
 * This program requires a PHP OAuth2 library, which is included in this branch and can be
 * found here:
 *      http://oauth.googlecode.com/svn/code/php/
 * 
 * Sample usage of the program:
 * `php sample.php --term="bars" --location="San Francisco, CA"`
 */

// Enter the path that the oauth library is in relation to the php file
require_once('lib/OAuth.php');

// Set your OAuth credentials here  
// These credentials can be obtained from the 'Manage API Access' page in the
// developers documentation (http://www.yelp.com/developers)
$CONSUMER_KEY = 'leaRUtt_xLiPTpHcLAz-tA';
$CONSUMER_SECRET = 'NLFCDlZOxYk9OdA5T1zdMpDNzck';
$TOKEN = '9WEVH3r7rloVGZ_ePLDku4pnMcwaODyv';
$TOKEN_SECRET = 'x-OekiDFmZswiboUZvoHCap-Dp4';

$API_HOST = 'api.yelp.com';
$currentTime = getdate();
// echo $currentTime["hours"];
$currentTime = $currentTime["hours"];
if ($currentTime < 10)
    $DEFAULT_TERM = 'breakfast';
elseif ($currentTime < 16)
    $DEFAULT_TERM = 'lunch';
else
    $DEFAULT_TERM = 'dinner';
$CATEGORY_FILTER = '';
$DEFAULT_LOCATION = 'PITTSBURGH, PA';
$SEARCH_LIMIT = 15;
$SEARCH_PATH = '/v2/search/';
$BUSINESS_PATH = '/v2/business/';
//$cats = {"Mexican", "Chinese", "indpak", "newamerican", "Vegetarian", "Pizza", "hotdogs"};
//Convert to accept input

// $PASTLOC = 1;

// //Curl Request
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, "40.122.203.139:8000/?word="{$PASTLOC}); //Pass Location of previous sites
    // $analysis = curl_exec($ch);
    // curl_close($ch);
$analysis = fopen("output.txt","r");
$decoded = json_decode(fread($analysis, filesize("output.txt")));
// var_dump(($decoded));
fclose($analysis);

shell_exec(escapeshellcmd('python /var/www/html/food/ratings.py'));

$counts = $decoded->categoryCounts;
$numOfType = array(
        "1" => $counts->mexican,
        "2" => $counts->chinese,
        "3" => $counts->indpak,
        "4" => $counts->newamerican,
        "5" => $counts->vegetarian,
        "6" => $counts->pizza,
        "7" => $counts->hotdogs
        );
// var_dump($numOfType);
// var_dump($counts);
$ignoredPlaces = $decoded->previousRestaurants;
$nameOfType = array(
        "1" => 'mexican',
        "2" => 'chinese',
        "3" => 'indpak',
        "4" => 'newamerican',
        "5" => 'vegetarian',
        "6" => 'pizza',
        "7" => 'hotdogs');
// var_dump($numOfType);

/** 
 * Makes a request to the Yelp API and returns the response
 * 
 * @param    $host    The domain host of the API 
 * @param    $path    The path of the APi after the domain
 * @return   The JSON response from the request      
 */
function request($host, $path) {
    $unsigned_url = "http://" . $host . $path;

    // Token object built using the OAuth library
    $token = new OAuthToken($GLOBALS['TOKEN'], $GLOBALS['TOKEN_SECRET']);

    // Consumer object built using the OAuth library
    $consumer = new OAuthConsumer($GLOBALS['CONSUMER_KEY'], $GLOBALS['CONSUMER_SECRET']);

    // Yelp uses HMAC SHA1 encoding
    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

    $oauthrequest = OAuthRequest::from_consumer_and_token(
        $consumer, 
        $token, 
        'GET', 
        $unsigned_url
    );
    
    // Sign the request
    $oauthrequest->sign_request($signature_method, $consumer, $token);
    
    // Get the signed URL
    $signed_url = $oauthrequest->to_url();
    
    // Send Yelp API Call
    $ch = curl_init($signed_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    
    return $data;
}

/**
 * Query the Search API by a search term and location 
 * 
 * @param    $term        The search term passed to the API 
 * @param    $location    The search location passed to the API 
 * @return   The JSON response from the request 
 */
function search($term, $location) {
    $url_params = array();
    
    $url_params['term'] = $term ?: $GLOBALS['DEFAULT_TERM'];
    $url_params['location'] = $location?: $GLOBALS['DEFAULT_LOCATION'];
    $url_params['limit'] = $GLOBALS['SEARCH_LIMIT'];
    $url_params['category_filter'] = $GLOBALS['CATEGORY_FILTER']; 
    $search_path = $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);
    // var_dump($url_params);
    return request($GLOBALS['API_HOST'], $search_path);
}

/**
 * Query the Business API by business_id
 * 
 * @param    $business_id    The ID of the business to query
 * @return   The JSON response from the request 
 */
function get_business($business_id) {
    $business_path = $GLOBALS['BUSINESS_PATH'] . $business_id;
    
    return request($GLOBALS['API_HOST'], $business_path);
}

/**
 * Queries the API by the input values from the user 
 * 
 * @param    $term        The search term to query
 * @param    $location    The location of the business to query
 * @return   $allBusinessData
 */
function query_api($term, $location) {     
    $response = json_decode(search($term, $location));
    $business_id = $response->businesses[0]->id;
        
    $allBusinessData = array(
        "names" => array(),
        "location" => array(),
        "type" => array(),
        "image" => array(),
        "phone" => array(),
        "address" => array()
        );
    // var_dump($response);

    for ($i = 1; $i < 5; $i++){
        $bus = $response->businesses[$i]->image_url;
        $start = strpos($bus, 'bphoto') + 7;
        $end = strpos($bus, '/ms');
        $full_url = substr($bus, $start, $end-$start);
        $full_url = "http://s3-media4.fl.yelpcdn.com/bphoto/{$full_url}/o.jpg";
        $allBusinessData["names"][$i] = $response->businesses[$i]->name;
        $allBusinessData["type"][$i] = $response->businesses[$i]->categories[0][0];
        $allBusinessData["location"][$i] = $response->businesses[$i]->location->coordinate;
        $allBusinessData["image"][$i] = $full_url;
        $allBusinessData["phone"][$i] = $response->businesses[$i]->phone;
        $allBusinessData["address"][$i] = $response->businesses[$i]->location->display_address;
    }
    return $allBusinessData;

}

/**
 * User input is handled here 
 */
$longopts  = array(
    "term::",
    "location::",
);
    
$options = getopt("", $longopts);

$term = $options['term'] ?: '';
$location = $options['location'] ?: '';
$final = array();
$overall = 1;
for ($i = 1; $i < 8; $i++){
    $numEntered = 1;
    $choice = 1;
    $CATEGORY_FILTER = $nameOfType["$i"];
    $allBusinessData = query_api($term, $location);
    // var_dump($numOfType["$i"]);
                // var_dump($allBusinessData);
    while ($numEntered <= ($numOfType["$i"])){
        // print"\nOverall "; print($overall);
        // var_dump(in_array($allBusinessData["names"][$choice],$ignoredPlaces));
        // var_dump($allBusinessData["names"][$choice]);
        // if (in_array($allBusinessData["names"][$choice],$ignoredPlaces)){
        //     $choice++;
        //     // $overall--;
        // }
        // else{
            $final["names"][$overall] = $allBusinessData["names"][$choice];
            $final["type"][$overall] = $allBusinessData["type"][$choice];
            $final["location"][$overall] = $allBusinessData["location"][$choice];
            $final["image"][$overall] = $allBusinessData["image"][$choice];
            $final["phone"][$overall] = $allBusinessData["phone"][$choice];
            $final["address"][$overall] = $allBusinessData["address"][$choice];
            $overall++;
            $numEntered++;
            $choice++;
        // }
    }
    // echo "TESTSTESTESTSTESTETESTSE";
    // var_dump($final);
}

//echo("Query Returned \n");
// var_dump($retval);
// echo overall;
echo json_encode($final);
?>
