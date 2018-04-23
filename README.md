# jrum

This is simple discussion forum implemented in php + a relational database & xml.
<br>Check the wiki for details.


Instructions:

0. Place php files where they need to be.
1. Turn your mysql or mariaDB database on.
2. Change database details in db_handling.php.
3. Run the table creation scripts in other/sqlscripts.
4. Make sure whatever runs your php has rights to write files to disk at /topics
5. Everything should be working now.
6. Navigate to yoursite/index.php.
7. Create a user using the interface (input username and password & click sign up)
  <br>Manually flip the Moderator bit on for that user in your database
  <br>UPDATE fuser SET Moderator=1 WHERE Nickname='YOUR_USERNAME';
