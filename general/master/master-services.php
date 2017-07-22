<?php 
	require('../dbconfig.php'); 

	$finaloutput = array();
	if(!$_POST) {
		$action = $_GET['action'];
	}
	else {
		$action = $_POST['action'];
	}
	switch($action){
		case 'get_types':
			$finaloutput = getTypes();
		break;
	    case 'add_type':
	        $finaloutput = addType();
	    break;
	    case 'edit_type':
	    	$finaloutput = editType();
	    break;
	    case 'del_type':
	    	$finaloutput = deleteType();
	    break;
	    case 'get_items':
	    	$finaloutput = getItems();
	    break;
	    case 'add_item':
	    	$finaloutput = addItem();
	    break;
	    case 'edit_item':
	    	$finaloutput = editItem();
	    break;
	    case 'del_item':
	    	$finaloutput = deleteItem();
	    break;
	    case 'get_tariffs':
	    	$finaloutput = getTariffs();
	    break;
	    case 'edit_tariff':
	    	$finaloutput = editTariff();
	    break;
	    case 'del_tariff':
	    	$finaloutput = deleteTariff();
	    break;
	    case 'add_tariff':
	    	$finaloutput = addTariff();
	    break;
	    case 'add_party':
	    	$finaloutput = addParty();
	    break;
	    case 'edit_party':
	    	$finaloutput = editParty();
	    break;
	    case 'del_party':
	    	$finaloutput = deleteParty();
	    break;
	    default:
	        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
	}

	echo json_encode($finaloutput);

	function getTypes(){
		global $dbc;
		$query = "SELECT * FROM type_master";
		$result = mysqli_query($dbc, $query);
		//file_put_contents("querylog.log", print_r( $row, true ));
		$out = array();
		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				$out[] = $row;
			}
			return array('infocode' => 'success', 'data' => $out);
		} else {
			return array('infocode' => 'failure');
		}
	}

	function addType(){
		global $dbc;
		$typeName = mysqli_real_escape_string($dbc, trim($_POST['type_name']));
		$query = "INSERT INTO type_master (type_name) VALUES ('$typeName')";
		if(mysqli_query($dbc, $query)){
			return array('infocode' => 'success');
		} else {
			return array('infocode' => 'failure');
		}
	}

	function editType(){
		global $dbc;
		$typeName = mysqli_real_escape_string($dbc, trim($_POST['type_name']));
		$typeId = mysqli_real_escape_string($dbc, trim($_POST['type_id']));
		$query = "UPDATE type_master SET type_name='$typeName' WHERE type_id='$typeId'";
		if(mysqli_query($dbc, $query)){
			return array('infocode' => 'success');
		} else {
			return array('infocode' => 'failure');
		}
	}

	function  deleteType(){
		global $dbc;
		$typeId = mysqli_real_escape_string($dbc, trim($_POST['type_id']));
		$query = "DELETE FROM type_master WHERE type_id='$typeId'";
		if(mysqli_query($dbc, $query)){
			return array('infocode' => 'success');
		} else {
			return array('infocode' => 'failure');
		}
	}

	function getItems(){
		global $dbc;
		$query = "SELECT im.item_master_id, im.item_name, tm.type_name, tm.type_id FROM item_master im, type_master tm WHERE im.type_id=tm.type_id";
		$result = mysqli_query($dbc, $query);
		$out = array();
		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				$out[] = $row;
			}
			return array('infocode' => 'success', 'data' => $out);
		} else {
			return array('infocode' => 'failure');
		}
	}

	function addItem(){
		global $dbc;
		$itemName = mysqli_real_escape_string($dbc, trim($_POST['item_name']));
		$itemTypeId = mysqli_real_escape_string($dbc, trim($_POST['item_type']));
		$query = "INSERT INTO item_master (item_name, type_id) VALUES ('$itemName', '$itemTypeId')";
		if(mysqli_query($dbc, $query)){
			return array('infocode' => 'success');
		} else {
			return array('infocode' => 'failure');
		}
	}

	function editItem(){
		global $dbc;
		$itemId = mysqli_real_escape_string($dbc, trim($_POST['item_id']));
		$itemName = mysqli_real_escape_string($dbc, trim($_POST['item_name']));
		$itemTypeId = mysqli_real_escape_string($dbc, trim($_POST['item_type']));
		$query = "UPDATE item_master SET item_name='$itemName', type_id='$itemTypeId' WHERE item_master_id='$itemId'";
		if(mysqli_query($dbc, $query)){
			return array('infocode' => 'success');
		} else {
			return array('infocode' => 'failure');
		}
	}

	function deleteItem(){
		global $dbc;
		$itemId = mysqli_real_escape_string($dbc, trim($_POST['item_id']));
		$query = "DELETE FROM item_master WHERE item_master_id='$itemId'";
		if(mysqli_query($dbc, $query)){
			return array('infocode' => 'success');
		} else {
			return array('infocode' => 'failure');
		}
	}

	function getTariffs(){
		global $dbc;
		$query = "SELECT * FROM tariff_master";
		$result = mysqli_query($dbc, $query);
		//file_put_contents("querylog.log", print_r( $row, true ));
		$out = array();
		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				$out[] = $row;
			}
			return array('infocode' => 'success', 'data' => $out);
		} else {
			return array('infocode' => 'failure');
		}
	}

	function addTariff(){
		global $dbc;
		$serviceName = mysqli_real_escape_string($dbc, trim($_POST['service_name']));
		$serviceType = mysqli_real_escape_string($dbc, trim($_POST['service_type']));
		$storageUnit = mysqli_real_escape_string($dbc, trim($_POST['storage_unit']));
		$baseTariff = mysqli_real_escape_string($dbc, trim($_POST['rate']));
		$query = "INSERT INTO tariff_master (service_name, service_type, storage_unit, base_tariff) VALUES ('$serviceName', '$serviceType', '$storageUnit', '$baseTariff')";
		//file_put_contents("querylog.log", print_r( $query, true ));

		if(mysqli_query($dbc, $query)){
			return array('infocode' => 'success');
		} else {
			return array('infocode' => 'failure');
		}
	}

	function editTariff(){
		global $dbc;
		$tariffMasterId = mysqli_real_escape_string($dbc, trim($_POST['tariff_id_hidden']));
		$serviceName = mysqli_real_escape_string($dbc, trim($_POST['edit_service_name']));
		$serviceType = mysqli_real_escape_string($dbc, trim($_POST['edit_service_type']));
		$storageUnit = mysqli_real_escape_string($dbc, trim($_POST['edit_storage_unit']));
		$baseTariff = mysqli_real_escape_string($dbc, trim($_POST['edit_rate']));
		$query = "UPDATE tariff_master SET service_name='$serviceName', service_type='$serviceType', storage_unit='$storageUnit', base_tariff='$baseTariff' WHERE tariff_master_id='$tariffMasterId'";
		//file_put_contents("querylog.log", print_r( $query, true ));

		if(mysqli_query($dbc, $query)){
			return array('infocode' => 'success');
		} else {
			return array('infocode' => 'failure');
		}
	}

	function deleteTariff(){
		global $dbc;
		$tariffMasterId = mysqli_real_escape_string($dbc, trim($_POST['tariff_id']));
		$query = "DELETE FROM tariff_master WHERE tariff_master_id='$tariffMasterId'";
		if(mysqli_query($dbc, $query)){
			return array('infocode' => 'success');
		} else {
			return array('infocode' => 'failure');
		}
	}

	function addParty(){
		global $dbc;
		$pm_uuid = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)).'-'.time();
		$pm_customerName = mysqli_real_escape_string($dbc, trim($_POST['pm_customerName']));
		$pm_type = mysqli_real_escape_string($dbc, trim($_POST['partytype']));
		$pm_subtype = mysqli_real_escape_string($dbc, trim($_POST['partytype_sp']));
		$pm_address1 = mysqli_real_escape_string($dbc,trim($_POST['pm_address1']));
		$pm_address2 = mysqli_real_escape_string($dbc,trim($_POST['pm_address2']));
		$pm_cityTown = mysqli_real_escape_string($dbc,trim($_POST['pm_cityTown']));
		$pm_state = mysqli_real_escape_string($dbc,trim($_POST['pm_state']));
		$pm_pin = mysqli_real_escape_string($dbc,trim($_POST['pm_pin']));
		$pm_landline = mysqli_real_escape_string($dbc,trim($_POST['pm_landline']));
		$pm_fax = mysqli_real_escape_string($dbc,trim($_POST['pm_fax']));
		$pm_sales = mysqli_real_escape_string($dbc,trim($_POST['pm_sales']));
		$pm_servicesTax = mysqli_real_escape_string($dbc,trim($_POST['pm_servicesTax']));
		$pm_licence = mysqli_real_escape_string($dbc,trim($_POST['pm_licence']));
		$pm_tan = mysqli_real_escape_string($dbc,trim($_POST['pm_tan']));
		$pm_pan = mysqli_real_escape_string($dbc,trim($_POST['pm_pan']));
		//$pm_doc = mysqli_real_escape_string($dbc,trim($_POST['pm_doc']));
		//$pm_sd = mysqli_real_escape_string($dbc,trim($_POST['pm_sd']));
		$pm_inactive = mysqli_real_escape_string($dbc,trim($_POST['pm_inactive']));
		$pm_primaryContact = mysqli_real_escape_string($dbc,trim($_POST['pm_primaryContact']));
		$pm_primaryContactMobile = mysqli_real_escape_string($dbc,trim($_POST['pm_primaryContactMobile']));
		$pm_primaryContactEmail = mysqli_real_escape_string($dbc,trim($_POST['pm_primaryContactEmail']));
		$pm_secondaryContact = mysqli_real_escape_string($dbc,trim($_POST['pm_secondaryContact']));
		$pm_secondaryContactMobile = mysqli_real_escape_string($dbc,trim($_POST['pm_secondaryContactMobile']));
		$pm_secondaryContactEmail = mysqli_real_escape_string($dbc,trim($_POST['pm_secondaryContactEmail']));
		$pm_tertiaryContact = mysqli_real_escape_string($dbc,trim($_POST['pm_tertiaryContact']));
		$pm_tertiaryContactMobile = mysqli_real_escape_string($dbc,trim($_POST['pm_tertiaryContactMobile']));
		$pm_tertiaryContactEmail = mysqli_real_escape_string($dbc,trim($_POST['pm_tertiaryContactEmail']));
		$pm_ccd = mysqli_real_escape_string($dbc,trim($_POST['pm_ccd']));
		$pm_ccLimit = mysqli_real_escape_string($dbc,trim($_POST['pm_ccLimit']));
		$pm_ccBalance = mysqli_real_escape_string($dbc,trim($_POST['pm_ccBalance']));
		$query1 = "SELECT * FROM party_master WHERE pm_customerName = '$pm_customerName'";
		$result1 = mysqli_query($dbc,$query1);
		if(mysqli_num_rows($result1)>0){
			$output = array("infocode" => "CUSTOMEREXIST", "message" => "Customer Name already exists, please choose a different name!");
		}else{
			$query = "INSERT INTO party_master(pm_uuid,pm_customerName,pm_type,pm_subtype,pm_address1,pm_address2,pm_cityTown,pm_state,pm_pin,pm_landline,pm_fax,pm_sales,pm_servicesTax,pm_licence,pm_tan,pm_pan,pm_inactive,pm_primaryContact,pm_primaryContactMobile,pm_primaryContactEmail,pm_secondaryContact,pm_secondaryContactMobile,pm_secondaryContactEmail,pm_tertiaryContact,pm_tertiaryContactMobile,pm_tertiaryContactEmail,pm_ccd,pm_ccLimit,pm_ccBalance) VALUES('$pm_uuid','$pm_customerName','$pm_type','$pm_subtype','$pm_address1','$pm_address2','$pm_cityTown','$pm_state','$pm_pin','$pm_landline','$pm_fax','$pm_sales','$pm_servicesTax','$pm_licence','$pm_tan','$pm_pan','$pm_inactive','$pm_primaryContact','$pm_primaryContactMobile','$pm_primaryContactEmail','$pm_secondaryContact','$pm_secondaryContactMobile','$pm_secondaryContactEmail','$pm_tertiaryContact','$pm_tertiaryContactMobile','$pm_tertiaryContactEmail','$pm_ccd','$pm_ccLimit','$pm_ccBalance')";
			//file_put_contents("querylog.log", print_r(json_encode($query), true ));
			$result = mysqli_query($dbc,$query);
			if($result) {
				$output = array("infocode" => "INSERTSUCCESSFULLY", "message" => "Inserted Successfully");
			}
			else {
				$output = array("infocode" => "UNSUCCESSFULL", "message" => "Something went worng");
			}
		}

		return $output;
	}

	function editParty(){
		global $dbc;
		$pmId = $_POST['pm_id'];
		$pm_customerName = mysqli_real_escape_string($dbc, trim($_POST['pm_customerName']));
		$pm_address1 = mysqli_real_escape_string($dbc,trim($_POST['pm_address1']));
		$pm_address2 = mysqli_real_escape_string($dbc,trim($_POST['pm_address2']));
		$pm_cityTown = mysqli_real_escape_string($dbc,trim($_POST['pm_cityTown']));
		$pm_state = mysqli_real_escape_string($dbc,trim($_POST['pm_state']));
		$pm_pin = mysqli_real_escape_string($dbc,trim($_POST['pm_pin']));
		$pm_landline = mysqli_real_escape_string($dbc,trim($_POST['pm_landline']));
		$pm_fax = mysqli_real_escape_string($dbc,trim($_POST['pm_fax']));
		$pm_sales = mysqli_real_escape_string($dbc,trim($_POST['pm_sales']));
		$pm_servicesTax = mysqli_real_escape_string($dbc,trim($_POST['pm_servicesTax']));
		$pm_licence = mysqli_real_escape_string($dbc,trim($_POST['pm_licence']));
		$pm_tan = mysqli_real_escape_string($dbc,trim($_POST['pm_tan']));
		$pm_pan = mysqli_real_escape_string($dbc,trim($_POST['pm_pan']));
		//$pm_doc = mysqli_real_escape_string($dbc,trim($_POST['pm_doc']));
		//$pm_sd = mysqli_real_escape_string($dbc,trim($_POST['pm_sd']));
		$pm_inactive = mysqli_real_escape_string($dbc,trim($_POST['pm_inactive']));
		$pm_primaryContact = mysqli_real_escape_string($dbc,trim($_POST['pm_primaryContact']));
		$pm_primaryContactMobile = mysqli_real_escape_string($dbc,trim($_POST['pm_primaryContactMobile']));
		$pm_primaryContactEmail = mysqli_real_escape_string($dbc,trim($_POST['pm_primaryContactEmail']));
		$pm_secondaryContact = mysqli_real_escape_string($dbc,trim($_POST['pm_secondaryContact']));
		$pm_secondaryContactMobile = mysqli_real_escape_string($dbc,trim($_POST['pm_secondaryContactMobile']));
		$pm_secondaryContactEmail = mysqli_real_escape_string($dbc,trim($_POST['pm_secondaryContactEmail']));
		$pm_tertiaryContact = mysqli_real_escape_string($dbc,trim($_POST['pm_tertiaryContact']));
		$pm_tertiaryContactMobile = mysqli_real_escape_string($dbc,trim($_POST['pm_tertiaryContactMobile']));
		$pm_tertiaryContactEmail = mysqli_real_escape_string($dbc,trim($_POST['pm_tertiaryContactEmail']));
		$pm_ccd = mysqli_real_escape_string($dbc,trim($_POST['pm_ccd']));
		$pm_ccLimit = mysqli_real_escape_string($dbc,trim($_POST['pm_ccLimit']));
		$pm_ccBalance = mysqli_real_escape_string($dbc,trim($_POST['pm_ccBalance']));

		//Query
		$query = "UPDATE party_master SET pm_customerName = '$pm_customerName',pm_address1 = '$pm_address1',pm_address2 = '$pm_address2',pm_cityTown = '$pm_cityTown',pm_state = '$pm_state',pm_pin = '$pm_pin',pm_landline = '$pm_landline', pm_fax = '$pm_fax', pm_sales = '$pm_sales', pm_servicesTax = '$pm_servicesTax', pm_licence = '$pm_licence' , pm_tan = '$pm_tan' ,pm_pan = '$pm_pan', pm_inactive = '$pm_inactive', pm_primaryContact = '$pm_primaryContact',pm_primaryContactMobile = '$pm_primaryContactMobile', pm_primaryContactEmail = '$pm_primaryContactEmail',pm_secondaryContact = '$pm_secondaryContact', pm_secondaryContactMobile = '$pm_secondaryContactMobile',pm_secondaryContactEmail = '$pm_secondaryContactEmail', pm_tertiaryContact = '$pm_tertiaryContact',pm_tertiaryContactMobile = '$pm_tertiaryContactMobile', pm_tertiaryContactEmail = '$pm_tertiaryContactEmail', pm_ccd = '$pm_ccd', pm_ccLimit = '$pm_ccLimit', pm_ccBalance = '$pm_ccBalance' WHERE  pm_id = '$pmId'";
		$result = mysqli_query($dbc,$query);
		if($result) {
			$output = array("infocode" => "SUCCESS", "message" => "Updated Successfully");
		}
		else {
			$output = array("infocode" => "UNSUCCESSFULL", "message" => "Something went worng");
		}

		return $output;
	}

	function deleteParty() {
	    global $dbc;
	    $pmId = mysqli_real_escape_string($dbc, trim($_POST['pm_id']));
	    $query = "UPDATE party_master SET pm_active_status = 'NO' WHERE pm_id = '$pmId'";
	    $result = mysqli_query($dbc,$query);
		if($result) {
			$output = array("infocode" => "SUCCESS", "message" => "Deleted Successfully");
		}
		else {
			$output = array("infocode" => "UNSUCCESSFULL", "message" => "Something went worng");
		}
		return $output;
	}

?>