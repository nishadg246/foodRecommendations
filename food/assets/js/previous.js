var dat;
$.post("http://nishadg.com/food/get.php", function(data, status){
        dat=JSON.parse(data);
        var tablearea = document.getElementById('tablearea'),
    table = document.createElement('table');

for (var i = 0; i < dat.length; i++) {
    var tr = document.createElement('tr');

    tr.appendChild( document.createElement('td') );
    tr.appendChild( document.createElement('td') );
    if(dat[i][1]==='-1'){
        tr.cells[0].appendChild( document.createTextNode(dat[i][0]) )
        tr.cells[1].appendChild( document.createTextNode("Disliked") );
        tr.cells[1].style.color = "red";
    }else{
        tr.cells[0].appendChild( document.createTextNode(dat[i][0]) )
        tr.cells[1].appendChild( document.createTextNode("Liked") );
        tr.cells[1].style.color = '#7FFF00';
    }
    tr.cells[0].style.fontSize = '150%'
    tr.cells[1].style.fontSize = '150%'
    table.appendChild(tr);
}

tablearea.appendChild(table);
		});

