var gContainerList = new Array;
var g_rowcount=2;
var g_snocount=2;
var additem_template = '<tr id="[trid]"><td><span class="td_sno">[sno]</span></td>\
							<td><select class="form-control required" id="dimension" name="dimension[]"><option value="20 ft. Container">20 ft. Container</option><option value="40 ft. Container">40 ft. container</option><option value="Break Bulk ODC LCL">Break Bulk ODC LCL</option></select></td>\
							<td><input type="text" name="qty_numbers[]" placeholder="" class="form-control"></td>\
							<td><input type="text" name="container_weight[]" placeholder="" class="form-control"></td>\
							<td><input type="text" name="vehicle_number[]" placeholder="" class="form-control"></td>\
							<td><button onclick="addContainerRow([addcount])">+</button><button class="item_removebutton" onclick="removeContainerRow([removecount])">-</button></td></tr>';

function enableClientInsuranceFile(){
	$("#client_insurance_file_div").show();
}

function disableClientInsuranceFile(){
	$("#client_insurance_file_div").hide();
}

function enableClientInsuranceDeclararionFile(){
	$("#client_insurance_declaration_file_div").show();
}

function disableClientInsuranceDeclararionFile(){
	$("#client_insurance_declaration_file_div").hide();
}

function addContainerRow(rowcount){
	var addrow = additem_template.replace('[trid]','itemtr_'+g_rowcount)
								.replace('[sno]',g_snocount)
								.replace('[addcount]',g_rowcount)
								.replace('[removecount]',g_rowcount)
	$('#addcontainer_tbody').append(addrow);
	g_rowcount++;
	g_snocount++;
	$('.item_removebutton').show();
}

function removeContainerRow(rowcount){
	$('#itemtr_'+rowcount).remove();
	refreshSNoCount();
}

function refreshSNoCount(){
	var sillycount = 1;
	$('.td_sno').each(function(d){
		//console.log(d);
		$(this).html(sillycount++);
	});
	g_snocount = sillycount;
	if(sillycount<=2)
		$('.item_removebutton').hide();
}

(function($) {
  $.fn.serializefiles = function() {
      var obj = $(this);
      /* ADD FILE TO PARAM AJAX */
      var formData = new FormData();
      $.each($(obj).find("input[type='file']"), function(i, tag) {
          $.each($(tag)[0].files, function(i, file) {
              formData.append(tag.name, file);
          });
      });
      var params = $(obj).serializeArray();
      $.each(params, function (i, val) {
          formData.append(val.name, val.value);
      });
      return formData;
  };
})(jQuery);

function createPAR(){
	if($("#par-form").valid()){
		if(gContainerList.length == 0){
			bootbox.confirm('No containers added. You sure you want to continue?',function(result){
				if(result){
					confirmCreatePAR();
				}
			});
		} else {
			confirmCreatePAR();
		}
	}
}

