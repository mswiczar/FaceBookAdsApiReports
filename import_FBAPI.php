<?
include_once "dbconnections.php";
dbconnect ();




class MyFBApi
{
    
    function getDate2Execute($theStr)
    {
        $sql2= "select DATE_ADD( DATE(NOW()), INTERVAL ".$theStr." DAY) as ahora";
        $result2 = mysql_query ($sql2,$GLOBALS['db_xxxxxx']);
        if ($r2 = mysql_fetch_assoc($result2))
        {
            $str_resultado =$r2['ahora'];
            
        }
        return $str_resultado;
    }



    function delete_from_db ($theFecha)
    {
        $sql ="DELETE FROM IMP_FB_FACEBOOK  WHERE elDate = '".$theFecha ."'";
        $result = mysql_query ($sql,$GLOBALS['db_xxxxxxx']);
        
        print "Borrando Contenido para la Fecha: ".$theFecha . "\n";
        
        
        
    }
    
    
    function insert_into_db($elarray,$lafecha)
    {
        
        
        
        /*
         CREATE TABLE `IMP_FB__FACEBOOK` (
         `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
         `elDate` date DEFAULT NULL,
         `elCampaignName` varchar(255) DEFAULT NULL,
         `elDevice` varchar(255) DEFAULT NULL,
         `elAdSetName` varchar(255) DEFAULT NULL,
         `elCountry` varchar(255) DEFAULT NULL,
         `elReach` int(11) DEFAULT NULL,
         `elImpressions` int(11) DEFAULT NULL,
         `elFrequency` decimal(14,12) DEFAULT NULL,
         `elResultType` varchar(255) DEFAULT NULL,
         `elResults` varchar(255) DEFAULT NULL,
         `elCostPerResult` decimal(8,2) DEFAULT NULL,
         `elAmountSpentUSD` decimal(8,2) DEFAULT NULL,
         `elCTR_All` decimal(8,2) DEFAULT NULL,
         `elCPM_1000` decimal(8,2) DEFAULT NULL,
         `elReportingStarts` date DEFAULT NULL,
         `elReportingEnds` date DEFAULT NULL,
         PRIMARY KEY (`id`)
         ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
         
         
         */
        
        //print_r($elarray);
        
        
        foreach ($elarray as $v)
        {
           // print_r($v);

            //[campaign_name] => ToF - Mobile
            //[adset_name] => ToF - Rest - Mobile
            //[reach] => 17918
            //[frequency] => 1.004632
            //[impressions] => 18001
            //[spend] => 4.89
            //[clicks] => 242
            //[ctr] => 1.34437
            //[cpm] => 0.271652
            //[date_start] => 2019-02-07
            //[date_stop] => 2019-02-07
            //[country] => CL
            
        
            $sql = "";
            $sql = $sql . "INSERT INTO IMP_FB_FACEBOOK ";
            $sql = $sql . "(";
            $sql = $sql . "elDate,";
            $sql = $sql . "elCampaignName,";
            $sql = $sql . "elAdSetName,";
            $sql = $sql . "elDevice,";
            $sql = $sql . "elCountry,";
            $sql = $sql . "elReach,";
            $sql = $sql . "elImpressions,";
            $sql = $sql . "elFrequency,";
//            $sql = $sql . "elResultType,";
//            $sql = $sql . "elResults,";
//            $sql = $sql . "elCostPerResult,";
            $sql = $sql . "elAmountSpentUSD,";
            $sql = $sql . "elCTR_All,";
            $sql = $sql . "elCPM_1000,";
            $sql = $sql . "elReportingStarts,";
            $sql = $sql . "elReportingEnds";
            $sql = $sql . ")";
            $sql = $sql . "VALUES";
            $sql = $sql . "(";
            
            $sql = $sql . "'" . $lafecha . "',"; //date
            $sql = $sql . "'" . $v['campaign_name']. "',";  //camp
            $sql = $sql . "'" . $v['adset_name'] . "',";  //adset
            $eldevice = explode("-",$v['adset_name']);
            $sql = $sql . "'" . trim($eldevice[2]) . "',";  // device
            $sql = $sql . "'" . $v['country'] . "',";
            $sql = $sql . "'" . $v['reach'] . "',";
            $sql = $sql . "'" . $v['impressions'] . "',";
            $sql = $sql . "'" . $v['frequency']. "',";
//            $sql = $sql . "'" . $elarray[6] . "',";
//            $sql = $sql . "'" . $elarray[7] . "',";
//            $sql = $sql . "'" . $elarray[8] . "',";
            $sql = $sql . "'" . $v['spend'] . "',";
            $sql = $sql . "'" . $v['ctr'] . "',";
            $sql = $sql . "'" . $v['cpm']. "',";
            $sql = $sql . "'" . $lafecha . "',";
            $sql = $sql . "'" . $lafecha . "'";
            $sql = $sql . ")";
            
          //  echo $sql ."\n";
            $result = mysql_query ($sql,$GLOBALS['db_xxxxxx']);
            
        }

    }
    
    
    
    
}


?>


