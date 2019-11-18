<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
    <h1>Пример работы с WebSocket</h1>
    <form action="" name="messages">
        <div class="row">Имя: <input type="text" name="fname"></div>
        <div class="row">Текст: <input type="text" name="msg"></div>
        <div class="row"><input type="submit" value="Поехали"></div>
    </form>
    <div id="status"></div>

	<script>


		window.onload = function() {

	        var socket = new WebSocket("ws://localhost:8080");
	        var status = document.querySelector("#status");
	        console.log(socket)
	        
	        socket.onopen = function() {
	          status.innerHTML = "cоединение установлено<br>";
	        };

	        socket.onclose = function(event) {
	          if (event.wasClean) {
	            status.innerHTML = 'cоединение закрыто';
	          } else {
	            status.innerHTML = 'соединения как-то закрыто';
	          }
	          status.innerHTML += '<br>код: ' + event.code + ' причина: ' + event.reason;
	        };

	        socket.onmessage = function(event) {
	          let message = JSON.parse(event.data);    
	          status.innerHTML += `пришли данные: <b>${message.name}</b>: ${message.msg}<br>`;
	        };

	        socket.onerror = function(event) {
	           status.innerHTML = "ошибка " + event.message;
	        };
	        document.forms["messages"].onsubmit = function(){
	            let message = {
	                 name:this.fname.value,
	                 msg: this.msg.value
	            }
	            socket.send(JSON.stringify(message));
	            return false;
	        }

        
    }
		


	</script>
</body>
</html>