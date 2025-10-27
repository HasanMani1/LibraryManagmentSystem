Guys when you pull the lastest version from your browser go to register.php and register yourself as an admin and after that when you login from user_login it will automatically understand that you are a admin and it will send you to admin dashboard from there you can
you can create as many users that you need for test purposes. And when you add and functionality that admin needs to see or manage basically everything add it to admin_dashboard.php with a single button so admin can also manage it. For example whoever will do the books part
he also needs to add "Manage Book" button for admin dashboard. If you have any questions let me know.

> ⚠️ NOTE:
> If any teammate modifies the database (new table, column, or data structure),
> they must export the updated `librarydb.sql` and push it to GitHub.
And then;
Go to phpMyAdmin

Delete the existing librarydb

Create a new one named librarydb again

Import the latest librarydb.sql from the repo
