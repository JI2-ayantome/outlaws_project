/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

const imagesContext = require.context('../img', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

const routes = require('../../public/resources/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

var localItems = [];
var currentPage = 0;
var excelRows = [];
var currentExcelRowIndex = 0;

fetchData("", "", 1);

export function performAjaxRequest(route, type, dataType, data, onRequestSuccess, onRequestFailure, onRequestCompletion){

    console.log(route, data);
  
      $.ajax({
  
            url       : 	route,
            dataType  : 	dataType,
            type      : 	type,
            data      : 	data,
            contentType:  "application/json",
            // headers   :   {"Authorization": "Bearer "+Cookies.get(TOKEN_COOKIE_NAME)},
            
            success   :   onRequestSuccess,
            error     : 	onRequestFailure,
            complete 	: 	onRequestCompletion,
  
      });
    
  }

export function fetchData(field, value, page){

    var route = Routing.generate('app_search_action')+"?field="+field+"&q="+value+"&page="+page;

    $("table tbody").empty();
    
    if ($(".spinner-border").length == 0){
      $("table").parent().append('<div class = "text-center pt-5">\
                                  <div class="spinner-border" role="status">\
                                      <span class="sr-only">Loading...</span>\
                                  </div>\
                                </div>');
    }
    
    performAjaxRequest(route, "GET", "json", "", onDataFetchSuccess, onDataFetchFailure, onDataFetchCompletion);
}

function onDataFetchSuccess(response, status){

  // saving the received data in a local javascript array

  localItems = response.mandats;
  currentPage = response.page;

  displayData(response, status);

  // removing possible spinners from the interface
  $(".spinner-border").parent().remove();

  $(".modal.show").modal("hide");
}

export function onDataFetchFailure(response, status, error){
  console.log("Failed to search data : ", response, status, error);
}

function onDataFetchCompletion(response, status){

}

function displayData(data, status){
    console.log(data);

    data.mandats.forEach(element => {
    
        $("table tbody").append('<tr data-id = "'+element.id+'" class = "">\
            <th scope="row">'+element.fugitif.nom+'</th>\
            <td>'+element.fugitif.prenoms+'</td>\
            <td>'+element.infractions+'</td>\
            <td>'+element.juridictions+'</td>\
            <td>\
                '+((!element.archived) ? '<img class = "delete_menu_action" style = "cursor: pointer;" src = "'+delete_icon+'" alt = "" width = "" height = "" title = "Supprimer"/>\
                <img class = "edit_menu_action" style = "cursor: pointer;" src = "'+edit_icon+'" alt = "" width = "" height = "" title = "Modifier" data-toggle="modal" data-target="#dataModal"/>' : '')
                +'\
            </td>\
        </tr>');

    });

    // $("ul.pagination .page-middle-item").remove();
    // console.log("");

    $("ul.pagination li:eq(1) > a").text(data.page);

    $(".spinner-border").parent().remove();
}

$("ul.pagination li:last").click(function(){
    var value = $("#searchModal #searchInput").val();
    var field = $("#searchModal #criteriaSelectTag").val();
    fetchData(field, value, parseInt(currentPage)+1)
});

$("ul.pagination li:first").click(function(){
    var value = $("#searchModal #searchInput").val();
    var field = $("#searchModal #criteriaSelectTag").val();
    fetchData(field, value, parseInt(currentPage)-1)
});

$("ul.pagination").on("click", "li.page-middle-item", function(){
    var field = "";
    var value = "";
    var page = $(this).children().first().text();
    fetchData(field, value, page);
});

var currentItemId = 0;



$("body").on("click", ".edit_menu_action", function(){

    // retrieve corresponding object
    var trTag = $(this).parents("tr");
    var itemId = trTag.attr("data-id");
    currentItemId = itemId;
    var object = getCurrentObject();

    $($(this).attr("data-target")).find("form").removeClass("add-data");
    $($(this).attr("data-target")).find("form").addClass("update-data");
    $($(this).attr("data-target")).find("form").attr("data-id", currentItemId);
    fillModalFormFields(object);
});

function fillModalFormFields(object){

    // fill the form's fields
    console.log(object);

    $("input[name='nom']").val(object.fugitif.nom);
    $("input[name='prenoms']").val(object.fugitif.prenoms);
    $("input[name='nommarital']").val(object.fugitif.prenoms);
    $("input[name='adresse']").val(object.fugitif.adresse);
    $("input[name='alias']").val(object.fugitif.alias);
    $("input[name='surnom']").val(object.fugitif.surnom);
    $("input[name='lieunaissance']").val(object.fugitif.lieuNaissance);
    $("input[name='datenaissance']").val(object.fugitif.dateNaissance);
    $("input[name='taille']").val(object.fugitif.taille);
    $("input[name='poids']").val(object.fugitif.poids);
    $("input[name='numerotelephone']").val(object.fugitif.numeroTelephone);
    $("textarea[name='observations']").val(object.fugitif.observations);
    // $("input[name='numeropieceid']").val(object.numeroPieceId);
    $("input[name='infractions']").val(object.infractions);
    $("input[name='chambres']").val(object.chambres);
    $("input[name='juridictions']").val(object.juridictions);
    $("input[name='reference']").val(object.reference);

    $("[name='typemandat'] option").attr("selected", false);
    $("[name='typemandat']").find("option[value='"+object.typeMandat.libelle+"']").attr("selected", true);

    $("[name='execute'] option").attr("selected", false);
    $("[name='execute']").find("option[value='"+object.execute+"']").attr("selected", true);

    $("[name='sexe'] option").attr("selected", false);
    $("[name='sexe']").find("option[value='"+object.fugitif.sexe+"']").attr("selected", true);

    if (object.fugitif.listeNationalites.length){
        $("[name='nationalite'] option").attr("selected", false);
        $("[name='nationalite']").find("option[value='"+(object.fugitif.listeNationalites[0]).nationalite.libelle+"']").attr("selected", true);
    }   
}

$("#btnSearch").click(function(){
    var criteria = $("#criteriaSelectTag").val();
    var criteriaValue = $("#searchInput").val();

    fetchData(criteria, criteriaValue, 1);
});

$("#btnInitiate").click(function(){
    $("#searchInput").val("");
    $("#criteriaSelectTag option[value='all']").attr("selected", true);

    $("table tbody").empty();
});

$("body").on("click", ".delete_menu_action", function(){

    var trTag = $(this).parents("tr");
    var itemId = trTag.attr("data-id");
    currentItemId = itemId;
    var response = confirm("Voulez vous vraiment supprimer ce mandat id : "+itemId+" relatif à l'utilisateur : "+ trTag.children().first().text());
    if (response == true)
        deleteItem(itemId);
});

function deleteItem(id){

    var route = Routing.generate("app_warrant_deletion_action", {"id": id});
    // var data = "class=Fugitif&property=id&value="+id;
    
    performAjaxRequest(route, "DELETE", "json", "", onItemDeletionSuccess, onItemDeletionFailure, onItemDeletionCompletion);
}

function onItemDeletionSuccess(response, status){
    if (status == "success"){
        console.log("");
        $("table tr[data-id='"+currentItemId+"']").remove();
        toast("Item deleted successfully");
    }
}

function onItemDeletionFailure(response, status, error){
    console.log("Failed to delete item", response, status, error);

}

function onItemDeletionCompletion(response, status){
    console.log("request completed");
}




$("#btnSave").click(function(e){
    e.preventDefault();
    
    var form = $("#dataModal form");

    // if (!formValidated(form))
    //     return;

    if (form.hasClass("update-data"))
        updateData(form);
    else if (form.hasClass("add-data"))
        addData(form);
});

function formValidated(form){
    var telExpr = /((\d){2}-){3}(\d){2}/;
    var numeroTelephone = form.find("[name='numerotelephone']").val();
    console.log(numeroTelephone);
    if (numeroTelephone != "" && telExpr.test(numeroTelephone)){
        form.find("[name='numerotelephone']").addClass("is-invalid");
        return false;
    }
}

function updateData(form){


    var object = getCurrentObject();
    console.log("--------------", object);
    var route = Routing.generate("app_update_warrant_action", {"id": object.id});
    var data = JSON.stringify(getJsonObject(form));

    performAjaxRequest(route, "PUT", "json", data, onDataUpdateSuccess, onDataUpdateFailure, onDataUpdateCompletion);
}

function onDataUpdateSuccess(response, status){
    console.log("OK : ", response);
    if (status == "success"){
        $(".modal.show").modal("hide");
        toast("Données modifiés avec succès");
    }
}

function onDataUpdateFailure(response, status, error){
    console.log(response, status);
}

function onDataUpdateCompletion(response, status){
    console.log("Ajax request completed");
}


function addData(form){
    var route = Routing.generate("app_add_warrant_action");
    var data = JSON.stringify(getJsonObject(form));

    performAjaxRequest(route, "POST", "json", data, onDataAdditionSuccess, onDataAdditionFailure, onDataAdditionCompletion);
}

function onDataAdditionSuccess(response, status){
    console.log("OK : ", response);
    if (status == "success"){
        $(".modal.show").modal("hide");
        toast("Ajout effectué avec succès");
    }
}

function onDataAdditionFailure(response, status, error){
    console.log(response, status);
    toast("Une erreur s'est produite!");
}

function onDataAdditionCompletion(response, status){
    console.log("Ajax request completed");
}

function getJsonObject(form){

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy+"-"+mm+"-"+dd;

    // var jsonObject = 
    // {
    //     "nom": form.find("[name='nom']").val(),
    //     "prenoms": form.find("[name='prenoms']").val(),
    //     "nomMarital": "",
    //     "alias": form.find("[name='alias']").val(),
    //     "surnom": form.find("[name='surnom']").val(),
    //     "dateNaissance": ((form.find("[name='datenaissance']").val() == "") ? null : form.find("[name='datenaissance']").val()),
    //     "lieuNaissance": form.find("[name='lieunaissance']").val(),
    //     "adresse": form.find("[name='adresse']").val(),
    //     "taille": null,
    //     "poids": null,
    //     "couleurYeux": null,
    //     "couleurPeau": null,
    //     "couleurCheveux": null,
    //     "photoName": null,
    //     "photoSize": null,
    //     "sexe": form.find("[name='sexe']").val(),
    //     "numeroPieceID": form.find("[name='numeropieceid']").val(),
    //     "numeroTelephone": form.find("[name='numerotelephone']").val(),
    //     "observations": form.find("[name='observations']").val(),
    //     "mandats": [
    //         {
    //             "reference": form.find("[name='reference']").val(),
    //             "execute": ((form.find("[name='execute']").val() == "oui") ? true : false),
    //             "infractions": form.find("[name='infractions']").val(),
    //             "chambres": form.find("[name='chambres']").val(),
    //             "juridictions": form.find("[name='juridictions']").val(),
    //             "archived" : false,
    //             "typeMandat": {
    //                 "libelle": form.find("[name='typemandat']").val()
    //             },
    //             "dateEmission": ((form.find("[name='dateemission']").val() == "") ? today : form.find("[name='dateemission']").val())
    //         }
    //     ],
    //     "listeNationalites": [
    //         {
    //             "nationalite": {
    //                 "libelle": form.find("[name='nationalite']").val()
    //             },
    //             "principale": true
    //         }
    //     ]
    // };

    var jsonObject = 
                        {
                            "reference":form.find("[name='reference']").val(),
                            "execute":((form.find("[name='execute']").val() == "oui") ? true : false),
                            "infractions":form.find("[name='infractions']").val(),
                            "chambres":form.find("[name='chambres']").val(),
                            "juridictions":form.find("[name='juridictions']").val(),
                            "typeMandat":{
                                "libelle":form.find("[name='typemandat']").val()
                            },
                            "fugitif":{
                                "nom":form.find("[name='nom']").val(),
                                "prenoms":form.find("[name='prenoms']").val(),
                                "nomMarital":form.find("[name='nommarital']").val(),
                                "alias":form.find("[name='surnom']").val(),
                                "surnom":form.find("[name='surnom']").val(),
                                "dateNaissance":((form.find("[name='datenaissance']").val() == "") ? null : form.find("[name='datenaissance']").val()),
                                "lieuNaissance":form.find("[name='lieunaissance']").val(),
                                "adresse":form.find("[name='adresse']").val(),
                                "taille":((form.find("[name='taille']").val()) ? 0 : parseFloat(form.find("[name='taille']").val())),
                                "poids":((form.find("[name='poids']").val() == "") ? 0 :  parseFloat(form.find("[name='poids']").val())),
                                "couleurYeux":null,
                                "couleurPeau":null,
                                "couleurCheveux":null,
                                "photoName":null,
                                "photoSize":null,
                                "sexe":form.find("[name='sexe']").val(),
                                "numeroTelephone":form.find("[name='numerotelephone']").val(),
                                "observations":form.find("[name='observation']").val(),
                                "listeNationalites":[{
                                    "nationalite":{
                                        "libelle":form.find("[name='nationalite']").val()
                                    },
                                    "principale": true
                                }],
                                "langues":form.find("[name='langues']").val()
                            },
                            "dateEmission":((form.find("[name='dateemission']").val() == "") ? today : form.find("[name='dateemission']").val()),
                            "archived":false
                        };
    console.log("test", jsonObject);
    return jsonObject;
}

$("#dropdown-item-add").click(function(){

    // clearing modal fields before displaying it
    var modal = $($(this).attr("data-target"));

    modal.find("input.form-control").val("");

    $($(this).attr("data-target")).find("form").removeClass("update-data");
    $($(this).attr("data-target")).find("form").addClass("add-data");
});

function getCurrentObject(){

  var object = null;
  console.log("before : ", currentItemId, localItems);
    for (let i = 0; i < localItems.length; i++) {
        var mandat = (localItems[i]);
        if (mandat.id == currentItemId){
            object = mandat;
            break;
       }
    }
  return object;
}

function toast(message) {

  var snackbar = $("#snackbar");
  snackbar.text(message);
  snackbar.addClass("show");

  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ snackbar.removeClass("show"); }, 3000);
} 



