# jrum

This is simple discussion forum implemented in php + a relational database & xml.
<br>Check the wiki for details.


Instructions:

0. Place php files where they need to be.
1. Turn your mysql or mariaDB database on.
2. Change database details in db_handling.php.
3. Run the table creation scripts in other/sqlscripts.
4. Make sure whatever runs your php has rights to write files to disk at /topics
5. Make absolutely sure you have rights to write to /topics
6. #### Remember to check that you have rights to write
7. Just to make sure in case you don't have the correct rights, go look at the bottom of the database page in the wiki over here.
8. Everything should be working now.
9. Navigate to yoursite/index.php.
10. Create a user using the interface (input username and password & click sign up)
  <br>Manually flip the Moderator bit on for that user in your database
  <br>UPDATE fuser SET Moderator=1 WHERE Nickname='YOUR_USERNAME';
11. Create a new topic.
12. If you didn't have rights to write to '/topics' your computer will now hang.

index.php page. View of different discussions:
![Alt text](/other/index.jpg "index page")

disc.php page. View of posts in a discussion:
![Alt text](/other/disc.jpg "discussion page")
