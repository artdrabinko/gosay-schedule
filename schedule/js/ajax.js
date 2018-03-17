function funcBefore() {
   $("#table_groups").text ('');
   $("#table_groups").append('<tr id="load_data_block"></tr>');
   $("#load_data_block").append('<td><img src="./js/load.gif" width=60" height="60" alt=""></td>');
}


function funcSuccessJSON(data){
   data = JSON.parse(data);

   //function sort by name
   function sortByName(a, b) {
     if (a.group_name > b.group_name) return 1;
     if (a.group_name < b.group_name) return -1;
   }

   $("#table_groups").text ('');
   var arr = [];
   if (data.length != 0) {
     for(var group in data)
       arr.push(data[group]);

     arr.sort(sortByName);
     for(var group in arr){
       $("#table_groups").append ('<tr><td><h4>' + arr[group].group_name + '</h4></td> <td> <a class="btn btn-info" href="schedule.php?idgroup=' + arr[group].id + '&amp;subgroup=1">Подгруппа 1</a> <a class="btn btn-warning" href="schedule.php?idgroup=' + arr[group].id + '&amp;subgroup=2">Подгруппа 2</a></td></tr>');
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
