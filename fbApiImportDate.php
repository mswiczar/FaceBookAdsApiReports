<?

require '/home/Project' . '/vendor/autoload.php';


use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdsInsights;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;

include_once "import_FBAPI.php";


$access_token ='xxxxxxxx';


$ad_account_id = 'act_xxxxxxxxx';

$app_secret = 'xxxxxxxxxxxxxx';
$app_id = 'xxxxxxxx';

$api = Api::init($app_id, $app_secret, $access_token);
$api->setLogger(new CurlLogger());

$fields = array(
  'campaign_name',
  'adset_name',
  'reach',
  'frequency',
  'impressions',
  'spend',
  'clicks',
  'ctr',
  'cpm',
);




$objFB = new MyFBApi();


    $eldia = $argv[1];

    print ($eldia . "\n");
    
    
    
    $params = array(
      'level' => 'adset',
      'filtering' => array(),
      'breakdowns' => array('country'),
      'time_range' => array('since' => $eldia,'until' => $eldia),
    );

    $elArrayRespuesta = (new AdAccount($ad_account_id))->getInsights(
                                                         $fields,
                                                         $params
                                                         )->getResponse()->getContent();

    print "\n--------------\n";
    $objFB->delete_from_db($eldia);
    $objFB->insert_into_db($elArrayRespuesta['data'],$eldia);

   // print_r($elArrayRespuesta['data']);
    print "\n--------------\n";





    while (isset($elArrayRespuesta['paging']['next'] ))
    {
        $pagina_inicio = file_get_contents($elArrayRespuesta['paging']['next']);
        $elArrayRespuesta = json_decode ($pagina_inicio,true);
      //  print_r($elArrayRespuesta['data']);
        $objFB->insert_into_db($elArrayRespuesta['data'],$eldia);
        print "\n--------------\n";
    }


$objFB = NULL;



/*
 echo json_encode((new AdAccount($ad_account_id))->getInsights(
 $fields,
 $params
 )->getResponse()->getContent(), JSON_PRETTY_PRINT);
 */
//   echo json_encode((new AdAccount($ad_account_id))->getInsights(
//  $fields,
//  $params
//)->getResponse()->getContent(), JSON_PRETTY_PRINT);


// importar todo el Mes?



/*
    print "Next: " . $elArrayRespuesta['paging']['next'];
   print "\n---Primer Paging-----------\n";
//  print_r($elArrayRespuesta['paging']);
//  print "\n--------------\n";
//  print_r($elArrayRespuesta['paging']['next']);
//  print "\n--------------\n";
  print "Next: " . $elArrayRespuesta['paging']['next'];
  print "\n--------------\n";
  $pagina_inicio = file_get_contents($elArrayRespuesta['paging']['next']);
//  print "\n--------------\n";
  $data = json_decode ($pagina_inicio,true);
  //print "\n---- encoded----------\n";
  //print_r($data['data']);
  print "\n---- pagging 2 ----------\n";
  $pagina_inicio = file_get_contents($data['paging']['next']);
print "\n--------------\n";
print_r($data['paging']);
print "Next: " . $data['paging']['next'];
print "\n--------------\n";
$data = json_decode ($pagina_inicio,true);
print "\n---- encoded----------\n";
print_r($data['paging']);

*/













?>

