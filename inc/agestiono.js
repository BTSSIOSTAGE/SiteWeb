$(document).ready(function(){
    function init() {
        get_formations();
    }
    init();
    
    $(document).on('click', '.delete_data', function(){  
            var id = $(this).attr("id");
            console.log('[Console : Suppression formations id : '+id);
            var conf = confirm('Vous êtes sur le point de supprimé cette organisme , êtes vous en sûre ?');
            if(id > 0){
                $.post('./inc/fonction.php', { id: id, action : 'odeletetemp'}
                    , function(){
                        get_formations();
                        $('#msg').html('<div class="alert alert-success">Opération effectué</div>');
                    }); 
            } 
        });
        
    $(document).on('click', '.valide_data', function(){  
            var id = $(this).attr("id");
            console.log('[Console : Ajout formations temp id : '+id);
            var conf = confirm("Vous êtes sur le point d'ajouté cette organisme , êtes vous en sûre ?");
            if(id > 0){
                $.post('./inc/fonction.php', { id: id, action : 'oktempo'}
                    , function(){
                        get_formations();
                        $('#msg').html('<div class="alert alert-success">Opération effectué</div>');
                    }); 
            } 
        });
                  
	function get_formations() {
		$.ajax({		
		type : 'GET',
		url  : './inc/fonction.php?action=olisttemp',
		success : function(response){
		response = JSON.parse(response);
		var tr;
	      	$('#emp_body').html('');
	      	$.each(response, function( index, organisme ) {
	  tr = $('<tr/>');
	            tr.append("<td>" + organisme.temp_id+ "</td>");
	            tr.append("<td>" + organisme.name + "</td>");
	            tr.append("<td>" + organisme.rue1 + "</td>");
                    tr.append("<td>" + organisme.rue2 + "</td>");
                    tr.append("<td>" + organisme.libelleville +  " ("+organisme.cp_id+")</td>");
                    tr.append("<td>" + organisme.intituleadresse + "</td>");
                    tr.append("<td>" + organisme.email + "</td>");
                    tr.append("<td>" + organisme.telephone + "</td>");
                    
                    //
 
	            	var action = "<td><div class='btn-group' data-toggle='buttons'>";
                        action += "<a target='_blank' class='bouttonform button1 valide_data' id='"+organisme.temp_id+"'>Confirmer</a>";
	            	action += "<a target='_blank' class='bouttonform button3 delete_data' id='"+organisme.temp_id+"'>Supprimer</a>";
	            tr.append(action);
	            $('#emp_body').append(tr);
		});
		}
		});
	}
        

	
});

