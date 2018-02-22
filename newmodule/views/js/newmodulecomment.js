 $(document).ready(function(){

 if ($('#newmodulecomments-content-tab').attr('data-scroll') == 'true')
	 $.scrollTo('#newmodulecomments-content-tab', 1200);
   $("#show").css("display" , "none");
$('#comments_toggle').click(function(){
        $("#show").slideDown("slow");
    });
 });
