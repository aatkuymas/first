const express = require("express");
const bodyParser = require("body-parser");
const mysql = require("mysql");

const app = express();
const port = 3000;

// Database connection
const db = mysql.createConnection({
    host: "localhost",
    user: "your_username",
    password: "your_password",
    database: "your_database"
});

db.connect(err => {
    if (err) throw err;
    console.log("Connected to the database");
});

// Middleware
app.use(bodyParser.json());

// Signup route
app.post("/signup", (req, res) => {
    const { username, password } = req.body;
    
    // Insert into database
    const sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    db.query(sql, [username, password], (err, result) => {
        if (err) {
            console.error("Error:", err);
            res.json({ success: false });
        } else {
            console.log("User registered:", result);
            res.json({ success: true });
        }
    });
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