$("#loginModal .form-control").on("keypress", function(){
  $(this).removeClass("is-invalid");
});

$("#btnImport").click(function(){

    if(!$(this).hasClass("disabled")){

        var modal = $(this).parents(".modal");

        // disabling the file iput tag
        modal.find("input").attr("readonly", true);

        $("#dataImportModal button.close").addClass("d-none");

        // starting the progressbar
        modal.find(".progress").removeClass("d-none");

        $(this).addClass("disabled");

        readExcelFile();
    }


});

function readExcelFile(){

    var fileUpload = document.getElementById("excelFileInput");
    if (typeof (FileReader) != "undefined") {
        var reader = new FileReader();

        //For Browsers other than IE.
        if (reader.readAsBinaryString) {
            reader.onload = function (e) {
                processExcel(e.target.result);
            };
            reader.readAsBinaryString(fileUpload.files[0]);
        } else {
            //For IE Browser.
            reader.onload = function (e) {
                var data = "";
                var bytes = new Uint8Array(e.target.result);
                for (var i = 0; i < bytes.byteLength; i++) {
                    data += String.fromCharCode(bytes[i]);
                }
                processExcel(data);
            };
            reader.readAsArrayBuffer(fileUpload.files[0]);
        }
    } else {
        alert("This browser does not support HTML5.");
    }

}

