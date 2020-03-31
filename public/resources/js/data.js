// /**
//  * 
//  * 
//  * 
//  */

// // fetching entities such as Nationalite
// fetchEntities("Nationalite");

// // fetching entities such as TypeMandat
// fetchEntities("TypeMandat");

// function fetchEntities(className){
//     var route = site_url+"/api/"+className;

//     performAjaxRequest(route, "GET", "json", "", onEntitiesFetchedSuccess, onEntitiesFetchedFailure, onEntitiesFetchedCompletion);
// }

// function onEntitiesFetchedSuccess(response, status){
//     if (status == "success"){
//         var className = response.className.split("\\");
//         className = className[className.length-1];
//         if (className == "Nationalite"){
//             displayEntities(className, response.objects);
//         }
//         if (className == "TypeMandat"){
//             displayEntities(className, response.objects);
//         }
//     }
// }

// function onEntitiesFetchedFailure(response, status, error){
// }

// function onEntitiesFetchedCompletion(response, status){
//     // console.log("request completed");
// }

// function displayEntities(className, objects){

//     if (className == "Nationalite"){
//         var tag = $("#selectTagNationalite");
//         tag.empty();
        
//         objects.forEach(element => {
//             tag.append('<option value = "'+element.libelle+'">'+element.libelle+'</option>');
//         });
//     }

//     if (className == "TypeMandat"){
//         var tag = $("#selectTagTypeMandat");
//         tag.empty();

//         objects.forEach(element => {
//             tag.append('<option value = "'+element.libelle+'">'+element.libelle+'</option>');
//         });
//     }
// }

// $("#btnSave").click(function(e){
//     e.preventDefault();
    
//     var form = $("#dataModal form");

//     if (form.hasClass("update-data"))
//         updateData(form);
//     else if (form.hasClass("add-data"))
//         addData(form);
// });

// function updateData(form){


//     var object = getCurrentObject();
//     console.log("--------------", object);
//     var route = site_url+"/api/fugitif/"+object.id;
//     var data = JSON.stringify(getJsonObject(form));

//     performAjaxRequest(route, "PUT", "json", data, onDataUpdateSuccess, onDataUpdateFailure, onDataUpdateCompletion);
// }

// function onDataUpdateSuccess(response, status){
//     console.log("OK : ", response);
//     if (status == "success"){
//         $(".modal.show").modal("hide");
//         toast("data updated successfully");
//     }
// }

// function onDataUpdateFailure(response, status, error){
//     console.log(response, status);
// }

// function onDataUpdateCompletion(response, status){
//     console.log("Ajax request completed");
// }


// function addData(form){
//     var route = site_url+"/api/fugitif";
//     var data = JSON.stringify(getJsonObject(form));

//     performAjaxRequest(route, "POST", "json", data, onDataAdditionSuccess, onDataAdditionFailure, onDataAdditionCompletion);
// }

// function onDataAdditionSuccess(response, status){
//     console.log("OK : ", response);
//     if (status == "success"){
//         $(".modal.show").modal("hide");
//         toast("data added successfully");
//     }
// }

// function onDataAdditionFailure(response, status, error){
//     console.log(response, status);
// }

// function onDataAdditionCompletion(response, status){
//     console.log("Ajax request completed");
// }

// function getJsonObject(form){

//     var today = new Date();
//     var dd = String(today.getDate()).padStart(2, '0');
//     var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
//     var yyyy = today.getFullYear();

//     today = yyyy+"-"+mm+"-"+dd;

//     var jsonObject = 
//     {
//         "nom": form.find("[name='nom']").val(),
//         "prenoms": form.find("[name='prenoms']").val(),
//         "nomMarital": "",
//         "alias": form.find("[name='alias']").val(),
//         "surnom": form.find("[name='surnom']").val(),
//         "dateNaissance": ((form.find("[name='datenaissance']").val() == "") ? null : form.find("[name='datenaissance']").val()),
//         "lieuNaissance": form.find("[name='lieunaissance']").val(),
//         "adresse": form.find("[name='adresse']").val(),
//         "taille": null,
//         "poids": null,
//         "couleurYeux": null,
//         "couleurPeau": null,
//         "couleurCheveux": null,
//         "photoName": null,
//         "photoSize": null,
//         "sexe": form.find("[name='sexe']").val(),
//         "numeroPieceID": form.find("[name='numeropieceid']").val(),
//         "numeroTelephone": form.find("[name='numerotelephone']").val(),
//         "observations": form.find("[name='observations']").val(),
//         "mandats": [
//             {
//                 "reference": form.find("[name='reference']").val(),
//                 "execute": ((form.find("[name='execute']").val() == "oui") ? true : false),
//                 "infractions": form.find("[name='infractions']").val(),
//                 "chambres": form.find("[name='chambres']").val(),
//                 "juridictions": form.find("[name='juridictions']").val(),
//                 "archived" : false,
//                 "typeMandat": {
//                     "libelle": form.find("[name='typemandat']").val()
//                 },
//                 "dateEmission": ((form.find("[name='dateemission']").val() == "") ? today : form.find("[name='dateemission']").val())
//             }
//         ],
//         "listeNationalites": [
//             {
//                 "nationalite": {
//                     "libelle": form.find("[name='nationalite']").val()
//                 },
//                 "principale": true
//             }
//         ]
//     };
//     console.log("test", jsonObject);
//     return jsonObject;
// }

// $("#dropdown-item-add").click(function(){

//     // clearing modal fields before displaying it
//     var modal = $($(this).attr("data-target"));

//     modal.find("input.form-control").val("");

//     $($(this).attr("data-target")).find("form").removeClass("update-data");
//     $($(this).attr("data-target")).find("form").addClass("add-data");
// });