function confirmCreatePAR(){
	$('#container_stringified').val(JSON.stringify(gContainerList));
	var data = $('#par-form').serializefiles();
	//alert(data);
	$.ajax({
		url: "par-services.php",
		type: "POST",
		data:  data,
		processData: false,
        contentType: false,
		dataType: 'json',
		success: function(data){
			bootbox.alert(data.message,function(){
				window.location='par-view.php';	
			});
			
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function updatePAR(parID){
	if($("#par-form").valid()){
		bootbox.confirm('You sure you want to update this Pre Arrival Request?',function(result){
			if(result){
				if(gContainerList.length == 0){
					bootbox.confirm('No containers added. You sure you want to continue?',function(result2){
						if(result2){
							confirmUpdatePAR(parID);
						}
					});
				} else {
					confirmUpdatePAR(parID);
				}
			}
		});		
	}
}

function confirmUpdatePAR(parID){
	//$('#container_stringified').val(JSON.stringify(gContainerList));
	var data = $('#par-form').serializefiles();
	//alert(data);
	$.ajax({
		url: "par-services.php",
		type: "POST",
		data:  data,
		processData: false,
        contentType: false,
		dataType: 'json',
		success: function(data){
			bootbox.alert(data.message,function(){
				if(isEditPage){
					window.location='par-view.php';
				} else {
					window.location='par-approve-reject-view.php';
				}
			});
			
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function approvePAR(parID){
	if($("#par-form").valid()){
		bootbox.confirm('You sure you want to approve this Pre Arrival Request?',function(result){
			if(result){
				if(gContainerList.length == 0){
					bootbox.confirm('No containers added. You sure you want to continue?',function(result2){
						if(result2){
							confirmApprovePAR(parID);
						}
					});
				} else {
					confirmApprovePAR(parID);
				}
			}
		});	
	}
}

function confirmApprovePAR(parID){
	$('#container_stringified').val(JSON.stringify(gContainerList));
	$('#status').val('approved');
	var data = $('#par-form').serializefiles();
	//alert(data);
	$.ajax({
		url: "par-services.php",
		type: "POST",
		data:  data,
		processData: false,
        contentType: false,
		dataType: 'json',
		success: function(data){
			bootbox.alert(data.message,function(){
				window.location='par-approve-reject-view.php';	
			});
			
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});
}

function rejectPAR(parID){
	if($("#par-form").valid()){
		bootbox.confirm('You sure you want to reject this Pre Arrival Request?',function(result){
			if(result){
				if(gContainerList.length == 0){
					bootbox.confirm('No containers added. You sure you want to continue?',function(result2){
						if(result2){
							confirmRejectPAR(parID);
						}
					});
				} else {
					confirmRejectPAR(parID);
				}
			}
		});		
	}
}

function confirmRejectPAR(parID){
	$('#container_stringified').val(JSON.stringify(gContainerList));
	$('#status').val('rejected');
	var data = $('#par-form').serializefiles();
	//alert(data);
	$.ajax({
		url: "par-services.php",
		type: "POST",
		data:  data,
		processData: false,
        contentType: false,
		dataType: 'json',
		success: function(data){
			bootbox.alert(data.message,function(){
				window.location='par-approve-reject-view.php';	
			});
			
		},
		error: function(){
			bootbox.alert("failure");
		} 	        
	});	
}



function addContainerItem(){
	if($('#containerlist_form').valid()){
		var containerItem = {};
		var containerDetail = new Array;
		dimension= $('#dimension').val().trim();
		containerCount= $('#container_count').val().trim();
		for(i = 1; i <= containerCount; i++){
			containerDetail.push($('#container_number_'+i).val().trim());
		}
		containerItem.dimension = dimension;
		containerItem.container_count = containerCount;
		containerItem.container_detail = convertArrayToJSON(containerDetail);
		gContainerList.push(containerItem);
		
		displayContainers();
		$('#containerlist_form')[0].reset();
		containerSpinner();	
	}
}

function convertArrayToJSON(container){
	var containerDetailJSON = new Array;
	container.forEach( function(element, index) {
		var containerDetail = {};
		containerDetail.container_number = element;
		containerDetail.status = 'not_picked';
		containerDetailJSON.push(containerDetail);
	});
	return containerDetailJSON;
}

function containerSpinner(){
	var count = $('#container_count').val().trim(); 
	var dp='';
	for(i=1;i<=count;i++){
		dp += '<div class="form-group"><div class="col-md-4"><input type="text" class="form-control required" name="container_number_'+i+'" id="container_number_'+i+'" placeholder="Container Number"/></div></div>';
	}

	$('#container_number_div').html(dp);
}

function displayContainers(){
	var dp='<br/>';
	
	if(gContainerList.length){
		for(q in gContainerList){
			dp += '<div class="panel panel-default"><div class="panel-heading" role="tab" id="headingtabc'+q+'"><h4 class="panel-title">\
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetabc'+q+'" aria-expanded="false" aria-controls="collapseOne">\
				'+gContainerList[q].dimension.replace('_',' to ')+' </a><span style<button</h4>\
				<span style="float:right;"><a href="javascript:deleteContainerItem(\''+q+'\');"><i class="fa fa-trash"></i></a></span> </div>\
				<div id="collapsetabc'+q+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtabc'+q+'">\
				<div class="panel-body">';
			dp+= '<div class="col-sm-4">Container Count : '+gContainerList[q].container_count+'</div>';
			//dp+= '<div class="col-sm-8">Container Numbers : '+gContainerList[q].container_detail.join(' , ')+'</div>';
			dp+= '<div class="col-sm-4">Container Numbers : ';

			gContainerList[q].container_detail.forEach( function(element, index) {
				dp += element.container_number;
				if(index !== gContainerList[q].container_detail.length - 1){
					dp += ', ';
				}
			});

			dp += '</div>'
			dp += '</div></div></div>';
		}
		$('#accordion_container').html(dp).show();
	}else{
		$('#accordion_container').hide();
	}
}

function displayContainersInEditMode(){
	var dp='<br/>';
	
	if(gContainerList.length){
		for(q in gContainerList){
			dp += '<div class="panel panel-default"><div class="panel-heading" role="tab" id="headingtabc'+q+'"><h4 class="panel-title">\
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetabc'+q+'" aria-expanded="false" aria-controls="collapseOne">\
				'+gContainerList[q].dimension.replace('_',' to ')+' </a></div>\
				<div id="collapsetabc'+q+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtabc'+q+'">\
				<div class="panel-body">';
			dp+= '<div class="col-sm-4">Container Count : '+gContainerList[q].container_count+'</div>';
			//dp+= '<div class="col-sm-8">Container Numbers : '+gContainerList[q].container_detail.join(' , ')+'</div>';
			dp+= '<div class="col-sm-4">Container Numbers : ';

			for(index = 0; index < Object.keys(gContainerList[q].container_details).length; index++){
				dp += (gContainerList[q].container_details)[index].container_number;
				if(index != Object.keys(gContainerList[q].container_details).length - 1){
					dp += ', ';
				}
			}

			dp += '</div>'
			dp += '</div></div></div>';
		}
		$('#accordion_container').html(dp).show();
	}else{
		$('#accordion_container').hide();
	}
}

function deleteContainerItem(arrayindex){
	bootbox.confirm('You sure you want to delete this detail?',function(result){
		if(result){
			gContainerList.splice(arrayindex,1);
			displayContainers();
		}
	});
}