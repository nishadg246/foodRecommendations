var count = [0, 0, 0, 0, 0, 0, 0, 0,0, 0];

var pick = 0;
var counter=2;

var left=0;
var right=1;


var dat;
var pics=[];
var names=[];
var types=[];
var num=[];
var loc=[];
var add=[];

$.post("http://nishadg.com/food/query_TEST.php", function(data, status){
        dat=JSON.parse(data);
        for (i = 1; i < 11; i++){
    		pics.push( dat["image"][i]);
    		names.push(dat["names"][i]);
    		types.push(dat["type"][i]);
    		loc.push(dat["location"][i]);
    		num.push(dat["phone"][i])
    		add.push(dat["address"][i])

		}
		});

var img1 = 	document.createElement("img");
var img2 = 	document.createElement("img");

function go(){
	document.getElementById("go").style.visibility = 'hidden';
	img1.width = 300;
	img1.height = 300;
	img1.style.border = "thick solid black";
	img1.src = pics[left];
	img1.style.margin = "50px 10px 20px 30px";
	img2.width = 300;
	img2.height = 300;
	img2.style.border = "thick solid black";
	img2.src = pics[right];
	img2.style.margin = "50px 10px 20px 30px";
	var images = document.getElementById("images");
	images.appendChild(img1);  
	images.appendChild(img2);  
	$(document).bind('keyup', function(e){
    if(counter<11){
    if(e.which == 39) {
    	
    		$(img1).fadeOut(300, function(){
    			pick=right;
    			left=counter;
    			counter++;
      $(this).attr('src',pics[left]).bind('onreadystatechange load', function(){
         if (this.complete) $(this).fadeIn(300);
		 });
	  });
	  
            }
    //left
    if(e.which == 37) {
        pick=left;
    	right=counter;
    	counter++;
    		$(img2).fadeOut(300, function(){
      $(this).attr('src',pics[right]).bind('onreadystatechange load', function(){
         if (this.complete) $(this).fadeIn(300);
		 });
	  });
    }
}
   if(counter==11){
	end2();
	counter++;
   }

});	     
}

function end2(){
	var images = document.getElementById("images");
	var data = document.getElementById("dir");
	$(images).delay(400).fadeOut();
	$(dir).empty();
	var words = document.getElementById("words");
	$(words).find("h2").delay( 800 ).animate({opacity:0},function(){
        $(this).text(names[pick])
            .animate({opacity:1});  
    })
    $(words).find("p").delay( 800 ).animate({opacity:0},function(){
        $(this).text(types[pick])
            .animate({opacity:1});
        accept = document.createElement("button");
		accept.innerHTML = 'Lets Go Here';
		accept.style.margin = "0px 10px 20px 30px";
		accept.className = "button special";
		accept.onclick = function(){
			previous(1);
			accept.style.display="none";
			reject.style.display="none";};
		words.appendChild(accept);
		reject = document.createElement("button");
		reject.innerHTML = 'Not Here Please';
		reject.className = "button special";
		reject.style.margin = "0px 10px 20px 30px";
		reject.onclick = function(){
			previous(-1);
			// accept.style.display="none";
			// reject.style.display="none";
			window.location = "http://nishadg.com/food";
		};
		words.appendChild(reject);
		var linebreak = document.createElement('br');
		words.appendChild(linebreak);	
        var t = document.createTextNode(add[pick][0]+"\n"+add[pick][1]+"\n"+add[pick][2]);
        words.appendChild(t);
        var linebreak = document.createElement('br');
		words.appendChild(linebreak);
        var s = document.createTextNode(num[pick].substring(0, 3)+"-"+num[pick].substring(3, 6)+"-"+num[pick].substring(6, 10));
        var linebreak = document.createElement('br');
		words.appendChild(linebreak);
        //t.style.fontSize = "large";
		words.appendChild(s);
        document.getElementById("dir").innerHTML='<iframe width="400" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCe9-YPrPW7AbxVSdvctjo1YFICv-BoQ70&q='+String(loc[pick].latitude)+','+String(loc[pick].longitude)+'"'+ 'allowfullscreen></iframe>';
    	
    })
}

function previous(i){
	$.ajax({
type: 'post',
url: 'previous.php',
data: {arg1: names[pick], arg2: i, arg3: types[pick]}
});
  }