function processExcel(data) {
    //Read the Excel File data.
    var workbook = XLSX.read(data, {
        type: 'binary'
    });

    //Fetch the name of First Sheet.
    var firstSheet = workbook.SheetNames[0];

    //Read all rows from First Sheet into an JSON array.
    excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);

    //Add the data rows from Excel file.
    // console.log(excelRows);
    if (excelRows.length){
        submitJsonObject(0);
    }
};

function submitJsonObject(index){

    currentExcelRowIndex = index;
    var jsonObject = excelRows[index];

    console.log("before", jsonObject);
    var warrant = getWarrantFromRow(jsonObject);
    console.log("after", warrant);

    var data = JSON.stringify(warrant);
    var route = Routing.generate("app_add_warrant_action");
    performAjaxRequest(route, "POST", "json", data, onExcelDataAdditionSuccess, onDataAdditionFailure, onDataAdditionCompletion);

}

function onExcelDataAdditionSuccess(response, status){

    console.log("OK : ", response);
    if (status == "success"){
        
        // updates the progressbar
        var percentage = (currentExcelRowIndex*100)/excelRows.length;
        $(".progress-bar").attr("aria-valuenow", percentage);
        $(".progress-bar").css("width",percentage+"%");

        currentExcelRowIndex++;
        if (currentExcelRowIndex < excelRows.length)
            submitJsonObject(currentExcelRowIndex);
    }

}

