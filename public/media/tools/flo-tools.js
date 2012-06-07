/*Flo Tools v.001
 */

/**
 * Function wich print out messages from jquery
 */
function newAlert (type, message) {
 			    $("#alert-area").html($("<div class='alert alert-" + type + " '><a class='close' data-dismiss='alert' href='#'>×</a><p>" + message + " </p></div>"));
}