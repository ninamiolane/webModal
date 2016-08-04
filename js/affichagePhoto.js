/*
window.setInterval("Couleur()",10000);
var i = 1;
function Couleur() {
  if(i==1)
      $("img#photoGauche").attr("src", "./photos/image1.jpg");
  else if(i==2)
      $("img#photoGauche").attr("src", "./photos/image2.jpg");
  else if(i==3)
      $("img#photoGauche").attr("src", "./photos/image3.jpg");
  else if(i==4)
      $("img#photoGauche").attr("src", "./photos/image4.jpg");
  else if(i==5)
      $("img#photoGauche").attr("src", "./photos/image5.jpg");
  i++;
  if(i >= 5)
      i=1;
}
*/

$(document).ready(function() {
    $('.slideshow').cycle({
        fx: 'fade',
        speed:    4000,
        timeout:  8000,
        random:1
    });
});

$(document).ready(function() {
    $('.slideshow2').cycle({
        fx: 'fade',
        speed:    4000,
        timeout:  10000,
        random:1
    });
});