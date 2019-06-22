<?php

include "KIU_Connection_class.php";

class KIU_Model extends KIU_Connection
{
	protected $EchoToken = 1;
	protected $TimeStamp;
	protected $Sine ='LIM002IWW';
	protected $Device ='TCQ002IA01';
	/* protected $Target ='Production'; */
	protected $Target ='Testing';
	protected $SequenceNmbr = 1;

        
public function Model_AirAvailRQ($args)
{
$default = array ( "Direct" => "", "Date" => "", "Source" => "", "Dest" => "", "Cabin" => "", "QuantityADT" => "" , "QuantityCNN" => "", "QuantityINF" => "");
extract( array_merge($default, $args) );
if($Source === '/b>' || $Dest === '/b>'){
    header("Location: https://www.starperu.com/empresas/");
}
if($Source === 't()' || $Dest === 't()'){
    header("Location: https://www.starperu.com/empresas/");
}
$request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<KIU_AirAvailRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\" DirectFlightsOnly=\"$Direct\">
	<POS>
		<Source AgentSine=\"$this->Sine\" TerminalID=\"$this->Device\">
		</Source>
	</POS>
	<OriginDestinationInformation>
		<DepartureDateTime>$Date</DepartureDateTime>
		<OriginLocation LocationCode=\"$Source\"/>
		<DestinationLocation LocationCode=\"$Dest\"/>
	</OriginDestinationInformation>
	<TravelPreferences >
		<CabinPref Cabin=\"$Cabin\"/>
	</TravelPreferences>
	<TravelerInfoSummary>
		<AirTravelerAvail>
			<PassengerTypeQuantity Code=\"ADT\" Quantity=\"$QuantityADT\"/>
                        <PassengerTypeQuantity Code=\"CNN\" Quantity=\"$QuantityCNN\"/>
                         <PassengerTypeQuantity Code=\"INF\" Quantity=\"$QuantityINF\"/>
		</AirTravelerAvail>
	</TravelerInfoSummary>
</KIU_AirAvailRQ>";
$this->Connection();
$response = $this->SendMessage($request);
if($this->ErrorCode!=0)$response="<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";
return simplexml_load_string($response);
//echo '<pre>';
//        var_dump(simplexml_load_string($response));
//echo '</pre>';
//return $request;

}


public function Model_AirBookRQ($args)
{
$default = array ( 'City' => '', 'Country' => '', 'Currency' => '', 'FlightSegment' => array()
	      , 'Passengers' => array(), 'Remark' => '');
extract( array_merge($default, $args) );
$request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <KIU_AirBookRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
            <POS>
		<Source AgentSine=\"$this->Sine\" PseudoCityCode=\"$City\" ISOCountry=\"$Country\" ISOCurrency=\"$Currency\" TerminalID=\"$this->Device\">
			<RequestorID Type=\"5\"/>
			<BookingChannel Type=\"1\"/>
		</Source>
            </POS>
            <PriceInfo>
              <FareInfos>
                 <FareInfo>
                    <DiscountPricing TicketDesignatorCode=\"O1\" />
                 </FareInfo>
              </FareInfos>
           </PriceInfo>
            <AirItinerary>
		<OriginDestinationOptions>
                        <OriginDestinationOption>";
                            foreach($FlightSegment as $item){

                                $ddatetime = $item["DepartureDateTime"];
                                $adatetime = $item["ArrivalDateTime"];
                                $flight = $item["FlightNumber"];
                                $class = $item["ResBookDesigCode"];
                                $source = $item["DepartureAirport"];;
                                $dest = $item["ArrivalAirport"];
                                $airline = $item["MarketingAirline"];

                                $request .= "<FlightSegment DepartureDateTime=\"$ddatetime\" ArrivalDateTime=\"$adatetime\" FlightNumber=\"$flight\" ResBookDesigCode=\"$class\" >
                                                <DepartureAirport LocationCode=\"$source\"/>
                                                <ArrivalAirport LocationCode=\"$dest\"/>
                                                <MarketingAirline Code=\"$airline\"/>
                                            </FlightSegment>";
                             }

                             /*
            <PriceInfo>
                <FareInfos>
                    <FareInfo>
                        <DiscountPricing TicketDesignatorCode=\"DC\" />
                    </FareInfo>
                </FareInfos>
            </PriceInfo>*/
                             
        $request .= "</OriginDestinationOption>
		</OriginDestinationOptions>
	</AirItinerary>
                    <TravelerInfo>";
                    $i=1;
                    foreach($Passengers as $item){
                        
                        $PassengerType = $item["Tipo_Pasajero"];
                        $GivenName = $item["Nombres"];
                        $Surname = $item["Apellidos"];
                        $PhoneNumber = $item["Celular"];
                        $Email = $item["Email"];;
                        $DocID = $item["Numero_Documento"];
                        $DocType = $item["Tipo_Documento"];
                        
                        $request .= "<AirTraveler PassengerTypeCode=\"$PassengerType\">
                                            <PersonName>
                                                    <GivenName>$GivenName</GivenName>
                                                    <Surname>$Surname</Surname>
                                            </PersonName>
                                            <Telephone PhoneNumber=\"$PhoneNumber\"/>
                                            <Email>$Email</Email>
                                            <Document DocID=\"$DocID\" DocType=\"$DocType\"></Document>
                                            <TravelerRefNumber RPH=\"$i\"/>
                                    </AirTraveler>";
                        $i++;
                    }
        $request .= "<SpecialReqDetails>
                        <Remarks>
                            <Remark>$Remark</Remark>
                        </Remarks> 
                    </SpecialReqDetails>
        </TravelerInfo>
	<Ticketing TicketTimeLimit=\"1\" />
</KIU_AirBookRQ>";

$this->Connection();
$response = $this->SendMessage($request);
if($this->ErrorCode!=0)$response="<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";
//return $request ;
//return simplexml_load_string($response);
$array=array();
$array[]=simplexml_load_string($response);
$array[]=htmlspecialchars($request,ENT_QUOTES);
$array[]=htmlspecialchars($response,ENT_QUOTES);
return $array[0];
}



public function Model_AirPriceRQ($args)
{
    $default = array ( 'City' => '', 'Country' => '', 'Currency' => '', 'FlightSegment' => array()
        , 'PassengerQuantityADT' => 0,  'PassengerQuantityCNN' => 0, 'PassengerQuantityINF' => 0
        ,  'GivenName' => '', 'Surname' => '', 'PhoneNumber' => '', 'Email' => '', 'DocID' => '', 'DocType' => '', 'Remark' => '');
    extract( array_merge($default, $args) );
    $request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                <KIU_AirPriceRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
                    <POS>
                        <Source AgentSine=\"$this->Sine\" PseudoCityCode=\"$City\" ISOCountry=\"$Country\" ISOCurrency=\"$Currency\" TerminalID=\"$this->Device\">
                            <RequestorID Type=\"5\"/>
                            <BookingChannel Type=\"1\"/>
                        </Source>
                    </POS>
                <AirItinerary>
                    <OriginDestinationOptions>
                    <OriginDestinationOption>";
                
                foreach($FlightSegment as $item)
                {
                	$ddatetime = $item["DepartureDateTime"];
                	$adatetime = $item["ArrivalDateTime"];
                        $flight = $item["FlightNumber"];
                	$class = $item["ResBookDesigCode"];
                	$source = $item["DepartureAirport"];;
                        $dest = $item["ArrivalAirport"];
                	$airline = $item["MarketingAirline"];
                	$request .= "<FlightSegment DepartureDateTime=\"$ddatetime\" ArrivalDateTime=\"$adatetime\" FlightNumber=\"$flight\" ResBookDesigCode=\"$class\" >
					<DepartureAirport LocationCode=\"$source\"/>
					<ArrivalAirport LocationCode=\"$dest\"/>
					<MarketingAirline Code=\"$airline\"/>
                                    </FlightSegment>";
                }
   $request .= "</OriginDestinationOption>
		</OriginDestinationOptions>
        </AirItinerary>
        <TravelerInfoSummary>
        <AirTravelerAvail>";
if($PassengerQuantityADT>0)$request .="<PassengerTypeQuantity Code=\"ADT\" Quantity=\"$PassengerQuantityADT\"/>";
if($PassengerQuantityCNN>0)$request .="<PassengerTypeQuantity Code=\"CNN\" Quantity=\"$PassengerQuantityCNN\"/>";
if($PassengerQuantityINF>0)$request .="<PassengerTypeQuantity Code=\"INF\" Quantity=\"$PassengerQuantityINF\"/>";
$request .="</AirTravelerAvail>
        </TravelerInfoSummary>
        </KIU_AirPriceRQ>";

$this->Connection();
$response = $this->SendMessage($request);
if($this->ErrorCode!=0)$response="<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";
// return $request;
return simplexml_load_string($response);

 
}



public function Model_AirDemandTicketRQ($args)
{
$default = array ( 'PaymentType'=>'', 'Country' => '', 'Currency' => '', 'TourCode' => '', 'BookingID' => ''
	, 'CreditCardCode' => '', 'CreditCardNumber' => '', 'CreditSeriesCode' => '', 'CreditExpireDate' => '', 'DebitCardCode' => ''
	, 'DebitCardNumber' => '', 'DebitSeriesCode' => '', 'InvoiceCode' => '', 'MiscellaneousCode' => '', 'Text' => '','VAT'=>'','Endorsement'=>'');
extract( array_merge($default, $args) );
$request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<KIU_AirDemandTicketRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
	<POS>
		<Source AgentSine=\"$this->Sine\" TerminalID=\"$this->Device\" ISOCountry=\"$Country\" ISOCurrency=\"$Currency\">
			<RequestorID Type=\"5\"/>
			<BookingChannel Type=\"1\"/>
		</Source>
	</POS>
	<DemandTicketDetail TourCode=\"$TourCode\">
	<BookingReferenceID ID=\"$BookingID\">
		<CompanyName Code=\"2I\"/>
	</BookingReferenceID>";
	switch ($PaymentType) {
		case 5:
			$request .= "
	<PaymentInfo PaymentType=\"5\">
	<CreditCardInfo CardType=\"1\" CardCode=\"$CreditCardCode\" CardNumber=\"$CreditCardNumber\" SeriesCode=\"$CreditSeriesCode\" ExpireDate=\"$CreditExpireDate\"/>
	";
			break;
	
		case 6:
			$request .= "
	<PaymentInfo PaymentType=\"6\">
	<CreditCardInfo CardType=\"1\" CardCode=\"$DebitCardCode\" CardNumber=\"$DebitCardNumber\" SeriesCode=\"$DebitSeriesCode\" />
	";
			break;
	
		case 34:
			$request .= "
	<PaymentInfo PaymentType=\"34\" InvoiceCode=\"$InvoiceCode\">
	";
			break;
		case 37:
			$request .= "
	<PaymentInfo PaymentType=\"37\" MiscellaneousCode=\"$MiscellaneousCode\" Text=\"$Text\">
	";
			break;
		case 1:
			$request .= "
	<PaymentInfo PaymentType=\"1\">
	";
			break;
	}
	$request .= "<ValueAddedTax VAT=\"$VAT\"/>
	</PaymentInfo>
        <Endorsement Info=\"$Endorsement\"/>
         
	
	</DemandTicketDetail>
</KIU_AirDemandTicketRQ>";

$this->Connection();
$response = $this->SendMessage($request);
if($this->ErrorCode!=0)$response="<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";
$array=array();
$array[]=simplexml_load_string($response);
$array[]=htmlspecialchars($request,ENT_QUOTES);
$array[]=htmlspecialchars($response,ENT_QUOTES);
return $array;
//return simplexml_load_string($response);
//return $request;
}




public function Model_TravelItineraryReadRQ($args)
{
$default = array ( 'IdReserva' => '', 'IdTicket' => '','Email'=>'');
extract( array_merge($default, $args) );
$request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<KIU_TravelItineraryReadRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
	<POS>
		<Source AgentSine=\"$this->Sine\" TerminalID=\"$this->Device\"></Source>
	</POS>";
         if($IdReserva!=''){
           $request .= " <UniqueID Type=\"14\" ID=\"$IdReserva\"></UniqueID>"; 
         }  
         if($IdTicket!=''){
           $request .= " <UniqueID Type=\"30\" ID=\"$IdTicket\"></UniqueID>";  
         } 
         if($Email!=''){
           $request .= "<Verification>
                            <Email>$Email</Email> 
                        </Verification>";  
         }  
         if($IdTicket!='' && $IdReserva=='' && $Email==''){
             $request .= "<Ticketing TicketTimeLimit=\"1\" />";
         }
$request .= "</KIU_TravelItineraryReadRQ>";
/*<UniqueID Type=\"14\" ID=\"$IdReserva\"></UniqueID> */
$this->Connection();
$response = $this->SendMessage($request);
if($this->ErrorCode!=0)$response="<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";

if($IdTicket!='' && $CodReserva=='' && $Email==''){ 
    return simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
}else{
    return simplexml_load_string($response);
}
//return simplexml_load_string($response);

}


public function Model_AirCancelRQ($args)
{
$default = array ( "IdReserva" => "", "IdTicket"=> "");
extract( array_merge($default, $args) );
$request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                  <KIU_CancelRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
                        <POS>
                            <Source AgentSine=\"$this->Sine\" TerminalID=\"$this->Device\" ></Source>
                        </POS>";
    $request.="<UniqueID Type=\"14\" ID=\"$IdReserva\" ></UniqueID>";
if($IdTicket!=''){
     $request.="<UniqueID Type=\"30\" ID=\"$IdTicket\" ></UniqueID>";  
}
              
$request.="<Ticketing TicketTimeLimit=\"1\" />";
$request.="</KIU_CancelRQ>";

$this->Connection();
$response = $this->SendMessage($request);
if($this->ErrorCode!=0) $response="<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";
//return simplexml_load_string($response);
$array=array();
$array[]=simplexml_load_string($response);
$array[]=htmlspecialchars($request,ENT_QUOTES);
$array[]=htmlspecialchars($response,ENT_QUOTES);
return $array[0];

}

public function Model_AirRulesRQ($args)
{
$default = array ( "FareNumber" => "", "FareBase"=> "", "Airline"=> "", "Origen"=> "", "Destino"=> "", "Fecha"=> "");
extract( array_merge($default, $args) );
$request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                  <KIU_AirRulesRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
                        <POS>
                            <Source AgentSine=\"$this->Sine\" TerminalID=\"$this->Device\" ></Source>
                        </POS>
              <RuleReqInfo FareNumber=\"$FareNumber\">
                <FareReference>$FareBase</FareReference>
                <MarketingAirline Code=\"$Airline\" />
                <DepartureAirport LocationCode=\"$Origen\" />
                <ArrivalAirport LocationCode=\"$Destino\" /> 
                <DepartureDate>$Fecha</DepartureDate>
              </RuleReqInfo>";
        $request.="</KIU_AirRulesRQ>";

$this->Connection();
$response = $this->SendMessage($request);
if($this->ErrorCode!=0) $response="<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";
return simplexml_load_string($response);

}

public function Model_AirFareDisplayRQ($args)
{
$default = array ( "Airline" => "", "Fecha"=> "", "Origen"=> "", "Destino"=> "");
extract( array_merge($default, $args) );
$request = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                  <KIU_AirRulesRQ EchoToken=\"$this->EchoToken\" TimeStamp=\"$this->TimeStamp\" Target=\"$this->Target\" Version=\"3.0\" SequenceNmbr=\"$this->SequenceNmbr\" PrimaryLangID=\"en-us\">
                        <POS>
                            <Source AgentSine=\"$this->Sine\" TerminalID=\"$this->Device\" ></Source>
                        </POS>
                        <SpecificFlightInfo>
                            <Airline Code=\"$Airline\"/>
                            </SpecificFlightInfo>
                            <OriginDestinationInformation>
                                <DepartureDateTime>$Fecha</DepartureDateTime>
                                <OriginLocation LocationCode=\"$Origen\" />
                                <DestinationLocation LocationCode=\"$Destino\" />
                            </OriginDestinationInformation> 
                            <TravelPreferences> 
                                <FareRestrictPref FareDisplayCurrency=\"USD\" />
                             </TravelPreferences>";
        $request.="</KIU_AirRulesRQ>";

$this->Connection();
$response = $this->SendMessage($request);
if($this->ErrorCode!=0) $response="<?xml version=\"1.0\" encoding=\"UTF-8\"?><Error></Error>";
return simplexml_load_string($response);

}

}
?>