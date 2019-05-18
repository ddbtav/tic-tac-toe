# Tic-Tac-Toe game
Browser game written in PHP.

Requires MySQL for user registration and login.

## Features

- Users registration and login.

- Play against other human player or computer.

- Board sizes: 3x3, 4x4, 5x5.

- Play session statistics.



## Database

Create "tic-tac-toe" database and use users.sql file to import structure of the users table.

Create dbaccess.php file in your project root folder with your database access settings. (See  dbaccess_example.php for reference.)

You may also need to change host ('localhost' by default) in createPdo() function in functions.php file. 
