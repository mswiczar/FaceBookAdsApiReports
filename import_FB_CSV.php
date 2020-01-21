<?
include_once "dbconnections.php";
dbconnect ();

class MyImportFB
{
    
    
    
    
    function getDateFromSql($theStr)
    {
        
        $sql2= "select STR_TO_DATE('".$theStr."','%b-%d-%Y-%b-%d-%Y') as fecha";
        //echo $sql2;
        $result2 = mysql_query ($sql2,$GLOBALS['XXXXXXX']);
        if ($r2 = mysql_fetch_assoc($result2))
        {
            $str_resultado =$r2['fecha'];
            
        }
        return $str_resultado;
    }
    
    
    
    
    
    
    
    
    function testHeader($theArrayHeader)
    {
        
        //    $arrayHeaderFixed =  array('Campaign Name','Ad Set Name','Country','Reach','Impressions','Frequency','Result Type','Results','Cost per Result','Amount Spent (USD)','CTR (All)','CPM (Cost per 1,000 Impressions)','Reporting Starts','Reporting Ends');
        
        $arrayHeaderFixed =  array('Campaign Name','Ad Set Name','Country','Reach','Impressions','Frequency','Result Type','Results','Cost per Result','Amount Spent (USD)','CTR (All)','CPM (Cost per 1,000 Impressions)');
        
        
        $row_number=0;
        foreach ($theArrayHeader as $valor)
        {
            $pos = strpos($valor, $arrayHeaderFixed[$row_number]);
            if ($pos === false)
            {
                return false;
            }
            $row_number++;
        }
        return true;
    }
    
    
    function delete_from_db ($theFecha)
    {
        $sql ="DELETE FROM IMP_FB_FACEBOOK  WHERE elDate = '".$theFecha ."'";
        $result = mysql_query ($sql,$GLOBALS['xxxxxxx']);
        
        print "Borrando Contenido para la Fecha: ".$theFecha . "\n";
        
        
        
    }
    
    
    
    
    function insert_into_db($elarray,$lafecha)
    {
        /*
         CREATE TABLE `IMP_FB_XXXXXXXX_FACEBOOK` (
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
        $sql = $sql . "elResultType,";
        $sql = $sql . "elResults,";
        $sql = $sql . "elCostPerResult,";
        $sql = $sql . "elAmountSpentUSD,";
        $sql = $sql . "elCTR_All,";
        $sql = $sql . "elCPM_1000,";
        $sql = $sql . "elReportingStarts,";
        $sql = $sql . "elReportingEnds";
        $sql = $sql . ")";
        $sql = $sql . "VALUES";
        $sql = $sql . "(";
        
        $sql = $sql . "'" . $lafecha . "',"; //date
        $sql = $sql . "'" . $elarray[0] . "',";  //camp
        $sql = $sql . "'" . $elarray[1] . "',";  //adset
        
        $eldevice = explode("-",$elarray[1]);
        
        $sql = $sql . "'" . $eldevice[2] . "',";  // device
        $sql = $sql . "'" . $elarray[2] . "',";
        $sql = $sql . "'" . $elarray[3] . "',";
        $sql = $sql . "'" . $elarray[4] . "',";
        $sql = $sql . "'" . $elarray[5] . "',";
        $sql = $sql . "'" . $elarray[6] . "',";
        $sql = $sql . "'" . $elarray[7] . "',";
        $sql = $sql . "'" . $elarray[8] . "',";
        $sql = $sql . "'" . $elarray[9] . "',";
        $sql = $sql . "'" . $elarray[10] . "',";
        $sql = $sql . "'" . $elarray[11] . "',";
        $sql = $sql . "'" . $lafecha . "',";
        $sql = $sql . "'" . $lafecha . "'";
        $sql = $sql . ")";
        
        //echo $sql ."<br>";
        $result = mysql_query ($sql,$GLOBALS['xxxxxxxxxxx']);
    }
    
    
    
    function importFacebook($theFile,$theFileNameOriginal)
    {
        $lafecha = "";
        $needle = "FB-Daily-Report-by-Country-and-Device-";
        
        $pos = strpos($theFileNameOriginal,'FB-Daily-Report-by-Country-and-Device-');
        
        if ($pos === false)
        {
            return false;
            
        }
        else
        {
            $tamanoNeedle = strlen($needle);
            
            $tamanostring =strlen($theFileNameOriginal);
            
            $auxData =  substr($theFileNameOriginal, $pos+$tamanoNeedle,$tamanostring - ($pos+$tamanoNeedle) );
            $pos = strpos($auxData,".csv");
            if ($pos === false)
            {
                print ("Incorrect FileName: ". $theFileNameOriginal ."\n");
                
                return false;
            }
            else
            {
                $auxData =  substr($auxData,0,$pos);
                $lafecha = $this->getDateFromSql($auxData);
            }
            
        }
        
        
        $file = fopen($theFile, "r");
        if ($file)
        {
            
        }
        else
        {
            print ("Unable to open file: ". $theFile ."\n");
            return false;
            
        }
        
        $row_number=0;
        while(!feof($file))
        {
            $lafila = fgets($file);
            $elarray = str_getcsv($lafila, ",", '"');
            if ($row_number==0)
            {
                if ($this->testHeader($elarray))
                {
                    print ( "El archivo contiene las columans correctas. Se procede a importar\n");
                    $this->delete_from_db($lafecha);
                    
                }
                else
                {
                    //echo "error Header<br>";
                    return false;
                    
                }
            }
            else
            {
                if (count($elarray)>2)
                {
                    if ($row_number>1)
                    {
                        $this->insert_into_db($elarray,$lafecha);
                    }
                }
            }
            $row_number++;
        }
        fclose($file);
        return true;
    }
}


?>


