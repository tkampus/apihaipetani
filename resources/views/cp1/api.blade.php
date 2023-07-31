<!DOCTYPE html>
<html>

<head>
   <title>API Tester</title>
   <style>
      body {
         font-family: Arial, sans-serif;
         margin: 20px;
      }

      h1 {
         margin-bottom: 20px;
      }

      .form-group {
         margin-bottom: 10px;
      }

      label {
         display: block;
         margin-bottom: 5px;
      }

      input[type="text"],
      select,
      textarea {
         width: 100%;
         padding: 5px;
         border: 1px solid #ccc;
         border-radius: 5px;
         box-sizing: border-box;
      }

      button {
         background-color: #007bff;
         color: #fff;
         border: none;
         padding: 10px 20px;
         border-radius: 5px;
         cursor: pointer;
      }

      .response {
         margin-top: 20px;
         border: 1px solid #ccc;
         padding: 10px;
      }
   </style>
</head>

<body>
   <h1>API Tester</h1>
   <form id="apiTesterForm"> <!-- Tambahkan form tag dengan id apiTesterForm -->
      <div class="form-group">
         <label for="url">URL:</label>
         <input type="text" id="url" name="url" placeholder="Enter API URL"> <!-- Tambahkan name attribute untuk setiap input -->
      </div>
      <div class="form-group">
         <label for="method">Method:</label>
         <select id="method" name="method"> <!-- Tambahkan name attribute untuk setiap input -->
            <option value="GET">GET</option>
            <option value="POST">POST</option>
            <option value="PUT">PUT</option>
            <option value="DELETE">DELETE</option>
         </select>
      </div>
      <div class="form-group">
         <label for="token">Token:</label>
         <input type="text" id="token" name="token" placeholder="Enter token"> <!-- Tambahkan name attribute untuk setiap input -->
      </div>
      <div class="form-group">
         <label for="headers">Headers:</label>
         <textarea id="headers" name="headers" placeholder="Enter headers (e.g., Content-Type: application/json)"></textarea> <!-- Tambahkan name attribute untuk setiap input -->
      </div>
      <div class="form-group">
         <label for="body">Body:</label>
         <textarea id="body" name="body" placeholder="Enter request body"></textarea> <!-- Tambahkan name attribute untuk setiap input -->
      </div>
      @csrf
      <button type="button" onclick="sendRequest()">Send Request</button> <!-- Tambahkan type="button" agar tidak submit secara default -->
   </form> <!-- Akhiri form tag -->
   <div class="response">
      <h3>Response:</h3>
      <pre id="response"></pre>
   </div>
   <div class="response">
      <h3>Response:</h3>
      <pre id="response"></pre>

      <!-- Tampilkan gambar jika ada -->
      <img id="gambar_pesan" src="data:image/jpeg;base64,QzpceGFtcHBcdG1wXHBocDM2OTcudG1w" style="max-width: 400px;">
   </div>

   <script>
      function sendRequest() {
         const formData = new FormData(document.getElementById('apiTesterForm')); // Ambil semua data dari form
         const requestOptions = {
            method: formData.get('method'),
            headers: parseHeaders(formData.get('headers')),
            body: formData.get('body')
         };

         const token = formData.get('token');
         if (token) {
            requestOptions.headers['Authorization'] = `Bearer ${token}`;
         }

         fetch(formData.get('url'), requestOptions)
            .then(response => response.json())
            .then(data => {
               document.getElementById('response').textContent = JSON.stringify(data, null, 2);
            })
            .catch(error => {
               document.getElementById('response').textContent = error.message;
            });
      }

      function parseHeaders(headersString) {
         const headers = {};
         const lines = headersString.split('\n');
         lines.forEach(line => {
            const parts = line.split(':');
            if (parts.length === 2) {
               const key = parts[0].trim();
               const value = parts[1].trim();
               headers[key] = value;
            }
         });
         return headers;
      }
   </script>
</body>

</html>