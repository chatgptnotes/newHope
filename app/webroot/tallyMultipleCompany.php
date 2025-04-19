<?php
$xmlData='<ENVELOPE>
		<HEADER>
		<VERSION>1</VERSION>
		<TALLYREQUEST>Import</TALLYREQUEST>
		<TYPE>Data</TYPE>
		<ID>Vouchers</ID>
		</HEADER>
		<BODY>
		<DESC>
		<STATICVARIABLES>
		<IMPORTDUPS>@@DUPCOMBINE</IMPORTDUPS>
		<SVCURRENTCOMPANY>Hope Hospital</SVCURRENTCOMPANY>
		</STATICVARIABLES>
		</DESC>
		<DATA><TALLYMESSAGE xmlns:UDF="TallyUDF">
            <LEDGER NAME="CR FISTULAGRAM / SINUS TRACT STUDY" ACTION="Create">
             <NAME.LIST>
             <NAME>CR FISTULAGRAM / SINUS TRACT STUDY</NAME>
             </NAME.LIST>
             <PARENT>Cash-in-hand</PARENT>
             <ISBILLWISEON>No</ISBILLWISEON>
             <AFFECTSSTOCK>No</AFFECTSSTOCK>
             <OPENINGBALANCE>0</OPENINGBALANCE>
             <USEFORVAT>No </USEFORVAT>
             <TAXCLASSIFICATIONNAME/>
             <TAXTYPE/>
              <RATEOFTAXCALCULATION/>
              </LEDGER>
             </TALLYMESSAGE><TALLYMESSAGE xmlns:UDF="TallyUDF">
            <LEDGER NAME="Liquid Based Pap" ACTION="Create">
             <NAME.LIST>
             <NAME>Liquid Based Pap< /NAME>
             </NAME.LIST>
             <PARENT>Cash-in-hand</PARENT>
             <ISBILLWISEON>No</ISBILLWISEON>
             <AFFECTSSTOCK>No</AFFECTSSTOCK>
             <OPENINGBALANCE>0</OPENINGBALANCE>
             <USEFORVAT>No </USEFORVAT>
             <TAXCLASSIFICATIONNAME/>
             <TAXTYPE/>
              <RATEOFTAXCALCULATION/>
              </LEDGER>
             </TALLYMESSAGE><TALLYMESSAGE>
		<VOUCHER VCHTYPE="Sales" ACTION="Create">
		<DATE>20140930</DATE>
		<NARRATION>Test</NARRATION>
		<VOUCHERTYPENAME>Sales</VOUCHERTYPENAME>
		<VOUCHERNUMBER>123</VOUCHERNUMBER><ALLLEDGERENTRIES.LIST>
		      <LEDGERNAME>CR FISTULAGRAM / SINUS TRACT STUDY</LEDGERNAME>
		      <ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
		      <AMOUNT>200</AMOUNT>
		      </ALLLEDGERENTRIES.LIST><ALLLEDGERENTRIES.LIST>
		      <LEDGERNAME>Liquid Based Pap</LEDGERNAME>
		      <ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
		      <AMOUNT>200</AMOUNT>
		      </ALLLEDGERENTRIES.LIST><ALLLEDGERENTRIES.LIST>
		<LEDGERNAME>Hope Hospital</LEDGERNAME>
		<ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
		<AMOUNT>-200</AMOUNT>
		</ALLLEDGERENTRIES.LIST></VOUCHER>
		</TALLYMESSAGE></DATA></BODY></ENVELOPE>';


$url="http://localhost:9002";
$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
// Following line is compulsary to add as it is:
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    "xmlRequest=" . $xmlData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        $data = curl_exec($ch);
        curl_close($ch);

        //convert the XML result into array
        $array_data = json_decode(json_encode(simplexml_load_string($data)), true);

        print_r('<pre>');
        print_r($array_data);
        print_r('</pre>');

//post into other company DrmHopeNew

