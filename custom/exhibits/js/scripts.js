function ValidateBefore(){
        //window.open('../../../custom/exhibits/exhibit_add_tip.php','mywindow','width=500,height=300')
		window.open('http://' + window.location.hostname + '/natural_europe/custom/exhibits/exhibit_add_tip.php','mywindow','width=500,height=300')

}

function AddToTiny(item_title){
    var selected_text = tinyMCE.activeEditor.selection.getContent();
    var add_text= '<a id ="' + item_title +'" onclick="getItemInfo(this)" href="javascript:void(0);">' + selected_text + '</a> ';    
    tinyMCE.activeEditor.selection.setContent(add_text);
}

function CallParent(){
    var item_title = $("#item_title_hid").val();
    
    if ( $("#select_item").selectedTexts() == "Choose an Item" ){
        alert("You have not selected an item!");        
    }
    else{
        if ( item_title.length < 1 ){
            item_title = $("#select_item").selectedTexts();
        }
        window.close();
		window.opener.document.getElementById('text_supporting').innerHTML += '<br>'+item_title;
						 
    }
}





function ValidateBefore2(){
    var selected_text = tinyMCE.activeEditor.selection.getContent();
    if ( selected_text.length >0 ){
        window.open('../../../custom/exhibits/exhibit_add_video.php','mywindow','width=500,height=300')
    }
    else{
        alert("You have not selected a text!");
    }
}

function ValidateBefore3(){
    var selected_text = tinyMCE.activeEditor.selection.getContent();
    if ( selected_text.length >0 ){
        window.open('../../../custom/exhibits/exhibit_add_exhibit.php','mywindow','width=500,height=300')
    }
    else{
        alert("You have not selected a text!");
    }
}

function CallParent3(){
	var myString = $("#select_item").val();

    var mySplitResult = myString.split(";");

    var item_title = mySplitResult[0];
	var item_slug = mySplitResult[1];
	var item_group = mySplitResult[2];

    
    if ( $("#select_item").selectedTexts() == "Choose an Item" ){
        alert("You have not selected an item!");        
    }
    else{
        if ( item_title.length < 1 ){
            item_title = $("#select_item").selectedTexts();
        }
        
        window.close();
        opener.AddToTiny3(item_title,item_slug,item_group);
    }
}

function AddToTiny3(item_title,item_slug,item_group){
    var selected_text = tinyMCE.activeEditor.selection.getContent();
	if(item_group=="Students"){
		var add_text= '<a title="exhibit" id ="' + item_title +'"  href="/natural_europe/exhibits/'+item_slug+'/to-begin-with?target=students">' + selected_text + '</a> ';  
    tinyMCE.activeEditor.selection.setContent(add_text);
	}
	else{
		var add_text= '<a title="exhibit" id ="' + item_title +'"  href="/natural_europe/exhibits/'+item_slug+'/to-begin-with">' + selected_text + '</a> ';  
    tinyMCE.activeEditor.selection.setContent(add_text);
	}
    
}


function ValidateItem(){
    var selected_text = tinyMCE.activeEditor.selection.getContent();
    if ( selected_text.length >0 ){
        window.open('../../custom/exhibits/exhibit_add_video.php','mywindow','width=500,height=300')
    }
    else{
        alert("You have not selected a text!");
    }
}

function ValidateEditItem(){
    var selected_text = tinyMCE.activeEditor.selection.getContent();
    if ( selected_text.length >0 ){
        window.open('../../../custom/exhibits/exhibit_add_video.php','mywindow','width=500,height=300')
    }
    else{
        alert("You have not selected a text!");
    }
}

