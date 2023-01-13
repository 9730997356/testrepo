<?php

try{

    if(isset($_REQUEST['ok'])){
        $xml=new DOMDocument("1.0","UTF-8");
        $xml->load("dataset.xml");
        
        $rootTag = $xml->getElementsByTagName("root")->item(0);
        $id = $rootTag->childNodes->length;
        $dataTag = $xml->createElement("format");
        $dataTag->setAttribute('id', $id);
        
        $aTag = $xml->createElement('no',$_REQUEST['no']);
        $bTag = $xml->createElement('result',$_REQUEST['result']);
        $img = $xml->createElement('img',$_REQUEST['img']);

        $dataTag->appendChild($aTag);
        $dataTag->appendChild($bTag);
        $dataTag->appendChild($img);

        $rootTag->appendChild($dataTag);
        $xml->save("dataset.xml");
        
       
    
$xml=simplexml_load_file("dataset.xml") or die("Error: Cannot create object");
$last = $xml->xpath("/root/format[last()]/no"); 
$soapclient = new SoapClient('https://www.dataaccess.com/webservicesserver/NumberConversion.wso?wsdl', array('trace' => true));

$response = $soapclient->NumberToWords (array('ubiNum'=>$last[0]));
$array = json_decode(json_encode($response),true);
print_r($array);
echo '<br><br>';
}
} 
catch(Exception $e){
    echo $e->getMessage();
}

?>

<html>
<body>
<form action="add.php" method="post">
<input type="number" name="no">
<input type="hidden" name="result" value="<?php print_r($array); ?>">
<input type="file" name="img">
<input type="submit" name="ok" value="convert">
</form>