function getWarrantFromRow(jsonObject){

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy+"-"+mm+"-"+dd;

    var result = 
                    {
                        "reference":((jsonObject.no_ordre == undefined) ? "" : jsonObject.no_ordre),
                        "execute":((jsonObject.en_fuite == "1") ? false : true),
                        "infractions":((jsonObject.infraction == undefined) ? "" : jsonObject.infraction),
                        "chambres":((jsonObject.cabinet_chambre == undefined) ? "" : jsonObject.cabinet_chambre),
                        "juridictions":((jsonObject.juridiction == undefined) ? "" : jsonObject.juridiction),
                        "typeMandat":{
                            "libelle":(((jsonObject.type_mandat == undefined) || (jsonObject.type_mandat == "")) ? "ND" : jsonObject.type_mandat)
                        },
                        "fugitif":{
                            "nom":((jsonObject.nom == undefined) ? "" : jsonObject.nom),
                            "prenoms":((jsonObject.prenom == undefined) ? "" : jsonObject.prenom),
                            "nomMarital":((jsonObject.nom_marital == undefined) ? "" : jsonObject.nom_marital),
                            "alias":((jsonObject.alias == undefined) ? "" : jsonObject.alias),
                            "surnom":((jsonObject.surnom == undefined) ? "" : jsonObject.surnom),
                            "dateNaissance":(((jsonObject.date_naissance == undefined) || (jsonObject.date_naissance == "") ) ? null : jsonObject.date_naissance),
                            "lieuNaissance":((jsonObject.lieu_naissance == undefined) ? "" : jsonObject.lieu_naissance),
                            "adresse":((jsonObject.adresse == undefined) ? "" : jsonObject.adresse),
                            "taille":((jsonObject.taille == undefined) ? 0 : jsonObject.taille),
                            "poids":((jsonObject.poids == undefined) ? 0 : jsonObject.poids),
                            "couleurYeux":((jsonObject.couleur_yeux == undefined) ? ""  : jsonObject.couleur_yeux),
                            "couleurPeau":((jsonObject.couleur_peau == undefined) ? "" : jsonObject.couleur_peau),
                            "couleurCheveux":((jsonObject.couleur_cheveux == undefined) ? "" : jsonObject.couleur_cheveux),
                            "photoName":null,
                            "photoSize":null,
                            "sexe":((jsonObject.sexe == undefined) ? "" : jsonObject.sexe),
                            "numeroTelephone":"",
                            "observations":((jsonObject.observations == undefined) ? "" : jsonObject.observations),
                            "listeNationalites":[{
                                "nationalite":{
                                    "libelle":((jsonObject.nationalite == undefined) ? "" : jsonObject.nationalite)
                                },
                                "principale": true
                            }],
                            "langues":((jsonObject.langue_parlee == undefined) ? "" : jsonObject.langue_parlee)
                        },
                        "dateEmission":(((jsonObject.date_emission == undefined)||(jsonObject.date_emission == "")) ? today : jsonObject.date_emission),
                        "archived":false
                    };
    return result;
}


$("#excelFileInput").change(function(){
    var fileName = $(this).val().split("\\").pop();
    console.log(fileName);
    $(this).next().html(fileName);

    var extension = fileName.split(".")[1];
    if (extension != "xlsx"){
        $(this).parent().find(".invalid-feedback").text("Le fichier soumis ne répond pas aux critères");
        $(this).addClass("is-invalid");
        if(!$("#btnImport").hasClass("disabled")){
            $("#btnImport").addClass("disabled");
        }
    }
    else{
        $(this).removeClass("is-invalid");
        $(this).addClass("is-valid");
        $("#btnImport").removeClass("disabled");
    }
});