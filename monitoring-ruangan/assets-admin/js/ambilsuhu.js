const mysql = window.mysql2; 
 
// Create a connection to the database 
const connection = mysql.createConnection({ 
  host: 'localhost', 
  user: 'root', 
  password: '', 
  database: 'cabdinjo' 
}); 
 
// Connect to the database 
connection.connect((err) => { 
  if (err) { 
    console.error('Error connecting to the database:', err); 
    return; 
  } 
  console.log('Connected to the database.'); 
 
  // Fetch data from a specific column 
  const query = 'SELECT suhu FROM sensor'; 
  connection.query(query, (err, results) => { 
    if (err) { 
      console.error('Error fetching data:', err); 
      return; 
    } 
 
    // Process results 
    results.forEach(row => { 
      console.log(row.suhu); 
    }); 
 
    // Close the connection 
    connection.end((err) => { 
      if (err) { 
        console.error('Error closing the connection:', err); 
      } else { 
        console.log('Connection closed.'); 
      } 
    }); 
  }); 
});