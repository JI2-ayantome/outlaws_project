// /**
//  * 
//  * 
//  * 
//  */

// var currentItemId = 0;



// $("body").on("click", ".edit_menu_action", function(){

//     // retrieve corresponding object
//     var trTag = $(this).parents("tr");
//     var itemId = trTag.attr("data-id");
//     currentItemId = itemId;
//     var object = getCurrentObject();

//     $($(this).attr("data-target")).find("form").removeClass("add-data");
//     $($(this).attr("data-target")).find("form").addClass("update-data");
//     $($(this).attr("data-target")).find("form").attr("data-id", currentItemId);
//     fillModalFormFields(object);
// });

// function fillModalFormFields(object){

//     // fill the form's fields
//     console.log(object);

//     $("input[name='nom']").val(object.nom);
//     $("input[name='prenoms']").val(object.prenoms);
//     $("input[name='nommarital']").val(object.prenoms);
//     $("input[name='adresse']").val(object.adresse);
//     $("input[name='alias']").val(object.alias);
//     $("input[name='surnom']").val(object.surnom);
//     $("input[name='lieunaissance']").val(object.lieuNaissance);
//     $("input[name='datenaissance']").val(object.dateNaissance);
//     $("input[name='taille']").val(object.taille);
//     $("input[name='poids']").val(object.poids);
//     $("input[name='prénoms']").val(object.prenoms);
//     $("input[name='numerotelephone']").val(object.numeroTelephone);
//     $("textarea[name='observations']").val(object.observations);
//     $("input[name='numeropieceid']").val(object.numeroPieceId);
//     $("input[name='infractions']").val(object.mandats.mandat.infractions);
//     $("input[name='chambres']").val(object.mandats.mandat.chambres);
//     $("input[name='juridictions']").val(object.mandats.mandat.juridictions);
//     $("input[name='reference']").val(object.mandats.mandat.reference);

//     $("[name='typemandat'] option").attr("selected", false);
//     $("[name='typemandat']").find("option[value='"+object.mandats.mandat.typeMandat.libelle+"']").attr("selected", true);

//     $("[name='execute'] option").attr("selected", false);
//     $("[name='execute']").find("option[value='"+object.mandats.mandat.execute+"']").attr("selected", true);

//     $("[name='sexe'] option").attr("selected", false);
//     $("[name='sexe']").find("option[value='"+object.sexe+"']").attr("selected", true);

//     if (object.listeNationalites.length){
//         $("[name='nationalite'] option").attr("selected", false);
//         $("[name='nationalite']").find("option[value='"+(object.listeNationalites[0]).nationalite.libelle+"']").attr("selected", true);
//     }   
// }

// $("#btnSearch").click(function(){
//     var criteria = $("#criteriaSelectTag").val();
//     var criteriaValue = $("#searchInput").val();

//     fetchData(criteria, criteriaValue);
// });

// $("#btnInitiate").click(function(){
//     $("#searchInput").val("");
//     $("#criteriaSelectTag option[value='all']").attr("selected", true);

//     $("table tbody").empty();
// });

// $("body").on("click", ".delete_menu_action", function(){

//     var trTag = $(this).parents("tr");
//     var itemId = trTag.attr("data-id");
//     currentItemId = itemId;
//     var response = confirm("Voulez vous vraiment supprimer ce mandat id : "+itemId+" relatif à l'utilisateur : "+ trTag.children().first().text());
//     if (response == true)
//         deleteItem(itemId);
// });

// function deleteItem(id){

//     var route = site_url+"/api/mandat/"+id;
//     // var data = "class=Fugitif&property=id&value="+id;
    
//     performAjaxRequest(route, "DELETE", "json", "", onItemDeletionSuccess, onItemDeletionFailure, onItemDeletionCompletion);
// }

// function onItemDeletionSuccess(response, status){
//     if (status == "success"){
//         $("table tr[data-id='"+currentItemId+"']").remove();
//         toast("Item deleted successfully");
//     }
// }

// function onItemDeletionFailure(response, status, error){
//     console.log("Failed to delete item", response, status, error);

// }

// function onItemDeletionCompletion(response, status){
//     console.log("request completed");
// }