$xmlDataNew='<ENVELOPE>
	<HEADER>
		<VERSION>1</VERSION>
		<TALLYREQUEST>Import</TALLYREQUEST>
		<TYPE>Data</TYPE>
		<ID>Vouchers</ID>
	</HEADER>
	<BODY>
		<DESC>
			<STATICVARIABLES>
  				 <IMPORTDUPS>@@DUPCOMBINE</IMPORTDUPS>
				 <SVCURRENTCOMPANY>DrmHopenew</SVCURRENTCOMPANY>
 		     	</STATICVARIABLES>
		</DESC>
		<DATA>

		<!-- Create Ledger named "Accomodation Charges" if it does not exist -->
            <TALLYMESSAGE xmlns:UDF="TallyUDF">
            <LEDGER NAME="Accomodation Charges" ACTION="Create">
             <NAME.LIST>
             <NAME>Accomodation Charges</NAME>
             </NAME.LIST>
             <PARENT>Cash-in-hand</PARENT>
             <ISBILLWISEON>No</ISBILLWISEON>
             <AFFECTSSTOCK>No</AFFECTSSTOCK>
             <OPENINGBALANCE>0</OPENINGBALANCE>
             <USEFORVAT>No </USEFORVAT>
             <TAXCLASSIFICATIONNAME/>
             <TAXTYPE/>
              <RATEOFTAXCALCULATION/>
              </LEDGER>
             </TALLYMESSAGE>

			 <!-- Create Ledger named "Registration Charges" if it does not exist -->
            <TALLYMESSAGE xmlns:UDF="TallyUDF">
            <LEDGER NAME="Registration Charges" ACTION="Create">
             <NAME.LIST>
             <NAME>Registration Charges</NAME>
             </NAME.LIST>
             <PARENT>Cash-in-hand</PARENT>
             <ISBILLWISEON>No</ISBILLWISEON>
             <AFFECTSSTOCK>No</AFFECTSSTOCK>
             <OPENINGBALANCE>0</OPENINGBALANCE>
             <USEFORVAT>No </USEFORVAT>
             <TAXCLASSIFICATIONNAME/>
             <TAXTYPE/>
              <RATEOFTAXCALCULATION/>
              </LEDGER>
             </TALLYMESSAGE>
			 
			  <!-- Create Ledger named "Hope Hospital" if it does not exist -->
            <TALLYMESSAGE xmlns:UDF="TallyUDF">
            <LEDGER NAME="Hope Hospital" ACTION="Create">
             <NAME.LIST>
             <NAME>Hope Hospital</NAME>
             </NAME.LIST>
             <PARENT>Cash-in-hand</PARENT>
             <ISBILLWISEON>No</ISBILLWISEON>
             <AFFECTSSTOCK>No</AFFECTSSTOCK>
             <OPENINGBALANCE>0</OPENINGBALANCE>
             <USEFORVAT>No </USEFORVAT>
             <TAXCLASSIFICATIONNAME/>
             <TAXTYPE/>
              <RATEOFTAXCALCULATION/>
              </LEDGER>
             </TALLYMESSAGE>

			 <!-- Create sales voucher -->
			<TALLYMESSAGE>
				<VOUCHER VCHTYPE="Sales" ACTION="Create">
					<DATE>20140925</DATE>
					<NARRATION>Sales Voucher for company DrmHopenew</NARRATION>
					<VOUCHERTYPENAME>Sales</VOUCHERTYPENAME>
					<VOUCHERNUMBER>1</VOUCHERNUMBER>
					<ALLLEDGERENTRIES.LIST>
						<LEDGERNAME>Accomodation Charges</LEDGERNAME>
						<ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
						<AMOUNT>2000.00</AMOUNT>
					</ALLLEDGERENTRIES.LIST>
					<ALLLEDGERENTRIES.LIST>
						<LEDGERNAME>Registration Charges</LEDGERNAME>
						<ISDEEMEDPOSITIVE>Yes</ISDEEMEDPOSITIVE>
						<AMOUNT>500.00</AMOUNT>
					</ALLLEDGERENTRIES.LIST>

					<ALLLEDGERENTRIES.LIST>
						<LEDGERNAME>Hope Hospital</LEDGERNAME>
						<ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>
						<AMOUNT>-2500.00</AMOUNT>
					</ALLLEDGERENTRIES.LIST>
				</VOUCHER>
				
			</TALLYMESSAGE>

					
		</DATA>
	</BODY>
</ENVELOPE>';

$chNew = curl_init();
        curl_setopt($chNew, CURLOPT_URL, $url);
// Following line is compulsary to add as it is:
        curl_setopt($chNew, CURLOPT_POSTFIELDS,
                    "xmlRequest=" . $xmlDataNew);
        curl_setopt($chNew, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($chNew, CURLOPT_CONNECTTIMEOUT, 300);
        $dataNew = curl_exec($chNew);
        curl_close($chNew);

        //convert the XML result into array
        $array_dataNew = json_decode(json_encode(simplexml_load_string($dataNew)), true);
		 print_r('<pre>');
        print_r($array_dataNew);
        print_r('</pre>');
?>