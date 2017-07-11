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

?>