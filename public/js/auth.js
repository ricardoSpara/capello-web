$(document).ready(function() {

});

$('input[name="image"]').on('change', function() {
    let file = $(this)[0].files[0];
    if(file.name.endsWith('jpeg') || file.name.endsWith('jpg') || file.name.endsWith('png')) {
		getBase64(file);
    } else {
        alert('Insira um formato jpeg,jpg ou png');
    }

});

function getBase64(file) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function () {
		  $('#profilePic').css('background-image', 'url("'+reader.result+'")');
    };
    reader.onerror = function (error) {
      console.log('Error: ', error);
    };
 }