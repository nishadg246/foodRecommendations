
var count = [0, 0, 0, 0];
var pics = ['images/pizza.jpg','images/sand.jpg','images/tofu.jpg','images/burger.jpg'];
var pick = 0;
var counter=2;
var left=0;
var right=1;
var dat;
$.post("http://nishadg.com/food/query.php", function(data, status){
        dat=data;
    });


function go(){
	document.getElementById("go").style.visibility = 'hidden';
	var img1 = 	document.createElement("img");
	img1.width = 300;
	img1.height = 300;
	img1.style.border = "thick solid black";
	img1.src = pics[left];
	img1.style.margin = "50px 10px 20px 30px";
	pics.shift();
	var img2 = 	document.createElement("img");
	img2.width = 300;
	img2.height = 300;
	img2.style.border = "thick solid black";
	img2.src = pics[right];
	img2.style.margin = "50px 10px 20px 30px";
	pics.shift();
	var images = document.getElementById("images");
	images.appendChild(img1);  
	images.appendChild(img2);  
	$(document).bind('keyup', function(e){
    if(e.which == 39) {
    	pics.push(img1.src);
    		$(img1).fadeOut(300, function(){
      $(this).attr('src',pics[0]).bind('onreadystatechange load', function(){
         if (this.complete) $(this).fadeIn(300);
		 });
	  });
	  pics.shift();			
            }
    if(e.which == 37) {
        pics.push(img2.src);
    		$(img2).fadeOut(300, function(){
      $(this).attr('src',pics[0]).bind('onreadystatechange load', function(){
         if (this.complete) $(this).fadeIn(300);
		 });
	  });
	  pics.shift();	
    }
});
	/*
$(document).bind('keypress', function(e) {
            if(e.keyCode == 37) {
            	alert("hi");
                count[0]++;
			    pics.push(img1.src);
			    img1.src=pics[0];
			    pics.shift();
            }
            if(e.keyCode == 39) {
                count[1]++;
			    pics.push(img2.src);
			    img2.src=pics[0];
			    pics.shift();
            }
        });
*/
/*
img1.addEventListener("click",function(){
    count[0]++;
    pics.push(img1.src);
    img1.src=pics[0];
    pics.shift();
    
})
img2.addEventListener("click",function(){
    count[1]++;
    pics.push(img2.src);
    img2.src=pics[0];
    pics.shift();
})
*/
	     
}
