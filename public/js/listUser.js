
/* Jquery version

$(function(){
	$.get(
		'/users.json'
	).done(function(data){
		let table = $('<table class="table table-striped"></table>');
		let head = $('<thead><tr><th>id</th><th>name</th></tr></thead>');
		let body = $('<tbody></tbody>');

		data.forEach(function(user){
			body.append($('<tr><td>'+user.id+'</td><td>'+user.name+'</td></tr>'));
		});
		
		table.append(head).append(body);
		$('#userListContainer').empty().append(table);
	}).fail(function(){
		$('#userListContainer').empty().html("An error occured");
	});
});

 */

function createTableHead()
{
	let tableHead = document.createElement("thead");
	let headLine = document.createElement("tr");
	
	let headId = document.createElement("th");
	headId.appendChild(document.createTextNode("id"));
	headLine.appendChild(headId);
	
	let headName = document.createElement("th");
	headName.appendChild(document.createTextNode("name"));
	headLine.appendChild(headName);
	
	tableHead.appendChild(headLine);
	
	return tableHead;
}

function createUserRow(user)
{
	let element = document.createElement("tr");
	for (let property in user) {
		let cell = document.createElement("td");
		
		let content = document.createTextNode(user[property]); 
		cell.appendChild(content);
		element.appendChild(cell);
	}
	
	return element;
}

function loadUsers(){
	let req = new XMLHttpRequest();
	
	req.onreadystatechange = function(event) {
	    if (this.readyState === XMLHttpRequest.DONE) {
			document.getElementById("userListContainer").innerHTML = "";
			
	        if (this.status === 200 && this.getResponseHeader("Content-Type") == "application/json" ) {
	        	let users = JSON.parse(this.responseText);
	        	
	        	let list = document.createElement("table");
	        	list.className = "table table-striped";

        		list.appendChild(createTableHead());

        		let tableBody = document.createElement("tbody");
        		users.forEach(function(user){
		        	tableBody.appendChild(createUserRow(user));
        		});

        		list.appendChild(tableBody);
        		
	        	document.getElementById("userListContainer").appendChild(list);
	        } else {
        		let content = document.createTextNode("An error occured"); 
	        	document.getElementById("userListContainer").appendChild(content);
	        }
	    }

	};
	
	req.open('GET', Routing.generate('admin_user_list'), true); 
	req.send(null);
	
}

document.addEventListener("DOMContentLoaded", loadUsers);