function CallParent2(){
    var item_title = $("#item_title_hid").val();
    var item_id = $("#item_title_id_hid").val();
    
    if ( $("#select_item").selectedTexts() == "Choose a Video" ){
        alert("You have not selected a video!");        
    }
    else{
        if ( item_id < 1 ){
            item_id = $("#select_item").selectedValues();
            item_title = $("#select_item").selectedTexts();
        }
        
        $.post('include/create_page.php', {title: item_title, item_id: item_id},    
            function(result) {
                if ( result == 1 ){
                    alert("No video has been found for this item (" + item_title + ")!");
                }
                else if ( result == 2 ){                
                    alert("An unexpected error occured. Please try again later!");
                }
                else if ( result == 3 ){                
                    alert("An unexpected error occured while creating the page. Please try again later!");
                }                
                else if ( result == 4 ){                    
                    $.post('include/set_caption.php', {item_id: item_id},    
                            function(response_caption) {
                                if ( response_caption == 1 ){                                    
                                    alert("An unexpected error occured while creating the page. Please try again later!");                                    
                                }
                                else if ( response_caption == 2 ){
                                    alert("The video has been successfully assigned to the selected term but no caption has been found for the selected video!");
                                    response_caption="";
                                    window.close();
                                    opener.AddToTiny2(item_id, response_caption);                                   
                                }
                                else{
                                    alert("The video has been successfully assigned to the selected term!");
                                    window.close();
                                    opener.AddToTiny2(item_id, response_caption);                                     
                                }
                            }
                    );
                }
                else{
                    alert("An unexpected error occured while creating the page. Please try again later!");
                }
            }
        );
    }
}

function CallParentvideo(){
    var item_title = $("#item_title_hid").val();
    var item_id = $("#item_title_id_hid").val();
	var video_name = $("#video_name").val();
	var video_name_rights = $("#video_name_rights").val();
    
    if ( $("#select_item").selectedTexts() == "Choose a Video" ){
        alert("You have not selected a video!");        
    }
    else{
        if ( item_id < 1 ){
            item_id = $("#select_item").selectedValues();
            item_title = $("#select_item").selectedTexts();
        }
        
	}
	


$.post('include/set_filename.php', {item_id: item_id},    
                            function(video_name) {
								
							
                                if ( video_name == 1 ){     
                                    
									
                                }
                               
                                else{
                                              $.post('include/set_caption.php', {item_id: item_id},    
                            function(response_caption) {
							
                                if ( response_caption == 1 ){                                    
                                    alert("An unexpected error occured while creating the page. Please try again later!");                                    
                                }
                                else if ( response_caption == 2 ){
									$.post('include/set_video_dimensions.php', {item_id: item_id},function(file_analysis) {
																												   

                                    alert("The video has been successfully assigned to the selected term but no caption has been found for the selected video!");
                                    response_caption="";
                                    window.close();
                                    opener.AddToTinyvideo(item_id, response_caption);    
								});
								
                                }
                                else{
									$.post('include/set_video_dimensions.php', {item_id: item_id},function(file_analysis) {
								   
								   
								    alert("The video has been successfully assigned to the selected term!");
                                    window.close();
                                    opener.AddToTinyvideo(item_id, response_caption);       																		   
																										   
																										   
								
								
								});

                                                                
                                }
                            }
                    );
                                                                      
                                }
                            }
                    );

	
	
}

function AddToTinyvideo(item_id, item_caption){
    
 var html_file = "videopage.php?video_name=" + item_id + "";
    var selected_text = tinyMCE.activeEditor.selection.getContent();
    var add_text= '<a class="lightview" title="::' + item_caption + '::width: 958,height:600" href="http://'+location.host+'/natural_europe/custom/exhibits/include/' + html_file + '">' + selected_text + '</a> ';    
    tinyMCE.activeEditor.selection.setContent(add_text);

}

function AddToTinyvideoswf(video_name, item_caption){
    
 var html_file = "" + video_name + "";
    var selected_text = tinyMCE.activeEditor.selection.getContent();
    
    var add_text= '<a class="lightview" title="::' + item_caption + ':: width: 520, height: 540" href="http://'+location.host+'/natural_europe/archive/files/' + html_file + '">' + selected_text + '</a> ';    
    tinyMCE.activeEditor.selection.setContent(add_text);

}

function AddToTiny2(item_id, item_caption){
    
    var html_file = "video_" + item_id + ".html";
    var selected_text = tinyMCE.activeEditor.selection.getContent();
    
    var add_text= '<a class="lightview" title="' + item_caption + '" href="http://'+location.host+'/natural_europe/themes/eknownetv3/movies/' + html_file + '">' + selected_text + '</a> ';    
    tinyMCE.activeEditor.selection.setContent(add_text);
}



function Close(){
    window.close();
}