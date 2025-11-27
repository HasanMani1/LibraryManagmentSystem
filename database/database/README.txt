Hey team 👋 I’ve got good news!
I created the database and uploaded it to GitHub, so now when you pull the code, you’ll also get the database file.

When anyone makes changes to the database and pushes them back, the GitHub version will be updated — so when we pull again, we’ll all have the latest version of the DB.

Here’s what you need to do 👇

⚙️ Setup Steps

Make sure you have XAMPP installed.

Open XAMPP Control Panel → Start Apache and MySQL.

Open your browser and go to:
👉 http://localhost/phpmyadmin/

Click New → create a new database named librarydb (important — must match exactly).

Click Import → choose the .sql file from the project folder on GitHub.

It should be something like /database/librarydb.sql

Click Go — done ✅
You now have the same database that I created.

🔁 When you make updates

If you change the database (like adding a new table, column, or record):

Export the updated version from phpMyAdmin.

Replace the old .sql file in the GitHub repo.

Commit and push your changes.

That way, the next time anyone pulls the project, they’ll get the latest database version automatically.

💡 Tip

Always remember to run Apache and MySQL in XAMPP before testing or importing the DB.

✅ That’s it! We’ll all stay synced with the same librarydb easily.
