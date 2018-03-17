function funcBefore() {
   $("#table_groups").text ('');
   $("#load_data").show();
}


function funcSuccessJSON(data){
   data = JSON.parse(data);

   //function sort by name
   function sortByName(a, b) {
     if (a.group_name > b.group_name) return 1;
     if (a.group_name < b.group_name) return -1;
   }
   
   $("#load_data").hide();

   $("#table_groups").text ('');
   var arr = [];
   if (data.length != 0) {
     for(var group in data)
       arr.push(data[group]);

     arr.sort(sortByName);
     for(var group in arr){
         $("#table_groups").append ('<tr><td><label class="custom-control custom-radio m-0" style="cursor: pointer;" >                                   <input onClick="setAccessLevel(0)"  name="level" type="radio" class="col-sm-9 custom-control-input" value="0"><span class="custom-control-indicator "  ></span><span class="custom-control-description ml-4"><b>'+arr[group].group_name +'</b></span></label></td></tr>');
     }
   }else{
     $("#table_groups").append('<tr id="not_found_block"></tr>');
     $("#not_found_block").append('<td><h4>Data not found!</h4></td>');
   }
}


function searchGroups(){
   var name_group = document.getElementById("input_name_group").value;
   var key = '';

   if(name_group != '') key = 'GROUP';
   else key = 'ALL';

   $.ajax ({
       url: "/site/schedule/php/search_groups.php",
       type: "POST",
       data: ({name_group: name_group, key: key}),
       dataType: "html",
       beforeSend: funcBefore,
       success: funcSuccessJSON
   });
}